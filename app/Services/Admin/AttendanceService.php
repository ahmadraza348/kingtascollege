<?php

namespace App\Services\Admin;

use App\Models\AttendanceLog;
use App\Models\AttendanceSession;
use App\Models\AttendanceSummary;
use App\Models\SchoolHoliday;
use App\Models\Section;
use App\Models\Student;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use DomainException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /** Count of each status, for any grouped query on attendance_logs. */
    public const COUNT_SQL = "SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) AS present, "
        . "SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) AS absent, "
        . "SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) AS late, "
        . "SUM(CASE WHEN status = 'excused' THEN 1 ELSE 0 END) AS excused, "
        . "SUM(CASE WHEN status = 'half_day' THEN 1 ELSE 0 END) AS half_day";

    /* ------------------------------------------------------------------
     |  Calendar rules
     * ------------------------------------------------------------------ */

    public function today(): CarbonImmutable
    {
        return CarbonImmutable::now(config('attendance.timezone', 'UTC'))->startOfDay();
    }

    /** @return int[] ISO weekdays (1 = Monday) that are school days, sorted. */
    public function workingWeekdays(): array
    {
        $days = array_map('intval', config('attendance.working_days', [1, 2, 3, 4, 5, 6]));
        sort($days);

        return $days;
    }

    public function isWorkingWeekday(CarbonInterface $date): bool
    {
        return in_array($date->dayOfWeekIso, $this->workingWeekdays(), true);
    }

    /** @return array<string,string> date => holiday title */
    public function holidays(string $from, string $to): array
    {
        return SchoolHoliday::whereBetween('date', [$from, $to])->pluck('title', 'date')->all();
    }

    /** Why this day cannot be marked, or null when it can. */
    public function blockedReason(CarbonInterface $date, array $holidays): ?string
    {
        if (! $this->isWorkingWeekday($date)) {
            return 'Weekend';
        }

        if (isset($holidays[$date->toDateString()])) {
            return $holidays[$date->toDateString()];
        }

        if ($date->toDateString() > $this->today()->toDateString()) {
            return 'Upcoming';
        }

        return null;
    }

    /* ------------------------------------------------------------------
     |  The one place that defines "attendance %"
     * ------------------------------------------------------------------ */

    public static function emptyCounts(): array
    {
        return ['present' => 0, 'absent' => 0, 'late' => 0, 'excused' => 0, 'half_day' => 0];
    }

    /**
     * Present and Late count as 1, Half Day as 0.5, Absent as 0.
     * Excused days are left out of the maths. Returns null when nothing counts yet.
     */
    public function percent(array $c): ?float
    {
        $base = $c['present'] + $c['absent'] + $c['late'] + $c['half_day'];

        if ($base === 0) {
            return null;
        }

        return round((($c['present'] + $c['late'] + 0.5 * $c['half_day']) / $base) * 100, 2);
    }

    /** @return array{0:string,1:string} */
    public function presetRange(?string $preset): array
    {
        $today  = $this->today();
        $monday = $today->startOfWeek(CarbonInterface::MONDAY);

        [$from, $to] = match ($preset) {
            'this_week'  => [$monday, $monday->addDays(6)],
            'last_week'  => [$monday->subWeek(), $monday->subWeek()->addDays(6)],
            'last_month' => [$today->subMonthNoOverflow()->startOfMonth(), $today->subMonthNoOverflow()->endOfMonth()],
            default      => [$today->startOfMonth(), $today],
        };

        return [$from->toDateString(), $to->toDateString()];
    }

    /** Custom from/to win over the preset. Ranges are capped at 93 days. */
    public function resolveRange(?string $preset, ?string $from, ?string $to): array
    {
        if ($from && $to
            && CarbonImmutable::canBeCreatedFromFormat($from, 'Y-m-d')
            && CarbonImmutable::canBeCreatedFromFormat($to, 'Y-m-d')) {
            $f = CarbonImmutable::createFromFormat('Y-m-d', $from)->startOfDay();
            $t = CarbonImmutable::createFromFormat('Y-m-d', $to)->startOfDay();

            if ($f->gt($t)) {
                [$f, $t] = [$t, $f];
            }
            if ($f->lt($t->subDays(92))) {
                $f = $t->subDays(92);
            }

            return [$f->toDateString(), $t->toDateString()];
        }

        return $this->presetRange($preset);
    }

    /* ------------------------------------------------------------------
     |  Weekly grid data
     * ------------------------------------------------------------------ */

    public function weekData(Section $section, CarbonInterface $anyDate): array
    {
        $monday   = CarbonImmutable::parse($anyDate)->startOfWeek(CarbonInterface::MONDAY);
        $holidays = $this->holidays($monday->toDateString(), $monday->addDays(6)->toDateString());

        $days = [];
        foreach ($this->workingWeekdays() as $iso) {
            $d      = $monday->addDays($iso - 1);
            $reason = $this->blockedReason($d, $holidays);

            $days[] = [
                'date'     => $d->toDateString(),
                'dow'      => $d->format('D'),
                'day'      => $d->format('d M'),
                'editable' => $reason === null,
                'reason'   => $reason,
                'today'    => $d->toDateString() === $this->today()->toDateString(),
            ];
        }

        $dates    = array_column($days, 'date');
        $students = $this->studentsFor($section, $dates);

        $logs = [];
        AttendanceLog::whereIn('student_id', $students->pluck('id'))->whereIn('date', $dates)
            ->get(['student_id', 'date', 'status'])
            ->each(function ($log) use (&$logs) {
                $logs[$log->student_id][$log->date] = $log->status;
            });

        $sessions = AttendanceSession::with('updater:id,first_name,last_name')
            ->where('section_id', $section->id)->whereIn('date', $dates)->get()->keyBy('date');

        return compact('monday', 'days', 'students', 'logs', 'sessions');
    }

    /** Active students of the section, plus anyone who already has attendance there in these dates. */
    private function studentsFor(Section $section, array $dates): Collection
    {
        $loggedIds = AttendanceLog::where('section_id', $section->id)->whereIn('date', $dates)->pluck('student_id');

        return Student::withTrashed()
            ->where(function ($q) use ($section, $loggedIds) {
                $q->where(fn ($a) => $a->where('section_id', $section->id)->where('status', 'active')->whereNull('deleted_at'))
                  ->orWhereIn('id', $loggedIds);
            })
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'roll_number', 'status', 'photo_path', 'section_id', 'deleted_at']);
    }

    /* ------------------------------------------------------------------
     |  Saving (batch, change-aware)
     * ------------------------------------------------------------------ */

    /**
     * @param  array<string, array<int,string>>  $days  date => [studentId => status]
     * @return array{days:int, changed:int, unchanged:int}
     *
     * @throws DomainException
     */
    public function save(Section $section, array $days, ?int $adminId): array
    {
        if ($days === []) {
            throw new DomainException('Tick at least one day to save.');
        }

        $dates = array_keys($days);
        sort($dates);

        $holidays = $this->holidays($dates[0], end($dates));
        foreach ($dates as $date) {
            $day = CarbonImmutable::parse($date);

            if ($reason = $this->blockedReason($day, $holidays)) {
                throw new DomainException($day->format('D d M') . ' cannot be marked (' . $reason . ').');
            }
        }

        $studentIds = $this->studentsFor($section, $dates)->pluck('id')->all();

        $existing = [];
        AttendanceLog::whereIn('student_id', $studentIds)->whereIn('date', $dates)
            ->get(['student_id', 'date', 'status'])
            ->each(function ($log) use (&$existing) {
                $existing[$log->date . '|' . $log->student_id] = $log->status;
            });

        $sessions = AttendanceSession::where('section_id', $section->id)->whereIn('date', $dates)->pluck('date')->flip();

        $now = now();
        $logRows = $sessionRows = $months = [];
        $unchanged = 0;

        foreach ($days as $date => $statuses) {
            $dayChanged = false;

            foreach ($studentIds as $id) {
                $status = $statuses[$id] ?? 'present'; // the default
                if (! isset(AttendanceLog::STATUSES[$status])) {
                    $status = 'present';
                }

                // Only rows that really changed are written, so "updated by" stays truthful.
                if (($existing[$date . '|' . $id] ?? null) === $status) {
                    $unchanged++;
                    continue;
                }

                $logRows[] = [
                    'student_id'      => $id,
                    'school_class_id' => $section->school_class_id,
                    'section_id'      => $section->id,
                    'date'            => $date,
                    'status'          => $status,
                    'marked_by'       => $adminId,
                    'updated_by'      => $adminId,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
                $dayChanged = true;
            }

            if ($dayChanged || ! $sessions->has($date)) {
                $sessionRows[] = [
                    'school_class_id' => $section->school_class_id,
                    'section_id'      => $section->id,
                    'date'            => $date,
                    'marked_by'       => $adminId,
                    'updated_by'      => $adminId,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            if ($dayChanged) {
                $months[substr($date, 0, 7)] = true;
            }
        }

        DB::transaction(function () use ($logRows, $sessionRows, $months, $studentIds) {
            // On a duplicate (student, date) only these columns change; marked_by stays the original marker.
            foreach (array_chunk($logRows, 500) as $chunk) {
                AttendanceLog::upsert($chunk, ['student_id', 'date'], ['school_class_id', 'section_id', 'status', 'updated_by', 'updated_at']);
            }

            if ($sessionRows) {
                AttendanceSession::upsert($sessionRows, ['section_id', 'date'], ['school_class_id', 'updated_by', 'updated_at']);
            }

            foreach (array_keys($months) as $ym) {
                $this->refreshMonth($ym, $studentIds);
            }
        });

        return ['days' => count($days), 'changed' => count($logRows), 'unchanged' => $unchanged];
    }

    /* ------------------------------------------------------------------
     |  Monthly summaries
     * ------------------------------------------------------------------ */

    /** Recalculate one month ("2026-10") for the given students (null = everyone). Holidays are excluded. */
    public function refreshMonth(string $ym, ?array $studentIds = null): void
    {
        [$year, $month] = array_map('intval', explode('-', $ym));

        $from = sprintf('%04d-%02d-01', $year, $month);
        $to   = CarbonImmutable::create($year, $month, 1)->endOfMonth()->toDateString();

        $holidayDates = array_keys($this->holidays($from, $to));

        $groups = AttendanceLog::query()
            ->whereBetween('date', [$from, $to])
            ->when($holidayDates, fn ($q) => $q->whereNotIn('date', $holidayDates))
            ->when($studentIds !== null, fn ($q) => $q->whereIn('student_id', $studentIds))
            ->selectRaw('student_id, section_id, school_class_id, ' . self::COUNT_SQL)
            ->groupBy('student_id', 'section_id', 'school_class_id')
            ->get();

        $now  = now();
        $rows = $groups->map(function ($g) use ($year, $month, $now) {
            $c = [
                'present'  => (int) $g->present,
                'absent'   => (int) $g->absent,
                'late'     => (int) $g->late,
                'excused'  => (int) $g->excused,
                'half_day' => (int) $g->half_day,
            ];

            return [
                'student_id'      => $g->student_id,
                'school_class_id' => $g->school_class_id,
                'section_id'      => $g->section_id,
                'year'            => $year,
                'month'           => $month,
                'marked'          => array_sum($c),
                'percentage'      => $this->percent($c),
                'created_at'      => $now,
                'updated_at'      => $now,
            ] + $c;
        })->all();

        DB::transaction(function () use ($year, $month, $studentIds, $rows) {
            AttendanceSummary::where('year', $year)->where('month', $month)
                ->when($studentIds !== null, fn ($q) => $q->whereIn('student_id', $studentIds))
                ->delete();

            foreach (array_chunk($rows, 500) as $chunk) {
                AttendanceSummary::insert($chunk);
            }
        });
    }

    public function refreshMonths(array $yms): void
    {
        foreach (array_unique($yms) as $ym) {
            $this->refreshMonth($ym);
        }
    }

    /** Rebuild every month from the logs (php artisan attendance:rebuild). */
    public function rebuildAll(): int
    {
        $months = AttendanceLog::query()->selectRaw('SUBSTR(date, 1, 7) AS ym')->distinct()->pluck('ym');

        foreach ($months as $ym) {
            $this->refreshMonth($ym);
        }

        return $months->count();
    }
}