<?php

namespace App\Services\Admin;

use App\Models\AttendanceLog;
use App\Models\AttendanceSession;
use App\Models\AttendanceSummary;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class AttendanceAnalyticsService
{
    public function __construct(private AttendanceService $attendance)
    {
    }

    /* ------------------------------------------------------------------
     |  Dashboard
     * ------------------------------------------------------------------ */

    public function dashboard(?int $classId, ?int $sectionId, string $from, string $to): array
    {
        $threshold = (int) config('attendance.threshold', 75);
        $minDays   = (int) config('attendance.alert_min_days', 3);
        $today     = $this->attendance->today();
        $monday    = $today->startOfWeek(CarbonInterface::MONDAY);
        $sunday    = $monday->addDays(6);

        $holidays     = $this->attendance->holidays(min($from, $monday->toDateString()), max($to, $sunday->toDateString()));
        $holidayDates = array_keys($holidays);

        // Logs of a date range, narrowed to the chosen class/section and without holidays.
        $logs = fn (string $a, string $b) => AttendanceLog::query()
            ->whereBetween('date', [$a, $b])
            ->when($classId, fn ($q) => $q->where('school_class_id', $classId))
            ->when($sectionId, fn ($q) => $q->where('section_id', $sectionId))
            ->when($holidayDates, fn ($q) => $q->whereNotIn('date', $holidayDates));

        // ---- Today
        $todayKey    = $today->toDateString();
        $todayCounts = $this->counts($logs($todayKey, $todayKey));
        $todayOff    = $this->attendance->blockedReason($today, $holidays);

        $sectionIds = Section::active()
            ->when($classId, fn ($q) => $q->where('school_class_id', $classId))
            ->when($sectionId, fn ($q) => $q->where('id', $sectionId))
            ->pluck('id');

        $sectionsTaken = AttendanceSession::where('date', $todayKey)->whereIn('section_id', $sectionIds)->count();

        // ---- Selected period: totals + per-student percentages (one query)
        $perStudent = $logs($from, $to)
            ->selectRaw('student_id, ' . AttendanceService::COUNT_SQL)
            ->groupBy('student_id')->get();

        $periodTotals = AttendanceService::emptyCounts();
        $below        = [];

        foreach ($perStudent as $row) {
            $c = [
                'present'  => (int) $row->present,
                'absent'   => (int) $row->absent,
                'late'     => (int) $row->late,
                'excused'  => (int) $row->excused,
                'half_day' => (int) $row->half_day,
            ];

            foreach ($c as $key => $value) {
                $periodTotals[$key] += $value;
            }

            $marked  = array_sum($c);
            $percent = $this->attendance->percent($c);

            if ($percent !== null && $marked >= $minDays && $percent < $threshold) {
                $below[$row->student_id] = ['counts' => $c, 'marked' => $marked, 'percent' => $percent];
            }
        }

        $watchlist = collect();
        if ($below) {
            $watchlist = Student::active()
                ->with(['schoolClass:id,name', 'section:id,name'])
                ->whereIn('id', array_keys($below))->get()
                ->map(fn ($s) => ['student' => $s] + $below[$s->id])
                ->sortBy([['percent', 'asc'], ['counts.absent', 'desc']])
                ->values();
        }

        return [
            'threshold'     => $threshold,
            'todayCounts'   => $todayCounts,
            'todayRate'     => $this->attendance->percent($todayCounts),
            'todayOff'      => $todayOff,
            'sectionsTaken' => $sectionsTaken,
            'sectionsTotal' => $sectionIds->count(),
            'period'        => $periodTotals,
            'periodRate'    => $this->attendance->percent($periodTotals),
            'alerts'        => $watchlist->count(),
            'watchlist'     => $watchlist->take(10),
            'weekly'        => $this->weeklyTrend($logs, $monday, $sunday),
            'monthly'       => $this->monthlyComparison($classId, $sectionId, $today),
        ];
    }

    /** Day-by-day rate for the current week. A day with nothing taken (or a holiday) is a gap. */
    private function weeklyTrend(\Closure $logs, CarbonImmutable $monday, CarbonImmutable $sunday): array
    {
        $rows = $logs($monday->toDateString(), $sunday->toDateString())
            ->selectRaw('date, status, COUNT(*) AS total')
            ->groupBy('date', 'status')->get()->groupBy('date');

        $labels = $rates = [];

        foreach ($this->attendance->workingWeekdays() as $iso) {
            $day = $monday->addDays($iso - 1);
            $c   = AttendanceService::emptyCounts();

            foreach ($rows->get($day->toDateString(), collect()) as $r) {
                if (isset($c[$r->status])) {
                    $c[$r->status] = (int) $r->total;
                }
            }

            $labels[] = $day->format('D d');
            $rates[]  = array_sum($c) > 0 ? $this->attendance->percent($c) : null;
        }

        return ['labels' => $labels, 'rates' => $rates];
    }

    /** Last 6 months from the summary table: one series per class (or per section when a class is chosen). */
    private function monthlyComparison(?int $classId, ?int $sectionId, CarbonImmutable $today): array
    {
        $start = $today->startOfMonth()->subMonths(5);
        $key   = fn (CarbonInterface $d) => $d->year * 100 + $d->month;

        $bySection = (bool) ($classId || $sectionId);
        $column    = $bySection ? 'section_id' : 'school_class_id';

        $rows = AttendanceSummary::query()
            ->whereRaw('(year * 100 + month) >= ?', [$key($start)])
            ->when($classId, fn ($q) => $q->where('school_class_id', $classId))
            ->when($sectionId, fn ($q) => $q->where('section_id', $sectionId))
            ->selectRaw("year, month, {$column} AS grp, SUM(present) AS present, SUM(absent) AS absent, SUM(late) AS late, SUM(excused) AS excused, SUM(half_day) AS half_day")
            ->groupBy('year', 'month', $column)->get();

        $labels = $keys = [];
        for ($i = 0; $i < 6; $i++) {
            $m        = $start->addMonths($i);
            $labels[] = $m->format('M Y');
            $keys[]   = $key($m);
        }

        $grouped = $rows->groupBy('grp');

        $names = $bySection
            ? Section::with('schoolClass:id,name')->whereIn('id', $grouped->keys())->get()
                ->mapWithKeys(fn ($s) => [$s->id => $s->schoolClass->name . ' / ' . $s->name])
            : SchoolClass::whereIn('id', $grouped->keys())->pluck('name', 'id');

        $series = [];
        foreach ($grouped as $group => $items) {
            $byMonth = $items->keyBy(fn ($r) => $r->year * 100 + $r->month);

            $series[] = [
                'name' => $names[$group] ?? ('#' . $group),
                'data' => array_map(function ($k) use ($byMonth) {
                    $r = $byMonth->get($k);

                    return $r ? $this->attendance->percent([
                        'present'  => (int) $r->present,
                        'absent'   => (int) $r->absent,
                        'late'     => (int) $r->late,
                        'excused'  => (int) $r->excused,
                        'half_day' => (int) $r->half_day,
                    ]) : null;
                }, $keys),
            ];
        }

        return ['labels' => $labels, 'series' => $series];
    }

    /** @return array<string,int> */
    private function counts($query): array
    {
        return array_merge(
            AttendanceService::emptyCounts(),
            array_map('intval', $query->selectRaw('status, COUNT(*) AS total')->groupBy('status')->pluck('total', 'status')->all())
        );
    }

    /* ------------------------------------------------------------------
     |  Reports
     * ------------------------------------------------------------------ */

    /**
     * @param  array{from:string,to:string,class_id:?int,section_id:?int,status:?string}  $f
     */
    public function report(array $f): array
    {
        $threshold = (int) config('attendance.threshold', 75);
        $minDays   = (int) config('attendance.alert_min_days', 3);
        $classId   = $f['class_id'];
        $sectionId = $f['section_id'];

        $holidays = $this->attendance->holidays($f['from'], $f['to']);

        // Columns = school days only (weekends and holidays are left out).
        $dates = [];
        for ($d = CarbonImmutable::parse($f['from']); $d->lte($f['to']); $d = $d->addDay()) {
            if (! $this->attendance->isWorkingWeekday($d) || isset($holidays[$d->toDateString()])) {
                continue;
            }
            $dates[] = ['date' => $d->toDateString(), 'day' => $d->format('d'), 'dow' => $d->format('D')];
        }
        $dateSet = array_flip(array_column($dates, 'date'));

        $logScope = fn () => AttendanceLog::query()
            ->whereBetween('date', [$f['from'], $f['to']])
            ->when($classId, fn ($q) => $q->where('school_class_id', $classId))
            ->when($sectionId, fn ($q) => $q->where('section_id', $sectionId));

        // Current members of the selection + anyone who has attendance in it during this range.
        $loggedIds = $logScope()->distinct()->pluck('student_id');

        $students = Student::withTrashed()
            ->with(['schoolClass:id,name', 'section:id,name'])
            ->where(function ($q) use ($loggedIds, $classId, $sectionId) {
                $q->whereIn('id', $loggedIds)
                  ->orWhere(fn ($c) => $c->whereNull('deleted_at')
                      ->when($classId, fn ($x) => $x->where('school_class_id', $classId))
                      ->when($sectionId, fn ($x) => $x->where('section_id', $sectionId)));
            })
            ->when($f['status'], fn ($q) => $q->where('status', $f['status']))
            ->orderBy('school_class_id')->orderBy('section_id')->orderBy('full_name')
            ->get();

        $cells = [];
        $logScope()->whereIn('student_id', $students->pluck('id'))->get(['student_id', 'date', 'status'])
            ->each(function ($log) use (&$cells, $dateSet) {
                if (isset($dateSet[$log->date])) {
                    $cells[$log->student_id][$log->date] = $log->status;
                }
            });

        $rows   = [];
        $totals = AttendanceService::emptyCounts();

        foreach ($students as $student) {
            $studentCells = $cells[$student->id] ?? [];
            $c            = AttendanceService::emptyCounts();

            foreach ($studentCells as $status) {
                if (isset($c[$status])) {
                    $c[$status]++;
                }
            }

            $marked  = array_sum($c);
            $percent = $this->attendance->percent($c);

            $rows[] = [
                'student' => $student,
                'cells'   => $studentCells,
                'counts'  => $c,
                'marked'  => $marked,
                'percent' => $percent,
                'low'     => $percent !== null && $marked >= $minDays && $percent < $threshold,
            ];

            foreach ($c as $key => $value) {
                $totals[$key] += $value;
            }
        }

        return [
            'from'      => $f['from'],
            'to'        => $f['to'],
            'dates'     => $dates,
            'holidays'  => $holidays,
            'rows'      => $rows,
            'totals'    => $totals,
            'percent'   => $this->attendance->percent($totals),
            'threshold' => $threshold,
            'show_grid' => count($dates) <= 31,
        ];
    }
}