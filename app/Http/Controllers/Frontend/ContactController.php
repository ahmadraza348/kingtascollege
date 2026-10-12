<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function contact()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'min:3', 'max:120'],
            'phone'   => ['required', 'string', 'max:30'],
            'email'   => ['nullable', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:150'],
            'program' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // TODO: save to a database table or send a Mail here.
        Log::info('Contact form submitted', $data);

        return redirect()->to(route('frontend.contact') . '?sent=1');
    }
}
