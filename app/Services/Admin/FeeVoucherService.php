<?php

namespace App\Services\Admin;

use App\Models\FeeAuditLog;
use App\Models\FeeHead;
use App\Models\FeeSetting;
use App\Models\FeeVoucherItem;
use App\Models\FeeVoucher;
use App\Models\Student;
use App\Support\FeeHelper;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use DomainException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Create vouchers, calculate the balance, print the fee breakdown, and cancel incorrect vouchers.
 * Rule of thumb: a voucher only contains its OWN charges. Arrears are looked up from older vouchers
 * whenever they are needed, so the same money can never be counted twice.
 */
class FeeVoucherService
{
    private ?array $headIds = null;


    /* ------------------------------------------------------------------
     |  Creating vouchers
     * ------------------------------------------------------------------ */

    /**
     * @param  array{type:string,period:string,issue_date:string,due_date:string,amount?:mixed,description?:?string,include_absent_fine?:mixed}  $data
     *
     * @throws DomainException
     */
    public function create(Student $student, array $data): FeeVoucher
    {
        $type   = $data['type'];
        $period = $data['period'];

        $lines = $this->buildLines($student, $type, $period, $data);
        $total = round(array_sum(array_column($lines, 'amount')), 2);

        if ($total <= 0) {
            throw new DomainException('The voucher total is zero, so nothing was created.');
        }

        // "other" charges can repeat; every other type is allowed once per student and month.
        $uniqueKey = $type === 'other' ? null : $type . ':' . $period;

        if ($uniqueKey) {
            $existing = FeeVoucher::where('student_id', $student->id)->where('unique_key', $uniqueKey)->first();

            if ($existing) {
                throw new DomainException($student->full_name . ' already has a ' . FeeVoucher::TYPES[$type] . ' voucher for ' . FeeHelper::periodLabel($period) . ' (' . $existing->voucher_number . ').');
            }
        }

        try {
            return DB::transaction(function () use ($student, $data, $type, $period, $lines, $uniqueKey) {
                $lockedStudent = Student::whereKey($student->id)->lockForUpdate()->firstOrFail();
                $finalizedFee = $lockedStudent->finalized_fee;

                if ($finalizedFee === null || (float) $finalizedFee <= 0) {
                    throw new DomainException('Set this student’s finalized total fee in the Student record before creating a voucher.');
                }

                $alreadyBilled = (float) FeeVoucherItem::whereHas('voucher', fn ($q) => $q
                    ->where('student_id', $student->id)
                    ->where('status', '!=', 'cancelled'))
                    ->where('source', '!=', 'late_fee')
                    ->sum('amount');
                $newBilled = round(array_sum(array_column($lines, 'amount')), 2);
                $remainingToBill = max(0, round((float) $finalizedFee - $alreadyBilled, 2));

                if ($newBilled > $remainingToBill + 0.001) {
                    throw new DomainException('This voucher is higher than the remaining unbilled fee (' . FeeHelper::money($remainingToBill) . '). Update the student’s finalized fee if the agreed total has changed.');
                }

                $voucher = FeeVoucher::create([
                    'student_id'      => $student->id,
                    'school_class_id' => $student->school_class_id,
                    'section_id'      => $student->section_id,
                    'roll_number'     => $student->roll_number,
                    'type'            => $type,
                    'period'          => $period,
                    'unique_key'      => $uniqueKey,
                    'issue_date'      => $data['issue_date'],
                    'due_date'        => $data['due_date'],
                    'status'          => 'unpaid',
                    'created_by'      => auth('admin')->id(),
                ]);

                foreach ($lines as $line) {
                    $voucher->items()->create([
                        'fee_head_id' => $line['head_id'] ?? null,
                        'title'       => $line['title'],
                        'amount'      => $line['amount'],
                        'source'      => $line['source'],
                        'charged_on'  => $data['issue_date'],
                        'created_by'  => auth('admin')->id(),
                    ]);
                }

                // Number built from the id, so it is unique without any counter logic: FV-2610-00042
                $voucher->voucher_number = sprintf('FV-%s%s-%05d', substr($period, 2, 2), substr($period, 5, 2), $voucher->id);
                $this->refreshTotals($voucher);

                FeeAuditLog::record('created', 'Voucher ' . $voucher->voucher_number . ' created for ' . FeeHelper::periodLabel($period) . '.', $student->id, $voucher->id, null, (float) $voucher->total_amount);

                return $voucher;
            });
        } catch (UniqueConstraintViolationException) {
            throw new DomainException('This voucher already exists. Please refresh the page.');
        }
    }

    /**
     * Which lines will this voucher have?
     *
     * @return array<int, array{head_id:?int,title:string,amount:float,source:string}>
     */
    private function buildLines(Student $student, string $type, string $period, array $data): array
    {
        $amount = round((float) ($data['amount'] ?? 0), 2);

        if ($amount <= 0) {
            throw new DomainException('Enter an amount greater than zero.');
        }

        $description = trim((string) ($data['description'] ?? ''));
        $title = $description !== ''
            ? $description
            : (FeeVoucher::TYPES[$type] ?? 'Fee') . ' - ' . FeeHelper::periodLabel($period);

        $line = [
            'head_id' => $type === 'opening' ? $this->headId('PREVIOUS_DUES') : null,
            'title'   => $title,
            'amount'  => $amount,
            'source'  => $type === 'opening' ? 'opening' : 'manual',
        ];

        return [$line];
    }

    private function headId(string $code): int
    {
        $this->headIds ??= FeeHead::pluck('id', 'code')->all();

        return $this->headIds[$code];
    }

    /** Due date = the "due day" from Settings, inside the billing month. */
    public function defaultDueDate(string $period): string
    {
        $first = CarbonImmutable::createFromFormat('Y-m-d', $period . '-01');
        $day   = max(1, min((int) FeeSetting::number('due_day'), $first->daysInMonth));

        return $first->day($day)->toDateString();
    }

    /* ------------------------------------------------------------------
     |  Totals, arrears
     * ------------------------------------------------------------------ */

    /** The one place that works out total / paid / balance / status of a voucher. */
    public function refreshTotals(FeeVoucher $voucher): FeeVoucher
    {
        $total   = round((float) $voucher->items()->sum('amount'), 2);
        $paid    = round((float) $voucher->allocations()->sum('amount'), 2);
        $balance = round($total - $paid, 2);

        if ($voucher->status === 'cancelled') {
            $status  = 'cancelled';
            $balance = 0;
        } elseif ($balance <= 0) {
            $status = 'paid';
        } elseif ($paid > 0) {
            $status = 'partial';
        } else {
            $status = 'unpaid';
        }

        $voucher->forceFill(['total_amount' => $total, 'paid_amount' => $paid, 'balance' => $balance, 'status' => $status])->save();

        return $voucher;
    }

    /** Unpaid balances of the student's OLDER months (never of this voucher's own month). */
    public function arrearsList(FeeVoucher $voucher): Collection
    {
        return FeeVoucher::where('student_id', $voucher->student_id)
            ->where('id', '!=', $voucher->id)
            ->where('status', '!=', 'cancelled')
            ->where('balance', '>', 0)
            ->where('period', '<', $voucher->period)
            ->orderBy('period')->orderBy('id')
            ->get(['id', 'voucher_number', 'period', 'type', 'balance', 'due_date']);
    }

    public function arrears(FeeVoucher $voucher): float
    {
        return round((float) $this->arrearsList($voucher)->sum('balance'), 2);
    }

    /** Prepare the small, fixed breakdown printed on the three-copy voucher. */
    public function printData(FeeVoucher $voucher): array
    {
        $voucher->loadMissing(['student', 'schoolClass', 'section', 'items']);

        $arrears = $this->arrearsList($voucher);
        $today = FeeHelper::today();
        $arrears->each(function (FeeVoucher $older) use ($today) {
            $older->print_late_fee = $this->lateFeeExtra($older, $today);
            $older->print_balance = round((float) $older->balance + $older->print_late_fee, 2);
        });

        $olderBalance = round((float) $arrears->sum('balance'), 2);
        $olderLateFee = round((float) $arrears->sum('print_late_fee'), 2);
        $lateFeeExtra = $this->lateFeeExtra($voucher, $today);
        $breakdown = [
            'admission' => 0.0,
            'tuition' => 0.0,
            'exam' => 0.0,
            'arrears' => $olderBalance,
            'absent_fine' => 0.0,
            'late_fee' => round($olderLateFee + $lateFeeExtra, 2),
        ];

        foreach ($voucher->items as $item) {
            $title = strtolower($item->title);
            $source = $item->source;
            $amount = (float) $item->amount;

            if (in_array($source, ['opening'], true) || str_contains($title, 'arrears') || str_contains($title, 'previous dues')) {
                $category = 'arrears';
            } elseif ($source === 'absent_fine' || str_contains($title, 'absent fine')) {
                $category = 'absent_fine';
            } elseif (in_array($source, ['late_fee', 'late_fee_waiver'], true) || str_contains($title, 'late fee')) {
                $category = 'late_fee';
            } elseif (str_contains($title, 'admission') || $source === 'readmission') {
                $category = 'admission';
            } elseif (str_contains($title, 'exam')) {
                $category = 'exam';
            } elseif ($voucher->type === 'admission' || $voucher->type === 'readmission') {
                $category = 'admission';
            } elseif ($voucher->type === 'exam') {
                $category = 'exam';
            } elseif ($voucher->type === 'opening') {
                $category = 'arrears';
            } else {
                // Other manual charges remain visible in the tuition row instead of disappearing.
                $category = 'tuition';
            }

            $breakdown[$category] = round($breakdown[$category] + $amount, 2);
        }

        // This is a bill voucher: keep the original charges visible when a paid copy is reprinted.
        $payable = round((float) $voucher->total_amount + $olderBalance + $olderLateFee + $lateFeeExtra, 2);
        $breakdown['total'] = $payable;

        return [
            'voucher' => $voucher,
            'arrears' => $arrears,
            'arrearsTotal' => round($olderBalance + $olderLateFee, 2),
            'lateFee' => $lateFeeExtra,
            'lateFeeDate' => $today,
            'payable' => $payable,
            'breakdown' => $breakdown,
        ];
    }

    /* ------------------------------------------------------------------
     |  Late fee
     * ------------------------------------------------------------------ */

    /** What the late fee would be if the voucher were paid on $asOf. Changes nothing. */
    public function calculateLateFee(FeeVoucher $voucher, CarbonInterface $asOf): array
    {
        $rate = FeeSetting::number('late_fee_per_day');

        if (! FeeSetting::enabled('late_fee_enabled') || $rate <= 0) {
            return ['days' => 0, 'fee' => 0.0];
        }

        $days = max(0, FeeHelper::daysBetween($voucher->due_date->toDateString(), $asOf->toDateString()));

        return ['days' => $days, 'fee' => round($days * $rate, 2)];
    }

    /** How much MORE late fee would be added on $asOf (the late fee already on the voucher is not repeated). */
    public function lateFeeExtra(FeeVoucher $voucher, CarbonInterface $asOf): float
    {
        if (! in_array($voucher->status, ['unpaid', 'partial'], true)) {
            return 0.0;
        }

        $applied = (float) $voucher->items()->where('source', 'late_fee')->sum('amount');

        return round(max(0, $this->calculateLateFee($voucher, $asOf)['fee'] - $applied), 2);
    }

    /**
     * Add or update the voucher's late fee line without charging the same fine twice.
     *
     * @return float amount added by this call
     */
    public function applyLateFee(FeeVoucher $voucher, ?CarbonInterface $asOf = null): float
    {
        $asOf  ??= FeeHelper::today();
        $extra   = $this->lateFeeExtra($voucher, $asOf);

        if ($extra <= 0) {
            return 0.0;
        }

        $calc = $this->calculateLateFee($voucher, $asOf);
        $note = $calc['days'] . ' day(s) late as of ' . $asOf->format('d M Y');

        DB::transaction(function () use ($voucher, $calc, $note, $asOf) {
            $line = $voucher->items()->where('source', 'late_fee')->first();

            if ($line) {
                $line->update(['amount' => $calc['fee'], 'note' => $note]);
            } else {
                $voucher->items()->create([
                    'fee_head_id' => $this->headId('LATE_FEE'),
                    'title'       => 'Late fee',
                    'amount'      => $calc['fee'],
                    'source'      => 'late_fee',
                    'charged_on'  => $asOf->toDateString(),
                    'note'        => $note,
                    'created_by'  => auth('admin')->id(),
                ]);
            }

            $this->refreshTotals($voucher);

            FeeAuditLog::record('late_fee', 'Late fee on ' . $voucher->voucher_number . ' is now ' . FeeHelper::money($calc['fee']) . ' (' . $note . ').', $voucher->student_id, $voucher->id, null, $calc['fee']);
        });

        return $extra;
    }

    /** @throws DomainException */
    public function cancel(FeeVoucher $voucher, string $reason): void
    {
        if ($voucher->status === 'cancelled') {
            throw new DomainException('This voucher is already cancelled.');
        }

        if ($voucher->allocations()->exists()) {
            throw new DomainException('Payments are already applied to this voucher. Cancel those payments first.');
        }

        DB::transaction(function () use ($voucher, $reason) {
            $voucher->forceFill([
                'status'        => 'cancelled',
                'unique_key'    => null, // lets a corrected voucher be created for the same month
                'balance'       => 0,
                'cancel_reason' => $reason,
                'cancelled_at'  => now(),
                'cancelled_by'  => auth('admin')->id(),
            ])->save();

            FeeAuditLog::record('cancelled', 'Voucher ' . $voucher->voucher_number . ' cancelled. Reason: ' . $reason, $voucher->student_id, $voucher->id);
        });
    }


}
