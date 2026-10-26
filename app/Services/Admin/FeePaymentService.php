<?php

namespace App\Services\Admin;

use App\Models\FeeAuditLog;
use App\Models\FeePayment;
use App\Models\FeePaymentAllocation;
use App\Models\FeeVoucher;
use App\Models\Student;
use App\Support\FeeHelper;
use Carbon\CarbonImmutable;
use DomainException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;

/**
 * Payments entered by the single admin are confirmed immediately. For bank deposits,
 * the admin records the payment after checking the bank slip/account.
 */
class FeePaymentService
{
    public function __construct(private FeeVoucherService $vouchers)
    {
    }

    /**
     * @param  array{payment_date:string,method:string,amount:mixed,bank_name?:?string,branch?:?string,reference_no?:?string,remarks?:?string,preferred_voucher_id?:mixed,submit_token?:?string}  $data
     *
     * @throws DomainException
     */
    public function record(Student $student, array $data): FeePayment
    {
        $method = $data['method'];
        $amount = round((float) $data['amount'], 2);

        // The same bank slip / transaction number can only be entered once.
        $dedupe = null;
        if ($method !== 'cash') {
            $dedupe = md5(strtolower(trim($data['bank_name'] ?? '')) . '|' . strtolower(trim($data['reference_no'] ?? '')));

            if (FeePayment::where('dedupe_key', $dedupe)->exists()) {
                throw new DomainException('This bank / reference number has already been recorded.');
            }
        }

        try {
            return DB::transaction(function () use ($student, $data, $method, $amount, $dedupe) {
                $payment = FeePayment::create([
                    'student_id'           => $student->id,
                    'payment_date'         => $data['payment_date'],
                    'method'               => $method,
                    'amount'               => $amount,
                    'bank_name'            => $data['bank_name'] ?? null,
                    'branch'               => $data['branch'] ?? null,
                    'reference_no'         => $data['reference_no'] ?? null,
                    'dedupe_key'           => $dedupe,
                    'submit_token'         => $data['submit_token'] ?? null,
                    'preferred_voucher_id' => $data['preferred_voucher_id'] ?? null,
                    'remarks'              => $data['remarks'] ?? null,
                    'status'               => 'pending',
                    'received_by'          => auth('admin')->id(),
                ]);

                FeeAuditLog::record('payment_recorded', FeeHelper::money($amount) . ' by ' . FeePayment::METHODS[$method] . ' recorded.', $student->id, null, $payment->id, $amount);

                // If confirmation fails (for example, too much money) the whole record is undone.
                return $this->verify($payment);
            });
        } catch (UniqueConstraintViolationException) {
            throw new DomainException('This payment was already saved (the button may have been clicked twice).');
        }
    }

    /**
     * Confirms a payment and spreads it over the student's unpaid vouchers, oldest first
     * (the voucher chosen on the form, if any, is paid first).
     *
     * @throws DomainException
     */
    public function verify(FeePayment $payment): FeePayment
    {
        return DB::transaction(function () use ($payment) {
            $payment = FeePayment::whereKey($payment->id)->lockForUpdate()->firstOrFail();

            if ($payment->status !== 'pending') {
                throw new DomainException('This payment is already ' . strtolower($payment->status_label) . '.');
            }

            $paidOn = CarbonImmutable::parse($payment->payment_date->toDateString());

            $open = FeeVoucher::where('student_id', $payment->student_id)->open()
                ->orderBy('period')->orderBy('id')->lockForUpdate()->get();

            // Late fee is worked out for the day the money was paid, not the day it was checked.
            foreach ($open as $voucher) {
                $this->vouchers->applyLateFee($voucher, $paidOn);
            }

            $outstanding = FeeHelper::paisa($open->sum('balance'));
            $amount      = FeeHelper::paisa($payment->amount);

            if ($amount > $outstanding) {
                throw new DomainException('The amount (' . FeeHelper::money($payment->amount) . ') is more than this student owes (' . FeeHelper::money(FeeHelper::rupees($outstanding)) . ').');
            }

            $preferred = (int) $payment->preferred_voucher_id;
            $ordered   = $open->sortBy(fn ($v) => [$v->id === $preferred ? 0 : 1, $v->period, $v->id])->values();

            $left = $amount;
            foreach ($ordered as $voucher) {
                if ($left <= 0) {
                    break;
                }

                $take = min($left, FeeHelper::paisa($voucher->balance));

                if ($take <= 0) {
                    continue;
                }

                FeePaymentAllocation::create([
                    'fee_payment_id' => $payment->id,
                    'fee_voucher_id' => $voucher->id,
                    'amount'         => FeeHelper::rupees($take),
                ]);

                $this->vouchers->refreshTotals($voucher);
                $left -= $take;
            }

            $payment->forceFill([
                'status'         => 'verified',
                'verified_at'    => now(),
                'verified_by'    => auth('admin')->id(),
                'receipt_number' => sprintf('RC-%s-%05d', FeeHelper::today()->format('ym'), $payment->id),
                'balance_after'  => FeeHelper::rupees($outstanding - $amount),
            ])->save();

            FeeAuditLog::record('payment_verified', 'Payment of ' . FeeHelper::money($payment->amount) . ' confirmed. Receipt ' . $payment->receipt_number . '.', $payment->student_id, null, $payment->id, (float) $payment->amount);

            return $payment;
        });
    }

    /** @throws DomainException */
    public function reject(FeePayment $payment, string $reason): void
    {
        if ($payment->status !== 'pending') {
            throw new DomainException('Only a pending payment can be rejected.');
        }

        $payment->forceFill([
            'status'        => 'rejected',
            'status_reason' => $reason,
            'dedupe_key'    => null, // the correct slip can be entered again
        ])->save();

        FeeAuditLog::record('payment_rejected', 'Payment of ' . FeeHelper::money($payment->amount) . ' rejected. Reason: ' . $reason, $payment->student_id, null, $payment->id, (float) $payment->amount);
    }

    /** Undo a confirmed payment (for example a bounced cheque). The vouchers become unpaid again. */
    public function cancel(FeePayment $payment, string $reason): void
    {
        DB::transaction(function () use ($payment, $reason) {
            $payment = FeePayment::whereKey($payment->id)->lockForUpdate()->firstOrFail();

            if ($payment->status !== 'verified') {
                throw new DomainException('Only a verified payment can be cancelled.');
            }

            $vouchers = FeeVoucher::whereIn('id', $payment->allocations()->pluck('fee_voucher_id'))->get();

            $payment->allocations()->delete();

            foreach ($vouchers as $voucher) {
                $this->vouchers->refreshTotals($voucher);
            }

            $payment->forceFill(['status' => 'cancelled', 'status_reason' => $reason, 'dedupe_key' => null])->save();

            FeeAuditLog::record('payment_cancelled', 'Payment ' . $payment->receipt_number . ' (' . FeeHelper::money($payment->amount) . ') cancelled. Reason: ' . $reason, $payment->student_id, null, $payment->id, (float) $payment->amount);
        });
    }

    /** Total the student still owes on open vouchers. */
    public function outstanding(Student $student): float
    {
        return round((float) FeeVoucher::where('student_id', $student->id)->open()->sum('balance'), 2);
    }
}
