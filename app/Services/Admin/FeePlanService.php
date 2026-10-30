<?php

namespace App\Services\Admin;

use App\Models\FeeAuditLog;
use App\Models\FeePlan;
use App\Models\FeeVoucher;
use App\Models\Student;
use App\Support\FeeHelper;
use Carbon\CarbonImmutable;
use DomainException;
use Illuminate\Support\Facades\DB;

/**
 * A fee plan = the total payable fee of one student + its installments.
 * Each installment is a normal fee voucher, so payments, receipts and late fees need no special handling.
 *
 * Changing a plan later never touches an installment that already has money applied to it: those stay as they
 * are, and only the unpaid installments are replaced by the new schedule.
 */
class FeePlanService
{
    public function __construct(private FeeVoucherService $vouchers)
    {
    }

    /**
     * Suggested schedule: $net split equally, one installment every $intervalMonths. Any remainder goes to the
     * first installment so the later ones stay round numbers.
     *
     * @return array<int, array{amount:float, due_date:string}>
     */
    public function suggest(float $net, int $count, string $firstDue, int $intervalMonths = 1): array
    {
        $count = max(1, min($count, 60));
        $total = FeeHelper::paisa($net);

        if ($total <= 0) {
            return [];
        }

        $base = intdiv($total, $count);
        $rest = $total - $base * $count;
        $date = CarbonImmutable::parse($firstDue);
        $rows = [];

        for ($i = 0; $i < $count; $i++) {
            $rows[] = [
                'amount'   => FeeHelper::rupees($base + ($i === 0 ? $rest : 0)),
                'due_date' => $date->addMonthsNoOverflow($i * max(1, $intervalMonths))->toDateString(),
            ];
        }

        return $rows;
    }

    /**
     * Give every active student of a class / section (who has no plan yet) the same plan.
     *
     * @return array{created:int, skipped:array<int,string>}
     */
    public function bulkCreate(int $classId, ?int $sectionId, array $data, int $count, string $firstDue, int $interval): array
    {
        $students = Student::active()->where('school_class_id', $classId)
            ->when($sectionId, fn ($q) => $q->where('section_id', $sectionId))
            ->orderBy('section_id')->orderBy('roll_number')->get();

        $net      = FeeHelper::rupees(FeeHelper::paisa($data['total_fee']) - FeeHelper::paisa($data['discount'] ?? 0));
        $schedule = $this->suggest($net, $count, $firstDue, $interval);
        $created  = 0;
        $skipped  = [];

        foreach ($students as $student) {
            try {
                $this->create($student, ['installments' => $schedule] + $data);
                $created++;
            } catch (DomainException $e) {
                $skipped[] = $student->roll_number . ' ' . $student->full_name . ': ' . $e->getMessage();
            }
        }

        return ['created' => $created, 'skipped' => $skipped];
    }

    /** The student's active plan, if any. */
    public function activePlan(Student $student): ?FeePlan
    {
        return FeePlan::active()->where('student_id', $student->id)->first();
    }

    /** Installment vouchers that already have money applied. They can never be replaced. */
    public function lockedVouchers(FeePlan $plan)
    {
        return $plan->vouchers()->where('status', '!=', 'cancelled')->whereHas('allocations')->with('items')->get();
    }

    /** What an installment is worth without late fees. */
    public function baseAmount(FeeVoucher $voucher): float
    {
        $voucher->loadMissing('items');

        return round((float) $voucher->items->where('source', '!=', 'late_fee')->sum('amount'), 2);
    }

    /**
     * @param  array{total_fee:mixed,discount?:mixed,notes?:?string,installments:array<int,array{amount:mixed,due_date:string}>}  $data
     *
     * @throws DomainException
     */
    public function create(Student $student, array $data): FeePlan
    {
        [$total, $discount, $net] = $this->figures($data);
        $rows = $this->cleanRows($data['installments'], $net);

        return DB::transaction(function () use ($student, $data, $total, $discount, $net, $rows) {
            // Lock the student row so two clicks at the same moment cannot create two plans.
            Student::whereKey($student->id)->lockForUpdate()->first();

            if ($this->activePlan($student)) {
                throw new DomainException($student->full_name . ' already has a fee plan. Use "Change fee plan" instead.');
            }

            $plan = FeePlan::create([
                'student_id' => $student->id,
                'session'    => $student->session,
                'total_fee'  => FeeHelper::rupees($total),
                'discount'   => FeeHelper::rupees($discount),
                'net_fee'    => FeeHelper::rupees($net),
                'notes'      => $data['notes'] ?? null,
                'status'     => 'active',
                'created_by' => auth('admin')->id(),
            ]);

            $this->issue($student, $plan, $rows, 0);
            $this->renumber($plan);

            FeeAuditLog::record('plan_created', 'Fee plan created: payable ' . FeeHelper::money(FeeHelper::rupees($net)) . ' in ' . count($rows) . ' installment(s).', $student->id, null, null, FeeHelper::rupees($net));

            return $plan;
        });
    }

    /**
     * Change the total or the schedule. Installments with payments stay; the rest are replaced.
     *
     * @throws DomainException
     */
    public function update(FeePlan $plan, array $data): FeePlan
    {
        if ($plan->status !== 'active') {
            throw new DomainException('This fee plan is cancelled.');
        }

        [$total, $discount, $net] = $this->figures($data);

        return DB::transaction(function () use ($plan, $data, $total, $discount, $net) {
            $plan   = FeePlan::whereKey($plan->id)->lockForUpdate()->firstOrFail();
            $locked = $this->lockedVouchers($plan);

            $lockedPaisa = FeeHelper::paisa($locked->sum(fn ($v) => $this->baseAmount($v)));

            if ($net < $lockedPaisa) {
                throw new DomainException('The total payable (' . FeeHelper::money(FeeHelper::rupees($net)) . ') cannot be less than the installments that already have payments (' . FeeHelper::money(FeeHelper::rupees($lockedPaisa)) . ').');
            }

            $rows = $this->cleanRows($data['installments'] ?? [], $net - $lockedPaisa, true);

            // Replace every installment that has no money on it.
            $open = $plan->vouchers()->where('status', '!=', 'cancelled')->whereDoesntHave('allocations')->get();
            foreach ($open as $voucher) {
                $voucher->forceFill([
                    'status'        => 'cancelled',
                    'balance'       => 0,
                    'cancel_reason' => 'Fee plan changed',
                    'cancelled_at'  => now(),
                    'cancelled_by'  => auth('admin')->id(),
                ])->save();
            }

            $plan->update([
                'total_fee' => FeeHelper::rupees($total),
                'discount'  => FeeHelper::rupees($discount),
                'net_fee'   => FeeHelper::rupees($net),
                'notes'     => $data['notes'] ?? null,
            ]);

            $nextNo = (int) $plan->vouchers()->max('installment_no');
            $this->issue($plan->student, $plan, $rows, $nextNo);
            $this->renumber($plan);

            FeeAuditLog::record('plan_changed', 'Fee plan changed: payable ' . FeeHelper::money(FeeHelper::rupees($net)) . ', ' . $locked->count() . ' paid installment(s) kept, ' . count($rows) . ' new/updated.', $plan->student_id, null, null, FeeHelper::rupees($net));

            return $plan;
        });
    }

    /** @throws DomainException */
    public function cancel(FeePlan $plan, string $reason): void
    {
        if ($plan->status !== 'active') {
            throw new DomainException('This fee plan is already cancelled.');
        }

        DB::transaction(function () use ($plan, $reason) {
            if ($this->lockedVouchers($plan)->isNotEmpty()) {
                throw new DomainException('Payments are already applied to this plan. Cancel those payments first, or change the plan instead.');
            }

            foreach ($plan->vouchers()->where('status', '!=', 'cancelled')->get() as $voucher) {
                $voucher->forceFill([
                    'status'        => 'cancelled',
                    'balance'       => 0,
                    'cancel_reason' => 'Fee plan cancelled: ' . $reason,
                    'cancelled_at'  => now(),
                    'cancelled_by'  => auth('admin')->id(),
                ])->save();
            }

            $plan->forceFill(['status' => 'cancelled', 'cancelled_at' => now()])->save();

            FeeAuditLog::record('plan_cancelled', 'Fee plan cancelled. Reason: ' . $reason, $plan->student_id);
        });
    }

    /* ---------------------------------------------------------------- */

    /** @return array{0:int,1:int,2:int} total, discount and net, in paisa */
    private function figures(array $data): array
    {
        $total    = FeeHelper::paisa($data['total_fee'] ?? 0);
        $discount = FeeHelper::paisa($data['discount'] ?? 0);

        if ($total <= 0) {
            throw new DomainException('Enter the total fee.');
        }

        if ($discount < 0 || $discount >= $total) {
            throw new DomainException('The discount must be less than the total fee.');
        }

        return [$total, $discount, $total - $discount];
    }

    /**
     * Check the schedule adds up to exactly $target (paisa).
     *
     * @return array<int, array{paisa:int, due_date:string}>
     */
    private function cleanRows(array $rows, int $target, bool $mayBeEmpty = false): array
    {
        $clean = [];

        foreach ($rows as $row) {
            $paisa = FeeHelper::paisa($row['amount'] ?? 0);

            if ($paisa <= 0) {
                continue; // an empty line of the form
            }

            $clean[] = ['paisa' => $paisa, 'due_date' => CarbonImmutable::parse($row['due_date'])->toDateString()];
        }

        if (! $clean) {
            if ($mayBeEmpty && $target === 0) {
                return [];
            }

            throw new DomainException('Add at least one installment.');
        }

        $sum = array_sum(array_column($clean, 'paisa'));

        if ($sum !== $target) {
            throw new DomainException('The installments add up to ' . FeeHelper::money(FeeHelper::rupees($sum)) . ' but they must add up to ' . FeeHelper::money(FeeHelper::rupees($target)) . '.');
        }

        usort($clean, fn ($a, $b) => strcmp($a['due_date'], $b['due_date']));

        return $clean;
    }

    private function issue(Student $student, FeePlan $plan, array $rows, int $startAt): void
    {
        $today = FeeHelper::today()->toDateString();

        foreach ($rows as $i => $row) {
            $this->vouchers->createInstallment($student, $plan, $startAt + $i + 1, FeeHelper::rupees($row['paisa']), $row['due_date'], $today);
        }
    }

    /** Installment 1..n in due-date order (only a label, no money changes). */
    private function renumber(FeePlan $plan): void
    {
        $live = $plan->vouchers()->where('status', '!=', 'cancelled')->orderBy('due_date')->orderBy('id')->get();

        foreach ($live as $i => $voucher) {
            $no = $i + 1;

            if ((int) $voucher->installment_no !== $no) {
                $voucher->forceFill(['installment_no' => $no])->save();
                $voucher->items()->where('source', 'installment')->update(['title' => 'Fee installment ' . $no]);
            }
        }
    }
}
