<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramDetailController extends Controller
{
    public function programs()
    {
        return view('frontend.program_details');
    }
}
