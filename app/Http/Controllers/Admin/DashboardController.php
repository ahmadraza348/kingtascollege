<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $counts = Admission::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $recentAdmissions = Admission::latest()->take(5)->get();

        return view('backend.dashboard', compact('counts', 'recentAdmissions'));
    }
}
