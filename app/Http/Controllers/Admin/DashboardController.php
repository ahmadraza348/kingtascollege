<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\AttendanceLog;
use App\Models\FeePayment;
use App\Models\FeeVoucher;
use App\Models\Student;
use App\Models\StudentProgram;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        $today = today()->toDateString();
        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();

        $admissionCounts = Admission::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $pendingAdmissions = Admission::whereIn('status', ['pending', 'under_review', 'documents_required'])->count();

        $attendanceCounts = AttendanceLog::query()
            ->where('date', $today)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $attendanceMarked = (int) $attendanceCounts->sum();
        $attendancePresent = (int) ($attendanceCounts['present'] ?? 0)
            + (int) ($attendanceCounts['late'] ?? 0)
            + (int) ($attendanceCounts['half_day'] ?? 0);

        $attendanceRate = $attendanceMarked > 0
            ? round(($attendancePresent / $attendanceMarked) * 100, 1)
            : null;

        $recentAdmissions = Admission::latest()->take(6)->get();
        $recentStudents = Student::with('programEnrollments')->latest()->take(6)->get();

        $programStats = StudentProgram::query()
            ->select('program')
            ->selectRaw('COUNT(DISTINCT student_id) as students_count')
            ->whereHas('student', fn ($query) => $query->where('status', 'active'))
            ->groupBy('program')
            ->orderByDesc('students_count')
            ->orderBy('program')
            ->limit(6)
            ->get();

        $stats = [
            'students_total' => Student::count(),
            'students_active' => Student::where('status', 'active')->count(),
            'students_new_month' => Student::whereBetween('admission_date', [$monthStart, $monthEnd])->count(),
            'pending_admissions' => $pendingAdmissions,
            'fee_outstanding' => (float) FeeVoucher::where('status', '!=', 'cancelled')->sum('balance'),
            'fee_collected_month' => (float) FeePayment::where('status', 'verified')
                ->whereBetween('payment_date', [$monthStart, $monthEnd])->sum('amount'),
            'overdue_vouchers' => FeeVoucher::where('status', '!=', 'cancelled')
                ->where('balance', '>', 0)->whereDate('due_date', '<', $today)->count(),
            'attendance_marked' => $attendanceMarked,
            'attendance_rate' => $attendanceRate,
        ];

        return view('backend.dashboard', compact(
            'stats',
            'admissionCounts',
            'recentAdmissions',
            'recentStudents',
            'programStats',
            'attendanceCounts'
        ));
    }
}
