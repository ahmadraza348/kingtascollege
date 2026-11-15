<?php

namespace App\Services\Admin;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpensePayment;
use App\Models\FeePayment;
use App\Support\FeeHelper;
use Carbon\CarbonImmutable;

/** Numbers shown on the Expenses dashboard. */
class ExpenseReportService
{
    /** @param string $month  "Y-m" */
    public function dashboard(string $month): array
    {
        $today = FeeHelper::today();
        $start = CarbonImmutable::createFromFormat('Y-m-d', $month . '-01', config('fees.timezone', 'UTC'))->startOfDay();
        $end = $start->endOfMonth();
        $from = $start->toDateString();
        $to = $end->toDateString();

        // What was billed this month (by bill date).
        $monthExpenses = Expense::notCancelled()->whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to);
        $billed = round((float) (clone $monthExpenses)->sum('amount'), 2);

        // Money that actually left the school this month (by payment date).
        $paidOut = round((float) ExpensePayment::active()
            ->whereDate('payment_date', '>=', $from)->whereDate('payment_date', '<=', $to)->sum('amount'), 2);

        // Fees received from students in the same month (existing fee module).
        $collected = round((float) FeePayment::where('status', 'verified')
            ->whereDate('payment_date', '>=', $from)->whereDate('payment_date', '<=', $to)->sum('amount'), 2);

        $payable = round((float) Expense::open()->selectRaw('COALESCE(SUM(amount - paid_amount), 0) AS due')->value('due'), 2);
        $overdue = round((float) Expense::overdue()->selectRaw('COALESCE(SUM(amount - paid_amount), 0) AS due')->value('due'), 2);

        $byCategory = Expense::notCancelled()
            ->whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to)
            ->selectRaw('expense_category_id, SUM(amount) AS total, COUNT(*) AS bills')
            ->groupBy('expense_category_id')
            ->orderByDesc('total')
            ->get();
        $names = ExpenseCategory::whereIn('id', $byCategory->pluck('expense_category_id'))->pluck('name', 'id');
        $categories = $byCategory->map(fn ($row) => [
            'name'    => $names[$row->expense_category_id] ?? 'Unknown',
            'total'   => round((float) $row->total, 2),
            'bills'   => (int) $row->bills,
            'percent' => $billed > 0 ? round(((float) $row->total / $billed) * 100, 1) : 0,
        ]);

        return [
            'month'          => $month,
            'month_label'    => $start->format('F Y'),
            'prev_month'     => $start->subMonth()->format('Y-m'),
            'next_month'     => $start->addMonth()->lessThanOrEqualTo($today) ? $start->addMonth()->format('Y-m') : null,
            'billed'         => $billed,
            'paid_out'       => $paidOut,
            'collected'      => $collected,
            'net'            => round($collected - $paidOut, 2),
            'payable'        => $payable,
            'overdue'        => $overdue,
            'overdue_count'  => Expense::overdue()->count(),
            'open_count'     => Expense::open()->count(),
            'categories'     => $categories,
            'upcoming'       => Expense::with('category:id,name')->open()
                ->orderByRaw('due_date IS NULL')->orderBy('due_date')->orderBy('id')->limit(8)->get(),
            'recent'         => Expense::with('category:id,name')->notCancelled()->latest('expense_date')->latest('id')->limit(8)->get(),
            'trend'          => $this->trend($start),
        ];
    }

    /** Fees collected vs money paid out for the 6 months ending with $end. */
    private function trend(CarbonImmutable $end): array
    {
        $first = $end->subMonths(5)->startOfMonth();
        $rows = [];
        for ($i = 0; $i < 6; $i++) {
            $m = $first->addMonths($i);
            $rows[$m->format('Y-m')] = ['label' => $m->format('M Y'), 'collected' => 0.0, 'paid_out' => 0.0, 'billed' => 0.0];
        }
        $from = $first->toDateString();
        $to = $end->endOfMonth()->toDateString();

        foreach (FeePayment::where('status', 'verified')->whereDate('payment_date', '>=', $from)->whereDate('payment_date', '<=', $to)->get(['payment_date', 'amount']) as $p) {
            $key = $p->payment_date->format('Y-m');
            if (isset($rows[$key])) {
                $rows[$key]['collected'] += (float) $p->amount;
            }
        }
        foreach (ExpensePayment::active()->whereDate('payment_date', '>=', $from)->whereDate('payment_date', '<=', $to)->get(['payment_date', 'amount']) as $p) {
            $key = $p->payment_date->format('Y-m');
            if (isset($rows[$key])) {
                $rows[$key]['paid_out'] += (float) $p->amount;
            }
        }
        foreach (Expense::notCancelled()->whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to)->get(['expense_date', 'amount']) as $e) {
            $key = $e->expense_date->format('Y-m');
            if (isset($rows[$key])) {
                $rows[$key]['billed'] += (float) $e->amount;
            }
        }

        return array_values($rows);
    }
}
