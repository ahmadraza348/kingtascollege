<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function all_programs()
    {
        return view('frontend.programs');
    }
    public function programs()
    {
        return view('frontend.program_details');
    }
}
