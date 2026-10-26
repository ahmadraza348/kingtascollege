<?php

namespace App\Services\Admin;

use App\Models\FeePayment;
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
