<?php

namespace App\Services\Admin;

use App\Models\FeePayment;
use App\Models\FeeVoucherItem;
use App\Models\SchoolClass;
use App\Models\Student;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/** Read-only class-wise fee metrics and monthly report data. */
class FeeAnalyticsService
{
    public function __construct(private FeeBalanceService $balances)
    {
    }

    /** @return array{0:string,1:string} inclusive month start and end dates */
    private function monthRange(string $period): array
    {
        $start = CarbonImmutable::createFromFormat('!Y-m-d', $period . '-01');

        return [$start->toDateString(), $start->endOfMonth()->toDateString()];
    }

    /**
     * Class totals are based on active students currently assigned to each class.
     * Monthly collections use verified payment_date, not voucher issue date.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function classWise(string $period, ?int $classId = null): Collection
    {
        [$monthStart, $monthEnd] = $this->monthRange($period);

        $classes = SchoolClass::query()
            ->when($classId, fn ($query) => $query->whereKey($classId))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'code', 'is_active']);

        $students = Student::query()
            ->active()
            ->when($classId, fn ($query) => $query->where('school_class_id', $classId))
            ->withSum([
                'feePayments as received_total' => fn ($query) => $query->where('status', 'verified'),
            ], 'amount')
            ->withSum([
                'feePayments as month_received' => fn ($query) => $query
                    ->where('status', 'verified')
                    ->whereBetween('payment_date', [$monthStart, $monthEnd]),
            ], 'amount')
            ->withSum([
                'feeVouchers as period_voucher_total' => fn ($query) => $query
                    ->where('period', $period)
                    ->where('status', '!=', 'cancelled'),
            ], 'total_amount')
            ->withSum([
                'feeVouchers as period_voucher_balance' => fn ($query) => $query
                    ->where('period', $period)
                    ->where('status', '!=', 'cancelled'),
            ], 'balance')
            ->get(['id', 'school_class_id', 'finalized_fee']);

        $studentsByClass = $students->groupBy('school_class_id');
        $baseCollected = $this->balances->baseCollectedByStudents($students->pluck('id')->all());

        return $classes->map(function (SchoolClass $class) use ($studentsByClass, $period, $baseCollected) {
            /** @var Collection<int, Student> $group */
            $group = $studentsByClass->get($class->id, collect());
            $withFee = $group->filter(fn (Student $student) => $student->finalized_fee !== null);

            $totalFee = round((float) $withFee->sum(fn (Student $student) => (float) $student->finalized_fee), 2);
            $receivedTotal = round((float) $group->sum(fn (Student $student) => (float) ($student->received_total ?? 0)), 2);
            $remainingFee = round((float) $withFee->sum(fn (Student $student) => max(
                0,
                round((float) $student->finalized_fee - (float) ($baseCollected->get($student->id)->base_received ?? 0), 2)
            )), 2);
            $monthCollected = round((float) $group->sum(fn (Student $student) => (float) ($student->month_received ?? 0)), 2);
            $paidThisMonth = $group->filter(fn (Student $student) => (float) ($student->month_received ?? 0) > 0)->count();

            return [
                'id' => $class->id,
                'name' => $class->name,
                'code' => $class->code,
                'is_active' => (bool) $class->is_active,
                'period' => $period,
                'active_students' => $group->count(),
                'students_without_fee' => $group->whereNull('finalized_fee')->count(),
                'students_paid_this_month' => $paidThisMonth,
                'students_unpaid_this_month' => $group->count() - $paidThisMonth,
                'total_fee' => $totalFee,
                'received_total' => $receivedTotal,
                'remaining_fee' => $remainingFee,
                'month_collected' => $monthCollected,
                'period_voucher_total' => round((float) $group->sum(fn (Student $student) => (float) ($student->period_voucher_total ?? 0)), 2),
                'period_voucher_balance' => round((float) $group->sum(fn (Student $student) => (float) ($student->period_voucher_balance ?? 0)), 2),
            ];
        })->values();
    }

    /** Active students who have no verified payment dated within the selected month. */
    public function unpaidStudents(string $period, ?int $classId = null): LengthAwarePaginator
    {
        [$monthStart, $monthEnd] = $this->monthRange($period);

        $periodVouchers = fn ($query) => $query
            ->where('period', $period)
            ->where('status', '!=', 'cancelled');

        return Student::query()
            ->active()
            ->when($classId, fn ($query) => $query->where('school_class_id', $classId))
            ->whereDoesntHave('feePayments', fn ($query) => $query
                ->where('status', 'verified')
                ->whereBetween('payment_date', [$monthStart, $monthEnd]))
            ->with(['schoolClass:id,name', 'section:id,name'])
            ->withSum(['feeVouchers as period_voucher_total' => $periodVouchers], 'total_amount')
            ->withSum(['feeVouchers as period_voucher_balance' => $periodVouchers], 'balance')
            ->withCount(['feeVouchers as period_voucher_count' => $periodVouchers])
            ->orderBy('school_class_id')
            ->orderBy('section_id')
            ->orderBy('roll_number')
            ->paginate(25)
            ->withQueryString();
    }

    /**
     * Full student-level data for the monthly PDF. Every active student is retained, including students
     * with no voucher and/or no finalized fee, so the report also exposes students needing follow-up.
     *
     * @return array<string, mixed>
     */
    public function monthlyReport(string $period, ?int $classId = null): array
    {
        [$monthStart, $monthEnd] = $this->monthRange($period);
        $classSummaries = $this->classWise($period, $classId);

        $periodVouchers = fn ($query) => $query
            ->where('period', $period)
            ->where('status', '!=', 'cancelled');

        $students = Student::query()
            ->active()
            ->when($classId, fn ($query) => $query->where('school_class_id', $classId))
            ->with(['schoolClass:id,name', 'section:id,name'])
            ->withSum([
                'feePayments as received_total' => fn ($query) => $query->where('status', 'verified'),
            ], 'amount')
            ->withSum([
                'feePayments as month_received' => fn ($query) => $query
                    ->where('status', 'verified')
                    ->whereBetween('payment_date', [$monthStart, $monthEnd]),
            ], 'amount')
            ->withSum(['feeVouchers as period_voucher_total' => $periodVouchers], 'total_amount')
            ->withSum(['feeVouchers as period_voucher_paid' => $periodVouchers], 'paid_amount')
            ->withSum(['feeVouchers as period_voucher_balance' => $periodVouchers], 'balance')
            ->withCount(['feeVouchers as period_voucher_count' => $periodVouchers])
            ->orderBy('school_class_id')
            ->orderBy('section_id')
            ->orderBy('roll_number')
            ->get(['id', 'school_class_id', 'section_id', 'roll_number', 'full_name', 'father_name', 'phone', 'finalized_fee']);

        $studentIds = $students->pluck('id')->all();
        $baseCollected = $this->balances->baseCollectedByStudents($studentIds);
        $fineTotals = collect();

        if ($studentIds !== []) {
            $fineTotals = FeeVoucherItem::query()
                ->join('fee_vouchers as report_vouchers', 'report_vouchers.id', '=', 'fee_voucher_items.fee_voucher_id')
                ->where('report_vouchers.period', $period)
                ->where('report_vouchers.status', '!=', 'cancelled')
                ->whereIn('report_vouchers.student_id', $studentIds)
                ->selectRaw("report_vouchers.student_id,\n                    SUM(CASE WHEN fee_voucher_items.source IN ('late_fee', 'late_fee_waiver') THEN fee_voucher_items.amount ELSE 0 END) AS late_fine,\n                    SUM(CASE WHEN fee_voucher_items.source = 'absent_fine' THEN fee_voucher_items.amount ELSE 0 END) AS absent_fine")
                ->groupBy('report_vouchers.student_id')
                ->get()
                ->keyBy('student_id');
        }

        $rows = $students->map(function (Student $student) use ($fineTotals, $baseCollected) {
            $finalized = $student->finalized_fee === null ? null : (float) $student->finalized_fee;
            $received = (float) ($student->received_total ?? 0);
            $monthReceived = (float) ($student->month_received ?? 0);
            $voucherTotal = (float) ($student->period_voucher_total ?? 0);
            $voucherBalance = (float) ($student->period_voucher_balance ?? 0);
            $voucherCount = (int) ($student->period_voucher_count ?? 0);
            $fines = $fineTotals->get($student->id);

            if ($voucherCount === 0) {
                $voucherStatus = 'No voucher';
            } elseif ($voucherBalance <= 0.001) {
                $voucherStatus = 'Paid';
            } elseif ((float) ($student->period_voucher_paid ?? 0) > 0) {
                $voucherStatus = 'Partly paid';
            } else {
                $voucherStatus = 'Unpaid';
            }

            return [
                'student' => $student,
                'school_class_id' => $student->school_class_id,
                'finalized_fee' => $finalized,
                'received_total' => round($received, 2),
                'month_received' => round($monthReceived, 2),
                'base_received_total' => round((float) ($baseCollected->get($student->id)->base_received ?? 0), 2),
                'remaining_fee' => $finalized === null ? null : max(0, round($finalized - (float) ($baseCollected->get($student->id)->base_received ?? 0), 2)),
                'period_voucher_total' => round($voucherTotal, 2),
                'period_voucher_paid' => round((float) ($student->period_voucher_paid ?? 0), 2),
                'period_voucher_balance' => round($voucherBalance, 2),
                'period_voucher_count' => $voucherCount,
                'period_late_fine' => round((float) ($fines?->late_fine ?? 0), 2),
                'period_absent_fine' => round((float) ($fines?->absent_fine ?? 0), 2),
                'paid_this_month' => $monthReceived > 0,
                'voucher_status' => $voucherStatus,
            ];
        });

        $classes = $classSummaries->map(function (array $summary) use ($rows) {
            $classRows = $rows->where('school_class_id', $summary['id'])->values();

            return $summary + [
                'students' => $classRows,
                'student_count' => $classRows->count(),
                'period_late_fine' => round((float) $classRows->sum('period_late_fine'), 2),
                'period_absent_fine' => round((float) $classRows->sum('period_absent_fine'), 2),
            ];
        });

        return [
            'period' => $period,
            'period_label' => CarbonImmutable::createFromFormat('!Y-m-d', $period . '-01')->format('F Y'),
            'generated_at' => CarbonImmutable::now()->format('d M Y, h:i A'),
            'classes' => $classes,
            'totals' => [
                'active_students' => (int) $classSummaries->sum('active_students'),
                'students_without_fee' => (int) $classSummaries->sum('students_without_fee'),
                'students_unpaid_this_month' => (int) $classSummaries->sum('students_unpaid_this_month'),
                'total_fee' => round((float) $classSummaries->sum('total_fee'), 2),
                'received_total' => round((float) $classSummaries->sum('received_total'), 2),
                'remaining_fee' => round((float) $classSummaries->sum('remaining_fee'), 2),
                'month_collected' => round((float) $classSummaries->sum('month_collected'), 2),
                'period_voucher_total' => round((float) $classSummaries->sum('period_voucher_total'), 2),
                'period_voucher_balance' => round((float) $classSummaries->sum('period_voucher_balance'), 2),
                'period_late_fine' => round((float) $classes->sum('period_late_fine'), 2),
                'period_absent_fine' => round((float) $classes->sum('period_absent_fine'), 2),
            ],
        ];
    }
}
