<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class EligibilityController extends Controller
{
    public function eligibility()
    {
        return view('frontend.eligibility');
    }
}
