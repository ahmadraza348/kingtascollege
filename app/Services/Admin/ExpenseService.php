<?php

namespace App\Services\Admin;

use App\Models\Expense;
use App\Models\ExpensePayment;
use App\Support\FeeHelper;
use DomainException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

/** Everything that changes an expense or the money paid against it. */
class ExpenseService
{
    private const DISK = 'local'; // private: files are only served through the admin-only download route

    /**
     * Save a new expense. Depending on payment_option it is stored as unpaid (a due),
     * paid in full, or partly paid.
     *
     * @throws DomainException
     */
    public function create(array $data, ?UploadedFile $file = null): Expense
    {
        $amount = round((float) $data['amount'], 2);
        $stored = $file ? $this->storeFile($file) : null;

        try {
            return DB::transaction(function () use ($data, $amount, $stored, $file) {
                $expense = Expense::create([
                    'expense_category_id' => $data['expense_category_id'],
                    'title'               => $data['title'],
                    'payee'               => $data['payee'] ?? null,
                    'reference_no'        => $data['reference_no'] ?? null,
                    'expense_date'        => $data['expense_date'],
                    'due_date'            => ($data['payment_option'] ?? 'unpaid') === 'paid' ? null : ($data['due_date'] ?? null),
                    'amount'              => $amount,
                    'paid_amount'         => 0,
                    'status'              => 'unpaid',
                    'description'         => $data['description'] ?? null,
                    'attachment_path'     => $stored,
                    'attachment_name'     => $stored ? mb_substr($file->getClientOriginalName(), 0, 250) : null,
                    'submit_token'        => $data['submit_token'] ?? null,
                    'created_by'          => auth('admin')->id(),
                ]);

                $expense->update(['expense_number' => sprintf('EX-%s-%05d', FeeHelper::today()->format('ym'), $expense->id)]);

                $option = $data['payment_option'] ?? 'unpaid';
                if ($option !== 'unpaid') {
                    $this->addPayment($expense, [
                        'payment_date' => $data['payment_date'] ?? $data['expense_date'],
                        'amount'       => $option === 'paid' ? $amount : $data['paid_amount'],
                        'method'       => $data['payment_method'],
                        'reference_no' => $data['payment_reference'] ?? null,
                        'remarks'      => null,
                    ]);
                }

                return $expense->refresh();
            });
        } catch (UniqueConstraintViolationException) {
            $this->deleteFile($stored);

            throw new DomainException('This expense was already saved (the button may have been clicked twice).');
        } catch (Throwable $e) {
            $this->deleteFile($stored);

            throw $e;
        }
    }

    /** @throws DomainException */
    public function update(Expense $expense, array $data, ?UploadedFile $file = null, bool $removeFile = false): Expense
    {
        $amount = round((float) $data['amount'], 2);
        $newFile = $file ? $this->storeFile($file) : null;

        try {
            $oldFile = DB::transaction(function () use ($expense, $data, $amount, $newFile, $file, $removeFile) {
                $expense = Expense::whereKey($expense->id)->lockForUpdate()->firstOrFail();

                if ($expense->status === 'cancelled') {
                    throw new DomainException('A cancelled expense cannot be edited.');
                }
                if (FeeHelper::paisa($amount) < FeeHelper::paisa($expense->paid_amount)) {
                    throw new DomainException('The amount cannot be lower than the ' . FeeHelper::money($expense->paid_amount) . ' already paid. Cancel a payment first if it was entered by mistake.');
                }

                $old = $expense->attachment_path;
                $changes = [
                    'expense_category_id' => $data['expense_category_id'],
                    'title'               => $data['title'],
                    'payee'               => $data['payee'] ?? null,
                    'reference_no'        => $data['reference_no'] ?? null,
                    'expense_date'        => $data['expense_date'],
                    'due_date'            => $data['due_date'] ?? null,
                    'amount'              => $amount,
                    'description'         => $data['description'] ?? null,
                ];

                if ($newFile) {
                    $changes['attachment_path'] = $newFile;
                    $changes['attachment_name'] = mb_substr($file->getClientOriginalName(), 0, 250);
                } elseif ($removeFile) {
                    $changes['attachment_path'] = null;
                    $changes['attachment_name'] = null;
                }

                $expense->update($changes);
                $this->refreshTotals($expense);

                return ($newFile || $removeFile) ? $old : null;
            });
        } catch (Throwable $e) {
            $this->deleteFile($newFile);

            throw $e;
        }

        $this->deleteFile($oldFile);

        return $expense->refresh();
    }

    /**
     * Record money paid out. The amount can never be more than what is still due.
     *
     * @param  array{payment_date:string,amount:mixed,method:string,reference_no?:?string,remarks?:?string,submit_token?:?string}  $data
     *
     * @throws DomainException
     */
    public function addPayment(Expense $expense, array $data): ExpensePayment
    {
        $amount = round((float) $data['amount'], 2);

        try {
            return DB::transaction(function () use ($expense, $data, $amount) {
                $expense = Expense::whereKey($expense->id)->lockForUpdate()->firstOrFail();

                if ($expense->status === 'cancelled') {
                    throw new DomainException('A cancelled expense cannot be paid.');
                }
                if ($amount <= 0) {
                    throw new DomainException('Enter an amount greater than zero.');
                }

                $balance = round((float) $expense->amount - (float) $expense->paid_amount, 2);
                if (FeeHelper::paisa($amount) > FeeHelper::paisa($balance)) {
                    throw new DomainException('The payment is more than the balance due (' . FeeHelper::money($balance) . ').');
                }

                $payment = ExpensePayment::create([
                    'expense_id'   => $expense->id,
                    'payment_date' => $data['payment_date'],
                    'amount'       => $amount,
                    'method'       => $data['method'],
                    'reference_no' => $data['reference_no'] ?? null,
                    'remarks'      => $data['remarks'] ?? null,
                    'status'       => 'active',
                    'submit_token' => $data['submit_token'] ?? null,
                    'created_by'   => auth('admin')->id(),
                ]);

                $this->refreshTotals($expense);

                return $payment;
            });
        } catch (UniqueConstraintViolationException) {
            throw new DomainException('This payment was already saved (the button may have been clicked twice).');
        }
    }

    /** Undo a payment entered by mistake (or a bounced cheque). The bill becomes due again. */
    public function cancelPayment(ExpensePayment $payment, string $reason): void
    {
        DB::transaction(function () use ($payment, $reason) {
            $expense = Expense::whereKey($payment->expense_id)->lockForUpdate()->firstOrFail();
            $payment = ExpensePayment::whereKey($payment->id)->lockForUpdate()->firstOrFail();

            if ($payment->status === 'cancelled') {
                throw new DomainException('This payment is already cancelled.');
            }

            $payment->update(['status' => 'cancelled', 'cancel_reason' => $reason, 'cancelled_at' => now()]);
            $this->refreshTotals($expense);
        });
    }

    /** Cancel a whole bill (entered by mistake). Expenses are never deleted, so the history stays complete. */
    public function cancelExpense(Expense $expense, string $reason): void
    {
        DB::transaction(function () use ($expense, $reason) {
            $expense = Expense::whereKey($expense->id)->lockForUpdate()->firstOrFail();

            if ($expense->status === 'cancelled') {
                throw new DomainException('This expense is already cancelled.');
            }
            if ($expense->payments()->active()->exists()) {
                throw new DomainException('This expense has payments. Cancel its payments first, then cancel the expense.');
            }

            $expense->update([
                'status'        => 'cancelled',
                'status_reason' => $reason,
                'cancelled_at'  => now(),
                'cancelled_by'  => auth('admin')->id(),
            ]);
        });
    }

    /** Recalculate paid amount and status from the active payments. */
    public function refreshTotals(Expense $expense): void
    {
        if ($expense->status === 'cancelled') {
            return;
        }

        $paid = round((float) $expense->payments()->active()->sum('amount'), 2);
        $paidPaisa = FeeHelper::paisa($paid);
        $amountPaisa = FeeHelper::paisa($expense->amount);

        $expense->update([
            'paid_amount' => $paid,
            'status'      => $paidPaisa >= $amountPaisa ? 'paid' : ($paidPaisa > 0 ? 'partial' : 'unpaid'),
        ]);
    }

    private function storeFile(UploadedFile $file): string
    {
        return $file->store('expenses', self::DISK);
    }

    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk(self::DISK)->delete($path);
        }
    }

    public function disk(): string
    {
        return self::DISK;
    }
}
