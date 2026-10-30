<?php

namespace App\Services\Admin;

use App\Models\FeePayment;
use App\Models\FeePlan;
use App\Models\FeeVoucher;
use App\Models\Student;
use App\Support\FeeHelper;

/**
 * Everything shown on one student's "Account Book": the total payable fee, every installment with what has been
 * paid and what is left, payments received, and other charges (admission, exam, ...).
 * All figures come from the vouchers, so the page can never disagree with the payment screen or receipts.
 */
class FeeAccountBookService
{
    public function build(Student $student): array
    {
        $today = FeeHelper::today()->toDateString();
        $plan  = FeePlan::active()->where('student_id', $student->id)->first();

        $live = FeeVoucher::with(['items', 'allocations.payment'])
            ->where('student_id', $student->id)
            ->where('status', '!=', 'cancelled')
            ->orderBy('due_date')->orderBy('id')
            ->get();

        $installments = collect();
        $others       = collect();

        foreach ($live as $v) {
            $late = round((float) $v->items->where('source', 'late_fee')->sum('amount'), 2);
            $row  = [
                'voucher'      => $v,
                'base'         => round((float) $v->total_amount - $late, 2),
                'late_fee'     => $late,
                'total'        => (float) $v->total_amount,
                'paid'         => (float) $v->paid_amount,
                'remaining'    => (float) $v->balance,
                'status'       => $v->status,
                'is_overdue'   => $v->is_overdue,
                'days_overdue' => $v->is_overdue ? max(0, FeeHelper::daysBetween($v->due_date->toDateString(), $today)) : 0,
                'payments'     => $v->allocations->filter(fn ($a) => $a->payment && $a->payment->status === 'verified'),
            ];

            if ($plan && $v->fee_plan_id === $plan->id) {
                $installments->push($row);
            } else {
                $others->push($row);
            }
        }

        $installments = $installments->values()->map(fn ($r, $i) => $r + ['no' => $i + 1]);

        $planPaid      = round((float) $installments->sum('paid'), 2);
        $planRemaining = round((float) $installments->sum('remaining'), 2);
        $planLate      = round((float) $installments->sum('late_fee'), 2);
        $next          = $installments->first(fn ($r) => $r['remaining'] > 0);
        $overdue       = $installments->filter(fn ($r) => $r['is_overdue']);

        $summary = [
            'total_fee'       => $plan ? (float) $plan->total_fee : 0.0,
            'discount'        => $plan ? (float) $plan->discount : 0.0,
            'net_fee'         => $plan ? (float) $plan->net_fee : 0.0,
            'late_fee'        => $planLate,
            'paid'            => $planPaid,
            'remaining'       => $planRemaining,
            'count'           => $installments->count(),
            'paid_count'      => $installments->where('status', 'paid')->count(),
            'remaining_count' => $installments->where('status', '!=', 'paid')->count(),
            'percent'         => $plan && ($plan->net_fee + $planLate) > 0 ? (int) round($planPaid / ((float) $plan->net_fee + $planLate) * 100) : 0,
            'next'            => $next,
            'overdue_amount'  => round((float) $overdue->sum('remaining'), 2),
            'overdue_count'   => $overdue->count(),
        ];

        return [
            'plan'         => $plan,
            'summary'      => $summary,
            'installments' => $installments,
            'others'       => $others,
            'others_due'   => round((float) $others->sum('remaining'), 2),
            'all_due'      => round((float) $live->sum('balance'), 2),
            'payments'     => FeePayment::with('allocations.voucher:id,voucher_number,installment_no,type')
                ->where('student_id', $student->id)->where('status', 'verified')
                ->orderByDesc('payment_date')->orderByDesc('id')->get(),
            'pending'      => FeePayment::where('student_id', $student->id)->where('status', 'pending')->get(),
        ];
    }
}
