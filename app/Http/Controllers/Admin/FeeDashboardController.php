<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\FeeReportService;
use Illuminate\View\View;

class FeeDashboardController extends Controller
{
    public function index(FeeReportService $reports): View
    {
        return view('backend.fees.dashboard', ['stats' => $reports->dashboard(), 'plan' => $reports->planAnalytics()]);
    }
}
