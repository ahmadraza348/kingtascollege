<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function all_programs()
    {
        return view('frontend.programs');
    }

    // Program block is chosen client-side from ?program=<id> (see filters.js)
    public function programs()
    {
        return view('frontend.program_details');
    }

    // /programs/bsn-generic  ->  /program-details?program=bsn-generic
    public function bySlug(string $slug)
    {
        return redirect()->route('frontend.program-details', ['program' => $slug]);
    }
}
