<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AttendanceReportExport;
use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Services\Admin\AttendanceAnalyticsService;
use App\Services\Admin\AttendanceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceReportController extends Controller
{
    public function __construct(
        private AttendanceService $attendance,
        private AttendanceAnalyticsService $analytics,
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $this->filters($request);
        $report  = $this->analytics->report($filters);

        return view('backend.attendance.report', [
            'report'    => $report,
            'filters'   => $filters,
            'classes'   => SchoolClass::orderBy('sort_order')->orderBy('name')->get(),
            'sections'  => $filters['class_id'] ? Section::where('school_class_id', $filters['class_id'])->orderBy('name')->get() : collect(),
            'query'     => $this->query($filters),
        ]);
    }

    public function pdf(Request $request)
    {
        $filters = $this->filters($request);
        $report  = $this->analytics->report($filters);

        $pdf = Pdf::loadView('backend.attendance.report_pdf', [
            'report'       => $report,
            'classLabel'   => $filters['class_id'] ? SchoolClass::find($filters['class_id'])?->name : 'All classes',
            'sectionLabel' => $filters['section_id'] ? Section::find($filters['section_id'])?->name : 'All sections',
            'statusLabel'  => $filters['status'] ? Student::STATUSES[$filters['status']] : 'All students',
        ])->setPaper('a4', 'landscape');

        return $pdf->download("attendance-{$filters['from']}-to-{$filters['to']}.pdf");
    }

    public function export(Request $request, string $format)
    {
        $filters = $this->filters($request);
        $report  = $this->analytics->report($filters);

        return Excel::download(new AttendanceReportExport($report), "attendance-{$filters['from']}-to-{$filters['to']}.{$format}");
    }

    private function filters(Request $request): array
    {
        [$from, $to] = $this->attendance->resolveRange($request->query('period'), $request->query('from'), $request->query('to'));

        $status = $request->query('status', 'active'); // "all" = every status

        return [
            'from'       => $from,
            'to'         => $to,
            'class_id'   => $request->integer('class') ?: null,
            'section_id' => $request->integer('section') ?: null,
            'status'     => array_key_exists($status, Student::STATUSES) ? $status : null,
        ];
    }

    /** Query string that reproduces these filters (used by the export buttons). */
    private function query(array $f): array
    {
        return array_filter([
            'from'    => $f['from'],
            'to'      => $f['to'],
            'class'   => $f['class_id'],
            'section' => $f['section_id'],
            'status'  => $f['status'] ?? 'all',
        ]);
    }
}