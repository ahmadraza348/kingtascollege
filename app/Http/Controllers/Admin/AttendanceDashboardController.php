<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Services\Admin\AttendanceAnalyticsService;
use App\Services\Admin\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceDashboardController extends Controller
{
    public function index(Request $request, AttendanceService $attendance, AttendanceAnalyticsService $analytics): View
    {
        $classId   = $request->integer('class') ?: null;
        $sectionId = $request->integer('section') ?: null;

        [$from, $to] = $attendance->resolveRange($request->query('period'), $request->query('from'), $request->query('to'));

        $data = $analytics->dashboard($classId, $sectionId, $from, $to);

        return view('backend.attendance.dashboard', $data + [
            'classes'   => SchoolClass::orderBy('sort_order')->orderBy('name')->get(),
            'sections'  => $classId ? Section::where('school_class_id', $classId)->orderBy('name')->get() : collect(),
            'classId'   => $classId,
            'sectionId' => $sectionId,
            'from'      => $from,
            'to'        => $to,
        ]);
    }
}