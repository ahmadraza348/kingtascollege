<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolHoliday;
use App\Services\Admin\AttendanceService;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolHolidayController extends Controller
{
    public function __construct(private AttendanceService $service)
    {
    }

    public function index(): View
    {
        $holidays = SchoolHoliday::orderByDesc('date')->limit(300)->get();

        return view('backend.attendance.holidays', compact('holidays'));
    }

    /** Add one day or a range. Weekends inside the range are skipped. */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'from'  => ['required', 'date_format:Y-m-d'],
            'to'    => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);

        $from = CarbonImmutable::parse($data['from']);
        $to   = CarbonImmutable::parse($data['to'] ?? $data['from']);

        if ($from->addDays(60)->lt($to)) {
            toastr()->error('A holiday range can be at most 60 days.');

            return back()->withInput();
        }

        $months = [];
        $added  = 0;

        for ($d = $from; $d->lte($to); $d = $d->addDay()) {
            if (! $this->service->isWorkingWeekday($d)) {
                continue;
            }

            $holiday = SchoolHoliday::firstOrCreate(
                ['date' => $d->toDateString()],
                ['title' => $data['title'], 'created_by' => auth('admin')->id()]
            );

            if ($holiday->wasRecentlyCreated) {
                $added++;
                $months[] = $d->format('Y-m');
            }
        }

        // A new holiday must not count against students' percentages.
        $this->service->refreshMonths($months);

        $added > 0
            ? toastr()->success($added . ' holiday day(s) added.')
            : toastr()->info('Nothing added: those days are weekends or already holidays.');

        return redirect()->route('attendance.holidays');
    }

    public function destroy(SchoolHoliday $holiday): RedirectResponse
    {
        $month = substr($holiday->date, 0, 7);
        $holiday->delete();

        $this->service->refreshMonths([$month]);

        toastr()->success('Holiday removed.');

        return redirect()->route('attendance.holidays');
    }
}