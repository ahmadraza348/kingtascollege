<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Services\Admin\AttendanceService;
use Carbon\CarbonImmutable;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(private AttendanceService $service)
    {
    }

    /** The weekly grid. Choosing a class loads its first section and its students straight away. */
    public function index(Request $request): View
    {
        $classes = SchoolClass::active()
            ->with(['sections' => fn ($q) => $q->active()->orderBy('name')])
            ->orderBy('sort_order')->orderBy('name')->get();

        $date = $request->query('date');
        $date = $date && CarbonImmutable::canBeCreatedFromFormat($date, 'Y-m-d')
            ? CarbonImmutable::createFromFormat('Y-m-d', $date)
            : $this->service->today();

        $class   = $classes->firstWhere('id', $request->integer('class'));
        // Pre-select the first section when none (or one from another class) is given.
        $section = $class
            ? ($class->sections->firstWhere('id', $request->integer('section')) ?? $class->sections->first())
            : null;

        $week   = $section ? $this->service->weekData($section, $date) : null;
        $monday = $date->startOfWeek();

        $lastDay = max($this->service->workingWeekdays());
        $weekLabel = $monday->format('d M') . ' – ' . $monday->addDays($lastDay - 1)->format('d M Y');

        return view('backend.attendance.mark', [
            'classes'   => $classes,
            'class'     => $class,
            'section'   => $section,
            'week'      => $week,
            'date'      => $date->toDateString(),
            'prevWeek'  => $monday->subWeek()->toDateString(),
            'nextWeek'  => $monday->addWeek()->toDateString(),
            'thisWeek'  => $this->service->today()->toDateString(),
            'weekLabel' => $weekLabel,
            'tz'        => config('attendance.timezone'),
        ]);
    }

    /** Saves the ticked days. Past days can be edited at any time; changes are tracked. */
    public function save(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'section_id'  => ['required', 'exists:sections,id'],
            'week'        => ['required', 'date_format:Y-m-d'],
            'save_days'   => ['required', 'array', 'min:1'],
            'save_days.*' => ['date_format:Y-m-d'],
            'status'      => ['nullable', 'array'],
            'status.*.*'  => [Rule::in(array_keys(AttendanceLog::STATUSES))],
        ], [
            'save_days.required' => 'Tick at least one day to save.',
            'save_days.min'      => 'Tick at least one day to save.',
        ]);

        $section = Section::findOrFail($data['section_id']);

        $days = [];
        foreach ($data['save_days'] as $date) {
            $days[$date] = $data['status'][$date] ?? [];
        }

        try {
            $result = $this->service->save($section, $days, auth('admin')->id());
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        if ($result['changed'] === 0) {
            toastr()->info('Nothing changed. Attendance already matched what you submitted.');
        } else {
            toastr()->success('Attendance saved: ' . $result['changed'] . ' record(s) updated across ' . $result['days'] . ' day(s).');
        }

        return redirect()->route('attendance.mark', [
            'class'   => $section->school_class_id,
            'section' => $section->id,
            'date'    => $data['week'],
        ]);
    }
}