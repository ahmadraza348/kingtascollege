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
        // "other" charges can repeat; every other type is allowed once per student and month.
        $uniqueKey = $type === 'other' ? null : $type . ':' . $period;

        try {
            return DB::transaction(function () use ($student, $data, $type, $period, $uniqueKey) {
                // Serialize voucher creation per student; this also protects the finalized-fee limit.
                $lockedStudent = Student::whereKey($student->id)->lockForUpdate()->firstOrFail();

                if ($uniqueKey && FeeVoucher::where('student_id', $lockedStudent->id)->where('unique_key', $uniqueKey)->exists()) {
                    $existing = FeeVoucher::where('student_id', $lockedStudent->id)->where('unique_key', $uniqueKey)->first();
                    throw new DomainException($lockedStudent->full_name . ' already has a ' . FeeVoucher::TYPES[$type] . ' voucher for ' . FeeHelper::periodLabel($period) . ' (' . $existing?->voucher_number . ').');
                }

                $finalizedFee = $lockedStudent->finalized_fee;
                if ($finalizedFee === null || (float) $finalizedFee <= 0) {
                    throw new DomainException('Set this student’s finalized total fee in the Student record before creating a voucher.');
                }

                // Build lines after acquiring the student lock so fines and duplicate checks are evaluated
                // against the same transaction that creates the voucher.
                $lines = $this->buildLines($lockedStudent, $type, $period, $data);
                $total = round(array_sum(array_column($lines, 'amount')), 2);
                if ($total <= 0) {
                    throw new DomainException('The voucher total is zero, so nothing was created.');
                }

                // Fines are additional charges. They must not consume the student's agreed/finalized course fee.
                $fineSources = ['late_fee', 'late_fee_waiver', 'absent_fine'];
                $alreadyBilled = (float) FeeVoucherItem::whereHas('voucher', fn ($q) => $q
                    ->where('student_id', $lockedStudent->id)
                    ->where('status', '!=', 'cancelled'))
                    ->whereNotIn('source', $fineSources)
                    ->sum('amount');
                $newBilled = round(array_sum(array_map(
                    fn (array $line) => in_array($line['source'], $fineSources, true) ? 0 : (float) $line['amount'],
                    $lines
                )), 2);
                $remainingToBill = max(0, round((float) $finalizedFee - $alreadyBilled, 2));

                if ($newBilled > $remainingToBill + 0.001) {
                    throw new DomainException('This voucher is higher than the remaining unbilled fee (' . FeeHelper::money($remainingToBill) . '). Update the student’s finalized fee if the agreed total has changed.');
                }

                $voucher = FeeVoucher::create([
                    'student_id'      => $lockedStudent->id,
                    'school_class_id' => $lockedStudent->school_class_id,
                    'section_id'      => $lockedStudent->section_id,
                    'roll_number'     => $lockedStudent->roll_number,
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
                        'fee_head_id'          => $line['head_id'] ?? null,
                        'origin_fee_voucher_id'=> $line['origin_fee_voucher_id'] ?? null,
                        'title'                => $line['title'],
                        'amount'               => $line['amount'],
                        'source'               => $line['source'],
                        'charged_on'           => $data['issue_date'],
                        'note'                 => $line['note'] ?? null,
                        'created_by'           => auth('admin')->id(),
                    ]);
                }

                // Number built from the id, so it is unique without any counter logic: FV-2610-00042
                $voucher->voucher_number = sprintf('FV-%s%s-%05d', substr($period, 2, 2), substr($period, 5, 2), $voucher->id);
                $this->refreshTotals($voucher);

                FeeAuditLog::record('created', 'Voucher ' . $voucher->voucher_number . ' created for ' . FeeHelper::periodLabel($period) . '.', $lockedStudent->id, $voucher->id, null, (float) $voucher->total_amount);

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
        if ($amount < 0 || ($type !== 'monthly' && $amount <= 0)) {
            throw new DomainException('Enter an amount greater than zero for this voucher type. A monthly voucher may use zero base amount when it only carries assessed fines.');
        }

        $description = trim((string) ($data['description'] ?? ''));
        $title = $description !== ''
            ? $description
            : (FeeVoucher::TYPES[$type] ?? 'Fee') . ' - ' . FeeHelper::periodLabel($period);

        $lines = [];
        if ($amount > 0) {
            $lines[] = [
                'head_id' => $type === 'opening' ? $this->headId('PREVIOUS_DUES') : null,
                'title'   => $title,
                'amount'  => $amount,
                'source'  => $type === 'opening' ? 'opening' : 'manual',
            ];
        }

        // Fines are assessed on the next monthly voucher. Absence fines use attendance from the
        // previous full calendar month, not the voucher issue month or today's month.
        if ($type !== 'monthly') {
            return $lines;
        }

        $issueDate = CarbonImmutable::parse($data['issue_date'])->startOfDay();
        $periodStart = CarbonImmutable::createFromFormat('!Y-m-d', $period . '-01');
        $previousMonth = $periodStart->subMonthNoOverflow();
        $previousStart = $previousMonth->startOfMonth()->toDateString();
        $previousEnd = $previousMonth->endOfMonth()->toDateString();
        $absentDays = (int) \App\Models\AttendanceLog::query()
            ->where('student_id', $student->id)
            ->where('status', 'absent')
            ->whereBetween('date', [$previousStart, $previousEnd])
            ->count();
        $absentRate = max(0, FeeSetting::number('absent_fine_per_day'));
        $absentFine = round($absentDays * $absentRate, 2);

        if ($absentDays > 0 && $absentFine > 0) {
            $lines[] = [
                'head_id' => $this->headId('ABSENT_FINE'),
                'title'   => 'Absent fine - ' . $previousMonth->format('F Y'),
                'amount'  => $absentFine,
                'source'  => 'absent_fine',
                'note'    => $absentDays . ' absent day(s) recorded during ' . $previousMonth->format('F Y') . ' at Rs. ' . FeeHelper::number($absentRate) . ' per day.',
            ];
        }

        // Attach any still-unbilled late fine to this monthly voucher. The origin id records which
        // overdue voucher caused it, so later monthly vouchers only charge the newly accrued amount.
        $olderVouchers = FeeVoucher::query()
            ->where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->where('period', '<=', $period)
            ->whereDate('due_date', '<', $issueDate->toDateString())
            ->orderBy('period')
            ->orderBy('id')
            ->get();

        foreach ($olderVouchers as $olderVoucher) {
            $extra = $this->lateFeeExtra($olderVoucher, $issueDate);
            if ($extra <= 0) {
                continue;
            }

            $lines[] = [
                'head_id' => $this->headId('LATE_FEE'),
                'origin_fee_voucher_id' => $olderVoucher->id,
                'title'   => 'Late fine - ' . $olderVoucher->voucher_number,
                'amount'  => $extra,
                'source'  => 'late_fee',
                'note'    => 'Late fine for ' . $olderVoucher->voucher_number . ', accrued through ' . $issueDate->format('d M Y') . '.',
            ];
        }

        return $lines;
    }

    private function headId(string $code): ?int
    {
        $this->headIds ??= FeeHead::pluck('id', 'code')->all();

        return isset($this->headIds[$code]) ? (int) $this->headIds[$code] : null;
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
        $balance = max(0, round($total - $paid, 2));

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
        $olderBalance = round((float) $arrears->sum('balance'), 2);
        $breakdown = [
            'admission' => 0.0,
            'tuition' => 0.0,
            'exam' => 0.0,
            'arrears' => $olderBalance,
            'absent_fine' => 0.0,
            'late_fee' => 0.0,
        ];

        foreach ($voucher->items as $item) {
            $title = strtolower($item->title);
            $source = $item->source;
            $amount = (float) $item->amount;

            if (in_array($source, ['opening'], true) || str_contains($title, 'arrears') || str_contains($title, 'previous dues')) {
                $category = 'arrears';
            } elseif ($source === 'absent_fine' || str_contains($title, 'absent fine')) {
                $category = 'absent_fine';
            } elseif (in_array($source, ['late_fee', 'late_fee_waiver'], true) || str_contains($title, 'late fine') || str_contains($title, 'late fee')) {
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

        // Only issued amounts are printed as payable. A fine that is still accruing is deliberately
        // shown in the admin screen as pending for the next monthly voucher, never as a duplicate due.
        $payable = round((float) $voucher->total_amount + $olderBalance, 2);
        $breakdown['total'] = $payable;

        return [
            'voucher' => $voucher,
            'arrears' => $arrears,
            'arrearsTotal' => $olderBalance,
            'lateFee' => 0.0,
            'lateFeeDate' => FeeHelper::today(),
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

    /**
     * Late fine accrued by $asOf but not yet billed on an active voucher.
     * The fine is charged as a line on a later monthly voucher, linked by origin_fee_voucher_id.
     */
    public function lateFeeExtra(FeeVoucher $voucher, CarbonInterface $asOf): float
    {
        if (! in_array($voucher->status, ['unpaid', 'partial'], true)) {
            return 0.0;
        }

        // A late_fee item with origin_fee_voucher_id belongs to an older voucher; do not
        // confuse that transferred charge with fine already assessed on this voucher itself.
        $directlyCharged = (float) $voucher->items()
            ->whereNull('origin_fee_voucher_id')
            ->whereIn('source', ['late_fee', 'late_fee_waiver'])
            ->sum('amount');

        $chargedOnLaterVouchers = (float) FeeVoucherItem::query()
            ->where('origin_fee_voucher_id', $voucher->id)
            ->whereIn('source', ['late_fee', 'late_fee_waiver'])
            ->whereHas('voucher', fn ($query) => $query->where('status', '!=', 'cancelled'))
            ->sum('amount');

        $alreadyCharged = round($directlyCharged + $chargedOnLaterVouchers, 2);

        return round(max(0, $this->calculateLateFee($voucher, $asOf)['fee'] - $alreadyCharged), 2);
    }

    /**
     * Kept for compatibility with older callers. Late fines must not be added to the overdue voucher;
     * the next monthly voucher records them with an origin_fee_voucher_id instead.
     */
    public function applyLateFee(FeeVoucher $voucher, ?CarbonInterface $asOf = null): float
    {
        return $this->lateFeeExtra($voucher, $asOf ?? FeeHelper::today());
    }

    /** @throws DomainException */
    public function cancel(FeeVoucher $voucher, string $reason): void
    {
        DB::transaction(function () use ($voucher, $reason) {
            // Serialize cancellation against voucher creation and payment allocation for this student.
            Student::whereKey($voucher->student_id)->lockForUpdate()->firstOrFail();
            $lockedVoucher = FeeVoucher::whereKey($voucher->id)->lockForUpdate()->firstOrFail();

            if ($lockedVoucher->status === 'cancelled') {
                throw new DomainException('This voucher is already cancelled.');
            }

            if ($lockedVoucher->allocations()->exists()) {
                throw new DomainException('Payments are already applied to this voucher. Cancel those payments first.');
            }

            $hasActiveTransferredFine = FeeVoucherItem::query()
                ->where('origin_fee_voucher_id', $lockedVoucher->id)
                ->where('source', 'late_fee')
                ->whereHas('voucher', fn ($query) => $query->where('status', '!=', 'cancelled'))
                ->exists();

            if ($hasActiveTransferredFine) {
                throw new DomainException('A late fine for this voucher is included in an active monthly voucher. Cancel that monthly voucher first, then cancel this voucher.');
            }

            $lockedVoucher->forceFill([
                'status'        => 'cancelled',
                'unique_key'    => null, // lets a corrected voucher be created for the same month
                'balance'       => 0,
                'cancel_reason' => $reason,
                'cancelled_at'  => now(),
                'cancelled_by'  => auth('admin')->id(),
            ])->save();

            FeeAuditLog::record('cancelled', 'Voucher ' . $lockedVoucher->voucher_number . ' cancelled. Reason: ' . $reason, $lockedVoucher->student_id, $lockedVoucher->id);
        });
    }


}
