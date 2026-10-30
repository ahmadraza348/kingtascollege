<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkVoucherRequest;
use App\Http\Requests\Admin\ReasonRequest;
use App\Http\Requests\Admin\StoreVoucherRequest;
use App\Models\FeeSetting;
use App\Models\FeeVoucher;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Services\Admin\FeeVoucherService;
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
    public function __construct(private FeeVoucherService $service)
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
        $period  = FeeHelper::today()->format('Y-m');
        $type    = (string) $request->query('type', 'monthly');
        if (! array_key_exists($type, FeeVoucher::manualTypes())) {
            $type = 'monthly';
        }

        return view('backend.fees.vouchers.create', [
            'student'  => $student,
            'classes'  => SchoolClass::active()->orderBy('sort_order')->orderBy('name')->get(),
            'type'     => $type,
            'period'   => $period,
            'issue'    => FeeHelper::today()->toDateString(),
            'due'      => $this->service->defaultDueDate($period),
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

    /** Generate for a whole class / section. The page first shows what will happen. */
    public function bulk(Request $request): View
    {
        $request->validate([
            'class'   => ['nullable', 'exists:school_classes,id'],
            'section' => ['nullable', 'integer'],
            'period'  => ['nullable', 'date_format:Y-m'],
        ]);

        $classId   = $request->integer('class') ?: null;
        $sectionId = $request->integer('section') ?: null;
        $period    = $request->query('period', FeeHelper::today()->format('Y-m'));

        return view('backend.fees.vouchers.bulk', [
            'classes'   => SchoolClass::active()->orderBy('sort_order')->orderBy('name')->get(),
            'sections'  => $classId ? Section::where('school_class_id', $classId)->orderBy('name')->get() : collect(),
            'classId'   => $classId,
            'sectionId' => $sectionId,
            'period'    => $period,
            'issue'     => $request->query('issue_date', FeeHelper::today()->toDateString()),
            'due'       => $request->query('due_date', $this->service->defaultDueDate($period)),
            'preview'   => $classId ? $this->service->bulkPreview($classId, $sectionId, $period) : null,
        ]);
    }

    public function bulkStore(BulkVoucherRequest $request): RedirectResponse
    {
        $data   = $request->validated();
        $result = $this->service->bulkGenerate((int) $data['school_class_id'], $data['section_id'] ?? null, [
            'period'              => $data['period'],
            'issue_date'          => $data['issue_date'],
            'due_date'            => $data['due_date'],
            'include_absent_fine' => $request->boolean('include_absent_fine'),
        ]);

        toastr()->success($result['created']->count() . ' voucher(s) created.');

        return redirect()
            ->route('fees.vouchers', array_filter(['class' => $data['school_class_id'], 'section' => $data['section_id'] ?? null, 'period' => $data['period']]))
            ->with('bulk_skipped', $result['skipped']);
    }

    public function show(FeeVoucher $voucher): View
    {
        $voucher->load(['student.schoolClass', 'student.section', 'items', 'allocations.payment']);

        $arrears = $this->service->arrearsList($voucher);
        $today = FeeHelper::today();
        $arrears->each(function ($older) use ($today) {
            $older->late_fee_extra = $this->service->lateFeeExtra($older, $today);
            $older->payable_today = round((float) $older->balance + $older->late_fee_extra, 2);
        });

        return view('backend.fees.vouchers.show', [
            'voucher'      => $voucher,
            'arrears'      => $arrears,
            'arrearsTotal' => round((float) $arrears->sum('payable_today'), 2),
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
        return response()->json(
            Student::active()->where('section_id', $section->id)->orderBy('roll_number')->get(['id', 'roll_number', 'full_name'])
        );
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
