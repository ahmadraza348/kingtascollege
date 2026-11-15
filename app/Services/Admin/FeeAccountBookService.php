<?php

namespace App\Services\Admin;

use App\Models\FeePayment;
use App\Models\FeeVoucher;
use App\Models\FeeVoucherItem;
use App\Models\Student;
use App\Support\FeeHelper;

/** Builds one student's fee summary, voucher list, receipts and ledger data. */
class FeeAccountBookService
{
    public function build(Student $student): array
    {
        $today = FeeHelper::today()->toDateString();

        $vouchers = FeeVoucher::with(['items', 'allocations.payment'])
            ->where('student_id', $student->id)
            ->where('status', '!=', 'cancelled')
            ->orderByDesc('issue_date')
            ->orderByDesc('id')
            ->get();

        $voucherRows = $vouchers->map(function (FeeVoucher $voucher) use ($today) {
            $lateFee = round((float) $voucher->items->where('source', 'late_fee')->sum('amount'), 2);
            $isOverdue = in_array($voucher->status, ['unpaid', 'partial'], true)
                && $voucher->due_date->toDateString() < $today;

            return [
                'voucher'      => $voucher,
                'base'         => round((float) $voucher->total_amount - $lateFee, 2),
                'late_fee'     => $lateFee,
                'total'        => (float) $voucher->total_amount,
                'paid'         => (float) $voucher->paid_amount,
                'remaining'    => (float) $voucher->balance,
                'status'       => $voucher->status,
                'is_overdue'   => $isOverdue,
                'days_overdue' => $isOverdue ? max(0, FeeHelper::daysBetween($voucher->due_date->toDateString(), $today)) : 0,
                'payments'     => $voucher->allocations->filter(fn ($allocation) => $allocation->payment && $allocation->payment->status === 'verified'),
            ];
        })->values();

        $payments = FeePayment::with('allocations.voucher:id,voucher_number,installment_no,type')
            ->where('student_id', $student->id)
            ->where('status', 'verified')
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->get();

        $finalizedFee = $student->finalized_fee === null ? null : (float) $student->finalized_fee;
        $received = round((float) $payments->sum('amount'), 2);
        $remaining = $finalizedFee === null ? 0.0 : max(0, round($finalizedFee - $received, 2));
        $overdue = $voucherRows->filter(fn ($row) => $row['is_overdue']);
        $billedBase = round((float) FeeVoucherItem::whereHas('voucher', fn ($query) => $query
            ->where('student_id', $student->id)
            ->where('status', '!=', 'cancelled'))
            ->where('source', '!=', 'late_fee')
            ->sum('amount'), 2);

        return [
            'summary' => [
                'total_fee'       => $finalizedFee,
                'paid'            => $received,
                'remaining'       => $remaining,
                'percent'         => $finalizedFee && $finalizedFee > 0 ? min(100, (int) round($received / $finalizedFee * 100)) : 0,
                'voucher_billed'  => round((float) $vouchers->sum('total_amount'), 2),
                'voucher_paid'    => round((float) $vouchers->sum('paid_amount'), 2),
                'voucher_due'     => round((float) $vouchers->sum('balance'), 2),
                'unbilled'        => $finalizedFee === null ? 0.0 : max(0, round($finalizedFee - $billedBase, 2)),
                'late_fee'        => round((float) $voucherRows->sum('late_fee'), 2),
                'overdue_amount'  => round((float) $overdue->sum('remaining'), 2),
                'overdue_count'   => $overdue->count(),
            ],
            'vouchers' => $voucherRows,
            'payments' => $payments,
            'pending'  => FeePayment::where('student_id', $student->id)->where('status', 'pending')->orderByDesc('id')->get(),
        ];
    }
}
