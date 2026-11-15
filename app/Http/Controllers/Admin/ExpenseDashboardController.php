<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ExpenseReportService;
use App\Support\FeeHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseDashboardController extends Controller
{
    public function index(Request $request, ExpenseReportService $reports): View
    {
        $month = (string) $request->query('month');
        if (! preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $month)) {
            $month = FeeHelper::today()->format('Y-m');
        }

        return view('backend.expenses.dashboard', ['stats' => $reports->dashboard($month)]);
    }
}
