<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeePlanRequest;
use App\Http\Requests\Admin\ReasonRequest;
use App\Models\FeePlan;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\Admin\FeePlanService;
use App\Support\FeeHelper;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/** Set up / change / cancel the fee plan (total fee + installments) of one student. */
class FeePlanController extends Controller
{
    public function __construct(private FeePlanService $plans)
    {
    }

    /** Same plan for a whole class / section (students who already have a plan are skipped). */
    public function bulk(Request $request): View
    {
        $classId   = $request->integer('class') ?: null;
        $sectionId = $request->integer('section') ?: null;

        $eligible = null;
        if ($classId) {
            $students = Student::active()->where('school_class_id', $classId)
                ->when($sectionId, fn ($q) => $q->where('section_id', $sectionId));
            $eligible = [
                'total'    => (clone $students)->count(),
                'with'     => (clone $students)->whereIn('id', FeePlan::active()->select('student_id'))->count(),
            ];
        }

        return view('backend.fees.plans.bulk', [
            'classes'   => SchoolClass::active()->orderBy('sort_order')->orderBy('name')->get(),
            'sections'  => $classId ? Section::where('school_class_id', $classId)->orderBy('name')->get() : collect(),
            'classId'   => $classId,
            'sectionId' => $sectionId,
            'eligible'  => $eligible,
            'today'     => FeeHelper::today()->toDateString(),
        ]);
    }

    public function bulkStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'section_id'      => ['nullable', 'integer'],
            'total_fee'       => ['required', 'numeric', 'min:1', 'max:10000000', 'decimal:0,2'],
            'discount'        => ['nullable', 'numeric', 'min:0', 'max:10000000', 'decimal:0,2'],
            'count'           => ['required', 'integer', 'min:1', 'max:60'],
            'first_due'       => ['required', 'date_format:Y-m-d'],
            'interval'        => ['required', 'integer', 'in:1,2,3,6'],
            'notes'           => ['nullable', 'string', 'max:255'],
        ]);

        $result = $this->plans->bulkCreate(
            (int) $data['school_class_id'], $data['section_id'] ?? null,
            ['total_fee' => $data['total_fee'], 'discount' => $data['discount'] ?? 0, 'notes' => $data['notes'] ?? null],
            (int) $data['count'], $data['first_due'], (int) $data['interval']
        );

        toastr()->success($result['created'] . ' fee plan(s) created.');

        return redirect()->route('fees.accounts', array_filter(['class' => $data['school_class_id'], 'section' => $data['section_id'] ?? null]))
            ->with('bulk_skipped', $result['skipped']);
    }

    public function create(Student $student): View|RedirectResponse
    {
        if ($this->plans->activePlan($student)) {
            return redirect()->route('fees.plans.edit', $student);
        }

        $student->load(['schoolClass', 'section']);

        return view('backend.fees.plans.form', [
            'student'  => $student,
            'plan'     => null,
            'locked'   => collect(),
            'lockedSum' => 0.0,
            'rows'     => [],
            'today'    => FeeHelper::today()->toDateString(),
        ]);
    }

    public function store(FeePlanRequest $request, Student $student): RedirectResponse
    {
        try {
            $this->plans->create($student, $request->validated());
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success('Fee plan saved. The installments are now in the account book.');

        return redirect()->route('fees.accounts.show', $student);
    }

    public function edit(Student $student): View|RedirectResponse
    {
        $plan = $this->plans->activePlan($student);

        if (! $plan) {
            return redirect()->route('fees.plans.create', $student);
        }

        $student->load(['schoolClass', 'section']);

        $locked = $this->plans->lockedVouchers($plan)->sortBy('due_date')->values();
        $rows   = $plan->vouchers()->where('status', '!=', 'cancelled')->whereDoesntHave('allocations')
            ->with('items')->orderBy('due_date')->orderBy('id')->get()
            ->map(fn ($v) => ['amount' => $this->plans->baseAmount($v), 'due_date' => $v->due_date->toDateString()])->all();

        return view('backend.fees.plans.form', [
            'student'   => $student,
            'plan'      => $plan,
            'locked'    => $locked,
            'lockedSum' => round((float) $locked->sum(fn ($v) => $this->plans->baseAmount($v)), 2),
            'rows'      => $rows,
            'today'     => FeeHelper::today()->toDateString(),
        ]);
    }

    public function update(FeePlanRequest $request, Student $student): RedirectResponse
    {
        $plan = $this->plans->activePlan($student);
        abort_unless($plan, 404);

        try {
            $this->plans->update($plan, $request->validated());
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success('Fee plan updated.');

        return redirect()->route('fees.accounts.show', $student);
    }

    public function cancel(ReasonRequest $request, Student $student): RedirectResponse
    {
        $plan = $this->plans->activePlan($student);
        abort_unless($plan, 404);

        try {
            $this->plans->cancel($plan, $request->validated('reason'));
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back();
        }

        toastr()->success('Fee plan cancelled.');

        return redirect()->route('fees.accounts.show', $student);
    }
}
