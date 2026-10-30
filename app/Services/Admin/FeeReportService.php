<?php

namespace App\Services\Admin;

use App\Models\FeePayment;
use App\Models\FeePlan;
use App\Models\SchoolClass;
use App\Models\FeeVoucher;
use App\Models\FeeVoucherItem;
use App\Models\Student;
use App\Support\FeeHelper;

/** Data used by the fee dashboard and an individual student's fee statement. */
class FeeReportService
{
    public function dashboard(): array
    {
        $today = FeeHelper::today();
        $verifiedPayments = fn () => FeePayment::where('status', 'verified');

        $monthVouchers = FeeVoucher::where('period', $today->format('Y-m'))
            ->where('status', '!=', 'cancelled')
            ->selectRaw('status, COUNT(*) AS total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'today' => (float) $verifiedPayments()->whereDate('payment_date', $today->toDateString())->sum('amount'),
            'month' => (float) $verifiedPayments()->whereBetween('payment_date', [
                $today->startOfMonth()->toDateString(),
                $today->toDateString(),
            ])->sum('amount'),
            'outstanding' => (float) FeeVoucher::open()->sum('balance'),
            'overdue_amount' => (float) FeeVoucher::overdue()->sum('balance'),
            'overdue_students' => FeeVoucher::overdue()->distinct()->count('student_id'),
            'month_vouchers' => $monthVouchers,
            'month_label' => $today->format('F Y'),
            'recent' => FeePayment::with('student:id,full_name,roll_number')
                ->where('status', 'verified')
                ->latest('id')
                ->limit(8)
                ->get(),
        ];
    }

    /** Numbers for the installment / fee plan part of the dashboard. */
    public function planAnalytics(): array
    {
        $today   = FeeHelper::today();
        $todayS  = $today->toDateString();
        $plans   = fn () => FeeVoucher::whereNotNull('fee_plan_id')->where('status', '!=', 'cancelled');

        $money = $plans()->toBase()->selectRaw('COALESCE(SUM(total_amount),0) AS total, COALESCE(SUM(paid_amount),0) AS paid, COALESCE(SUM(balance),0) AS balance, COUNT(*) AS n')->first();
        $total = (float) $money->total;
        $paid  = (float) $money->paid;

        $byStatus = $plans()->selectRaw('status, COUNT(*) AS n')->groupBy('status')->pluck('n', 'status');

        $overdue  = $plans()->overdue()->toBase()->selectRaw('COUNT(*) AS n, COALESCE(SUM(balance),0) AS amount, COUNT(DISTINCT student_id) AS students')->first();
        $soon     = $plans()->open()->whereBetween('due_date', [$todayS, $today->addDays(7)->toDateString()])
            ->toBase()->selectRaw('COUNT(*) AS n, COALESCE(SUM(balance),0) AS amount')->first();
        $thisMonth = $plans()->open()->whereBetween('due_date', [$today->startOfMonth()->toDateString(), $today->endOfMonth()->toDateString()])
            ->toBase()->selectRaw('COALESCE(SUM(balance),0) AS amount')->first();

        $activeStudents = Student::active()->count();
        $withPlan       = Student::active()->whereIn('id', FeePlan::active()->select('student_id'))->count();

        // Collected per month, last 6 months (grouped in PHP so it works on any database).
        $from   = $today->startOfMonth()->subMonthsNoOverflow(5);
        $months = collect(range(0, 5))->mapWithKeys(fn ($i) => [$from->addMonthsNoOverflow($i)->format('Y-m') => 0.0]);
        FeePayment::where('status', 'verified')->where('payment_date', '>=', $from->toDateString())
            ->get(['payment_date', 'amount'])
            ->each(function ($p) use ($months) {
                $key = $p->payment_date->format('Y-m');
                if ($months->has($key)) {
                    $months[$key] = round($months[$key] + (float) $p->amount, 2);
                }
            });

        $byClass = $plans()->toBase()->selectRaw('school_class_id, COALESCE(SUM(total_amount),0) AS total, COALESCE(SUM(paid_amount),0) AS paid, COALESCE(SUM(balance),0) AS balance')
            ->groupBy('school_class_id')->get();
        $classNames = SchoolClass::whereIn('id', $byClass->pluck('school_class_id'))->pluck('name', 'id');

        return [
            'plans'          => FeePlan::active()->count(),
            'expected'       => $total,
            'collected'      => $paid,
            'remaining'      => (float) $money->balance,
            'percent'        => $total > 0 ? (int) round($paid / $total * 100) : 0,
            'installments'   => (int) $money->n,
            'paid_count'     => (int) ($byStatus['paid'] ?? 0),
            'partial_count'  => (int) ($byStatus['partial'] ?? 0),
            'unpaid_count'   => (int) ($byStatus['unpaid'] ?? 0),
            'overdue_count'  => (int) $overdue->n,
            'overdue_amount' => (float) $overdue->amount,
            'overdue_students' => (int) $overdue->students,
            'soon_count'     => (int) $soon->n,
            'soon_amount'    => (float) $soon->amount,
            'month_due'      => (float) $thisMonth->amount,
            'active_students' => $activeStudents,
            'with_plan'      => $withPlan,
            'without_plan'   => max(0, $activeStudents - $withPlan),
            'months'         => $months,
            'by_class'       => $byClass->map(fn ($r) => [
                'name'    => $classNames[$r->school_class_id] ?? '—',
                'total'   => (float) $r->total,
                'paid'    => (float) $r->paid,
                'balance' => (float) $r->balance,
                'percent' => $r->total > 0 ? (int) round($r->paid / $r->total * 100) : 0,
            ])->sortBy('name')->values(),
            'upcoming'       => $plans()->open()->where('due_date', '>=', $todayS)->with('student:id,full_name,roll_number,deleted_at')
                ->orderBy('due_date')->orderBy('id')->limit(8)->get(),
            'top_overdue'    => $plans()->overdue()->selectRaw('student_id, COUNT(*) AS n, SUM(balance) AS amount, MIN(due_date) AS oldest')
                ->groupBy('student_id')->orderByDesc('amount')->limit(8)->get()
                ->each(fn ($r) => $r->setRelation('student', Student::withTrashed()->select('id', 'full_name', 'roll_number')->find($r->student_id))),
        ];
    }

    /** Return a dated list of this student's charges and confirmed payments. */
    public function statement(Student $student): array
    {
        $events = collect();

        FeeVoucherItem::with('voucher:id,voucher_number')
            ->whereHas('voucher', fn ($query) => $query
                ->where('student_id', $student->id)
                ->where('status', '!=', 'cancelled'))
            ->get()
            ->each(function ($item) use ($events) {
                $amount = (float) $item->amount;

                $events->push([
                    'date' => $item->charged_on->toDateString(),
                    'order' => 0,
                    'id' => $item->id,
                    'text' => $item->title . ' (' . $item->voucher->voucher_number . ')',
                    'debit' => max($amount, 0),
                    'credit' => abs(min($amount, 0)),
                ]);
            });

        FeePayment::where('student_id', $student->id)
            ->where('status', 'verified')
            ->get()
            ->each(function ($payment) use ($events) {
                $events->push([
                    'date' => $payment->payment_date->toDateString(),
                    'order' => 1,
                    'id' => $payment->id,
                    'text' => 'Payment received – ' . $payment->receipt_number . ' (' . $payment->method_label . ')',
                    'debit' => 0,
                    'credit' => (float) $payment->amount,
                ]);
            });

        $balance = 0.0;
        $rows = $events->sortBy(fn ($event) => [$event['date'], $event['order'], $event['id']])
            ->values()
            ->map(function ($event) use (&$balance) {
                $balance = round($balance + $event['debit'] - $event['credit'], 2);

                return $event + ['balance' => $balance];
            });

        return [
            'rows' => $rows,
            'debit' => round((float) $rows->sum('debit'), 2),
            'credit' => round((float) $rows->sum('credit'), 2),
            'balance' => $balance,
            'pending' => FeePayment::where('student_id', $student->id)->where('status', 'pending')->get(),
        ];
    }
}
