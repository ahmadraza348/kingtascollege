<?php

namespace App\Services\Admin;

use App\Models\Student;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Separates finalized course-fee receipts from additional fines without introducing an allocation table.
 * Payments are allocated to vouchers (not individual lines), so a voucher's payment is treated as paying
 * its non-fine lines first; only the amount above those lines is considered fine collection.
 */
class FeeBalanceService
{
    public const FINE_SOURCES = ['late_fee', 'late_fee_waiver', 'absent_fine'];

    /** Query of per-student course-fee payments, keyed/grouped by student ID. */
    public function studentBaseCollectionQuery(): Builder
    {
        $baseLines = DB::table('fee_voucher_items')
            ->select('fee_voucher_id')
            ->selectRaw(
                'SUM(CASE WHEN source NOT IN (?, ?, ?) THEN amount ELSE 0 END) AS base_amount',
                self::FINE_SOURCES
            )
            ->groupBy('fee_voucher_id');

        $verifiedAllocated = DB::table('fee_payment_allocations as allocations')
            ->join('fee_payments as payments', 'payments.id', '=', 'allocations.fee_payment_id')
            ->where('payments.status', 'verified')
            ->select('allocations.fee_voucher_id')
            ->selectRaw('SUM(allocations.amount) AS paid_amount')
            ->groupBy('allocations.fee_voucher_id');

        return DB::table('fee_vouchers as vouchers')
            ->leftJoinSub($baseLines, 'base_lines', fn ($join) => $join->on('base_lines.fee_voucher_id', '=', 'vouchers.id'))
            ->leftJoinSub($verifiedAllocated, 'verified_allocated', fn ($join) => $join->on('verified_allocated.fee_voucher_id', '=', 'vouchers.id'))
            ->where('vouchers.status', '!=', 'cancelled')
            ->select('vouchers.student_id')
            ->selectRaw(
                'SUM(CASE
                    WHEN COALESCE(base_lines.base_amount, 0) <= 0 THEN 0
                    WHEN COALESCE(verified_allocated.paid_amount, 0) < COALESCE(base_lines.base_amount, 0)
                        THEN COALESCE(verified_allocated.paid_amount, 0)
                    ELSE COALESCE(base_lines.base_amount, 0)
                END) AS base_received'
            )
            ->groupBy('vouchers.student_id');
    }

    /** @param array<int, int|string> $studentIds @return Collection<int, object> keyed by student ID */
    public function baseCollectedByStudents(array $studentIds): Collection
    {
        $studentIds = collect($studentIds)->filter()->unique()->values()->all();
        if ($studentIds === []) {
            return collect();
        }

        return $this->studentBaseCollectionQuery()
            ->whereIn('vouchers.student_id', $studentIds)
            ->get()
            ->keyBy('student_id');
    }

    public function baseCollected(Student|int $student): float
    {
        $studentId = $student instanceof Student ? $student->getKey() : $student;
        $row = $this->baseCollectedByStudents([(int) $studentId])->get($studentId);

        return round((float) ($row->base_received ?? 0), 2);
    }

    public function remainingFinalizedFee(Student $student): float
    {
        if ($student->finalized_fee === null) {
            return 0.0;
        }

        return max(0, round((float) $student->finalized_fee - $this->baseCollected($student), 2));
    }
}
