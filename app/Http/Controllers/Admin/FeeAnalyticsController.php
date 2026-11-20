<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Services\Admin\FeeAnalyticsService;
use App\Support\FeeHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class FeeAnalyticsController extends Controller
{
    public function __construct(private FeeAnalyticsService $analytics)
    {
    }

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'period' => ['nullable', 'date_format:Y-m'],
            'class' => ['nullable', 'integer', 'exists:school_classes,id'],
        ]);

        $period = $filters['period'] ?? FeeHelper::today()->format('Y-m');
        $classId = isset($filters['class']) ? (int) $filters['class'] : null;
        $classRows = $this->analytics->classWise($period, $classId);

        $totals = [
            'active_students' => (int) $classRows->sum('active_students'),
            'students_without_fee' => (int) $classRows->sum('students_without_fee'),
            'students_unpaid_this_month' => (int) $classRows->sum('students_unpaid_this_month'),
            'total_fee' => round((float) $classRows->sum('total_fee'), 2),
            'received_total' => round((float) $classRows->sum('received_total'), 2),
            'remaining_fee' => round((float) $classRows->sum('remaining_fee'), 2),
            'month_collected' => round((float) $classRows->sum('month_collected'), 2),
            'period_voucher_total' => round((float) $classRows->sum('period_voucher_total'), 2),
            'period_voucher_balance' => round((float) $classRows->sum('period_voucher_balance'), 2),
        ];

        return view('backend.fees.analytics.index', [
            'period' => $period,
            'periodLabel' => FeeHelper::periodLabel($period),
            'classId' => $classId,
            'classes' => SchoolClass::query()->orderBy('sort_order')->orderBy('name')->get(['id', 'name']),
            'classRows' => $classRows,
            'totals' => $totals,
            'unpaidStudents' => $this->analytics->unpaidStudents($period, $classId),
        ]);
    }

    public function pdf(Request $request): Response
    {
        $filters = $request->validate([
            'period' => ['nullable', 'date_format:Y-m'],
            'class' => ['nullable', 'integer', 'exists:school_classes,id'],
        ]);

        $period = $filters['period'] ?? FeeHelper::today()->format('Y-m');
        $classId = isset($filters['class']) ? (int) $filters['class'] : null;
        $report = $this->analytics->monthlyReport($period, $classId);
        $suffix = $classId ? '-class-' . $classId : '-all-classes';

        return Pdf::loadView('backend.fees.pdf.monthly-class-report', [
            'report' => $report,
            'letterhead' => FeeHelper::letterhead(),
        ])->setPaper('a4', 'landscape')
            ->stream('monthly-fee-report-' . $period . $suffix . '.pdf');
    }
}
