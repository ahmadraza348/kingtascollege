<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('check_admin_auth')) {
    function check_admin_auth($routeName)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view($routeName);
    }
  
}

if (! function_exists('fee_money')) {
    function fee_money($amount): string
    {
        return \App\Support\FeeHelper::money($amount);
    }
}

if (! function_exists('fee_date')) {
    function fee_date($date, string $format = 'd M Y'): string
    {
        return $date ? \Carbon\Carbon::parse($date)->format($format) : '—';
    }
}

