<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReasonRequest;
use App\Http\Requests\Admin\StorePaymentRequest;
use App\Models\FeePayment;
use App\Models\FeeVoucher;
use App\Models\Student;
use App\Services\Admin\FeePaymentService;
use App\Services\Admin\FeeVoucherService;
use App\Support\FeeHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FeePaymentController extends Controller
{
    public function __construct(private FeePaymentService $payments, private FeeVoucherService $vouchers)
    {
    }

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q'));

        $payments = FeePayment::with('student:id,full_name,roll_number,deleted_at')
            ->when(isset(FeePayment::STATUSES[$status]), fn ($q) => $q->where('status', $status))
            ->when($request->filled('method'), fn ($q) => $q->where('method', $request->query('method')))
            ->when($request->filled('from'), fn ($q) => $q->where('payment_date', '>=', $request->query('from')))
            ->when($request->filled('to'), fn ($q) => $q->where('payment_date', '<=', $request->query('to')))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('receipt_number', 'like', "%$search%")->orWhere('reference_no', 'like', "%$search%")
                ->orWhereHas('student', fn ($s) => $s->where('full_name', 'like', "%$search%")->orWhere('roll_number', 'like', "%$search%"))))
            ->latest('id')->paginate(config('fees.per_page'))->withQueryString();

        return view('backend.fees.payments.index', [
            'payments' => $payments,
            'counts'   => FeePayment::selectRaw('status, COUNT(*) AS total')->groupBy('status')->pluck('total', 'status'),
            'filters'  => $request->query(),
        ]);
    }

    /** Receive a payment. Without a student it shows a search box first. */
    public function create(Request $request): View
    {
        $student = $request->integer('student') ? Student::with(['schoolClass', 'section'])->find($request->integer('student')) : null;
        $search  = trim((string) $request->query('q'));

        $matches = null;
        if (! $student && $search !== '') {
            $matches = Student::with(['schoolClass:id,name', 'section:id,name'])
                ->where(fn ($q) => $q->where('full_name', 'like', "%$search%")->orWhere('roll_number', 'like', "%$search%")->orWhere('cnic', 'like', "%$search%"))
                ->orderBy('full_name')->limit(20)->get();
        }

        $open = collect();
        $dueToday = 0.0;
        $payNow = null;
        if ($student) {
            $today = FeeHelper::today();
            $open  = FeeVoucher::where('student_id', $student->id)->open()->orderBy('period')->orderBy('id')->get()
                ->each(fn ($v) => $v->late_extra = $this->vouchers->lateFeeExtra($v, $today)); // what the late fee would add today
            $dueToday = round((float) $open->sum('balance') + (float) $open->sum('late_extra'), 2);

            // Students on a fee plan pay installment by installment: suggest what is due now, not the whole course fee.
            if ($open->whereNotNull('fee_plan_id')->isNotEmpty()) {
                $due = $open->filter(fn ($v) => ! $v->fee_plan_id || $v->due_date->toDateString() <= $today->toDateString());

                if ($due->isEmpty()) {
                    $due = $open->whereNotNull('fee_plan_id')->take(1);
                }

                $payNow = round((float) $due->sum('balance') + (float) $due->sum('late_extra'), 2);
            }
        }

        return view('backend.fees.payments.create', [
            'student'    => $student,
            'matches'    => $matches,
            'search'     => $search,
            'open'       => $open,
            'dueToday'   => $dueToday,
            'payNow'     => $payNow ?? $dueToday,
            'voucherId'  => $request->integer('voucher') ?: null,
            'token'      => (string) Str::uuid(),
            'today'      => FeeHelper::today()->toDateString(),
        ]);
    }

    public function store(StorePaymentRequest $request): RedirectResponse
    {
        $student = Student::findOrFail($request->validated('student_id'));

        try {
            $payment = $this->payments->record($student, $request->validated());
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        $payment->status === 'verified'
            ? toastr()->success('Payment confirmed. Receipt ' . $payment->receipt_number . '.')
            : toastr()->info('Payment recorded. It is not counted until it is verified.');

        return redirect()->route('fees.payments.show', $payment);
    }

    public function show(FeePayment $payment): View
    {
        $payment->load(['student.schoolClass', 'student.section', 'allocations.voucher', 'logs.admin', 'receiver', 'verifier']);

        return view('backend.fees.payments.show', compact('payment'));
    }

    public function verify(FeePayment $payment): RedirectResponse
    {
        try {
            $this->payments->verify($payment);
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back();
        }

        toastr()->success('Payment verified and applied to the vouchers.');

        return redirect()->route('fees.payments.show', $payment);
    }

    public function reject(ReasonRequest $request, FeePayment $payment): RedirectResponse
    {
        return $this->attempt(fn () => $this->payments->reject($payment, $request->validated('reason')), 'Payment rejected.', $payment);
    }

    public function cancel(ReasonRequest $request, FeePayment $payment): RedirectResponse
    {
        return $this->attempt(fn () => $this->payments->cancel($payment, $request->validated('reason')), 'Payment cancelled. The vouchers are unpaid again.', $payment);
    }

    public function receipt(FeePayment $payment)
    {
        abort_unless($payment->status === 'verified', 404); // no receipt for an unconfirmed payment

        $payment->load(['student.schoolClass', 'student.section', 'allocations.voucher', 'receiver']);

        return Pdf::loadView('backend.fees.pdf.receipt', [
            'payment'    => $payment,
            'letterhead' => FeeHelper::letterhead(),
        ])->setPaper('a4', 'portrait')->stream($payment->receipt_number . '.pdf');
    }

    private function attempt(callable $action, string $success, FeePayment $payment): RedirectResponse
    {
        try {
            $action();
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success($success);

        return redirect()->route('fees.payments.show', $payment);
    }
}