<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReasonRequest;
use App\Http\Requests\Admin\StoreVoucherRequest;
use App\Models\FeePayment;
use App\Models\FeeSetting;
use App\Models\FeeVoucher;
use App\Models\FeeVoucherItem;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Services\Admin\FeeVoucherService;
use App\Services\Admin\FeeBalanceService;
use App\Support\FeeHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use DomainException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeVoucherController extends Controller
{
    public function __construct(private FeeVoucherService $service, private FeeBalanceService $balances)
    {
    }

    public function index(Request $request): View
    {
        $query = $this->filtered($request);

        $summary = (clone $query)->toBase()->where('status', '!=', 'cancelled')
            ->selectRaw('COUNT(*) AS vouchers, COALESCE(SUM(total_amount), 0) AS billed, COALESCE(SUM(paid_amount), 0) AS paid, COALESCE(SUM(balance), 0) AS balance')
            ->first();

        $vouchers = $query->latest('id')->paginate(config('fees.per_page'))->withQueryString();

        $classId = $request->integer('class') ?: null;

        return view('backend.fees.vouchers.index', [
            'vouchers' => $vouchers,
            'summary'  => $summary,
            'classes'  => SchoolClass::orderBy('sort_order')->orderBy('name')->get(),
            'sections' => $classId ? Section::where('school_class_id', $classId)->orderBy('name')->get() : collect(),
            'filters'  => $request->query(),
        ]);
    }

    public function create(Request $request): View
    {
        $student = $request->integer('student') ? Student::with(['schoolClass', 'section'])->find($request->integer('student')) : null;
        $period = $request->validate(['period' => ['nullable', 'date_format:Y-m']])['period'] ?? FeeHelper::today()->format('Y-m');
        $type    = (string) $request->query('type', 'monthly');
        if (! array_key_exists($type, FeeVoucher::manualTypes())) {
            $type = 'monthly';
        }

        $receivedFee = $student
            ? (float) FeePayment::where('student_id', $student->id)->where('status', 'verified')->sum('amount')
            : 0.0;
        $alreadyBilled = $student
            ? (float) FeeVoucherItem::whereHas('voucher', fn ($q) => $q->where('student_id', $student->id)->where('status', '!=', 'cancelled'))
                ->whereNotIn('source', ['late_fee', 'late_fee_waiver', 'absent_fine'])->sum('amount')
            : 0.0;
        $finalizedFee = (float) ($student?->finalized_fee ?? 0);

        $issueDate = FeeHelper::today()->toDateString();
        $defaultDue = $this->service->defaultDueDate($period);
        $dueDate = $defaultDue < $issueDate ? $issueDate : $defaultDue;

        return view('backend.fees.vouchers.create', [
            'student'         => $student,
            'classes'         => SchoolClass::active()->orderBy('sort_order')->orderBy('name')->get(),
            'type'            => $type,
            'period'          => $period,
            'issue'           => $issueDate,
            'due'             => $dueDate,
            'receivedFee'     => $receivedFee,
            'finalizedFee'    => $finalizedFee,
            'studentBalance'  => $student ? $this->balances->remainingFinalizedFee($student) : 0.0,
            'remainingToBill' => max(0, round($finalizedFee - $alreadyBilled, 2)),
        ]);
    }

    public function store(StoreVoucherRequest $request): RedirectResponse
    {
        $student = Student::findOrFail($request->validated('student_id'));

        try {
            $voucher = $this->service->create($student, $request->validated());
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success('Voucher ' . $voucher->voucher_number . ' created.');

        return redirect()->route('fees.vouchers.show', $voucher);
    }

    public function show(FeeVoucher $voucher): View
    {
        $voucher->load(['student.schoolClass', 'student.section', 'items', 'allocations.payment']);

        $arrears = $this->service->arrearsList($voucher);
        $today = FeeHelper::today();
        $arrears->each(function ($older) use ($today) {
            $older->late_fee_extra = $this->service->lateFeeExtra($older, $today);
            // Unbilled late fines will be carried by a future monthly voucher; they are not part of this voucher's due amount.
            $older->payable_today = (float) $older->balance;
        });

        return view('backend.fees.vouchers.show', [
            'voucher'      => $voucher,
            'arrears'      => $arrears,
            'arrearsTotal' => round((float) $arrears->sum('balance'), 2),
            'lateExtra'    => $this->service->lateFeeExtra($voucher, $today),
        ]);
    }

    public function pdf(FeeVoucher $voucher)
    {
        abort_if($voucher->status === 'cancelled', 404);

        return $this->makePdf(collect([$voucher]), $voucher->voucher_number);
    }

    /** Print every voucher that matches the current filters (up to the limit in config/fees.php). */
    public function printMany(Request $request)
    {
        $vouchers = $this->filtered($request)->where('status', '!=', 'cancelled')
            ->orderBy('section_id')->orderBy('roll_number')->limit(config('fees.max_print'))->get();

        if ($vouchers->isEmpty()) {
            toastr()->error('There are no vouchers to print for these filters.');

            return back();
        }

        return $this->makePdf($vouchers, 'vouchers-' . now()->format('Ymd-His'));
    }

    public function cancel(ReasonRequest $request, FeeVoucher $voucher): RedirectResponse
    {
        return $this->attempt(fn () => $this->service->cancel($voucher, $request->validated('reason')), 'Voucher cancelled.', $voucher);
    }

    /** AJAX: active students of a section (used by the "new voucher" and "payment" pages). */
    public function studentsBySection(Section $section): JsonResponse
    {
        $students = Student::active()
            ->where('section_id', $section->id)
            ->withSum(['feePayments as received_fee' => fn ($query) => $query->where('status', 'verified')], 'amount')
            ->addSelect(['billed_fee' => FeeVoucherItem::query()
                ->selectRaw('COALESCE(SUM(fee_voucher_items.amount), 0)')
                ->join('fee_vouchers', 'fee_vouchers.id', '=', 'fee_voucher_items.fee_voucher_id')
                ->whereColumn('fee_vouchers.student_id', 'students.id')
                ->where('fee_vouchers.status', '!=', 'cancelled')
                ->whereNotIn('fee_voucher_items.source', ['late_fee', 'late_fee_waiver', 'absent_fine'])])
            ->orderBy('roll_number')
            ->get(['id', 'roll_number', 'full_name', 'finalized_fee']);

        $baseCollected = $this->balances->baseCollectedByStudents($students->pluck('id')->all());

        return response()->json($students->map(function (Student $student) use ($baseCollected) {
            $finalized = $student->finalized_fee === null ? null : (float) $student->finalized_fee;
            $received = (float) ($student->received_fee ?? 0);
            $baseReceived = (float) ($baseCollected->get($student->id)->base_received ?? 0);
            $billed = (float) ($student->billed_fee ?? 0);

            return [
                'id' => $student->id,
                'roll_number' => $student->roll_number,
                'full_name' => $student->full_name,
                'finalized_fee' => $finalized,
                'received_fee' => $received,
                'remaining_balance' => $finalized === null ? null : max(0, round($finalized - $baseReceived, 2)),
                'remaining_to_bill' => $finalized === null ? 0 : max(0, round($finalized - $billed, 2)),
            ];
        })->values());
    }

    /* ---------------------------------------------------------------- */

    private function filtered(Request $request): Builder
    {
        $search = trim((string) $request->query('q'));
        $status = $request->query('status');

        return FeeVoucher::query()
            ->with(['student:id,full_name,roll_number,deleted_at', 'schoolClass:id,name', 'section:id,name'])
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('voucher_number', 'like', "%$search%")
                ->orWhere('roll_number', 'like', "%$search%")
                ->orWhereHas('student', fn ($s) => $s->where('full_name', 'like', "%$search%"))))
            ->when($request->integer('class'), fn ($q, $c) => $q->where('school_class_id', $c))
            ->when($request->integer('section'), fn ($q, $c) => $q->where('section_id', $c))
            ->when($request->filled('period'), fn ($q) => $q->where('period', $request->query('period')))
            ->when($request->filled('type') && isset(FeeVoucher::TYPES[$request->query('type')]), fn ($q) => $q->where('type', $request->query('type')))
            ->when($status === 'overdue', fn ($q) => $q->overdue())
            ->when(is_string($status) && isset(FeeVoucher::STATUSES[$status]), fn ($q) => $q->where('status', $status));
    }

    private function makePdf($vouchers, string $name)
    {
        $items = $vouchers->map(fn ($v) => $this->service->printData($v));

        return Pdf::loadView('backend.fees.pdf.vouchers', [
            'items'      => $items,
            'letterhead' => FeeHelper::letterhead(),
            'policies'   => FeeSetting::policyLines(),
            'bank'       => [
                'name'           => FeeSetting::get('bank_name'),
                'branch'         => FeeSetting::get('bank_branch'),
                'account_title'  => FeeSetting::get('account_title'),
                'account_number' => FeeSetting::get('account_number'),
            ],
        ])->setPaper('a4', 'landscape')->stream($name . '.pdf');
    }

    private function attempt(callable $action, string $success, FeeVoucher $voucher): RedirectResponse
    {
        try {
            $action();
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success($success);

        return redirect()->route('fees.vouchers.show', $voucher);
    }
}
