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

