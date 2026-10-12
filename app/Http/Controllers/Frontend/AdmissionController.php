<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdmissionController extends Controller
{
    public function admission()
    {
        return view('frontend.admission');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fullName'      => ['required', 'string', 'min:3', 'max:120'],
            'fatherName'    => ['required', 'string', 'min:3', 'max:120'],
            'dob'           => ['required', 'date'],
            'gender'        => ['required', 'string', 'max:20'],
            'cnic'          => ['required', 'string', 'max:20'],
            'phone'         => ['required', 'string', 'max:30'],
            'whatsapp'      => ['nullable', 'string', 'max:30'],
            'email'         => ['nullable', 'email', 'max:150'],
            'qualification' => ['required', 'string', 'max:100'],
            'institution'   => ['required', 'string', 'max:150'],
            'obtained'      => ['nullable', 'numeric'],
            'total'         => ['nullable', 'numeric'],
            'percentage'    => ['nullable', 'numeric'],
            'program'       => ['required', 'string', 'max:100'],
            'session'       => ['nullable', 'string', 'max:20'],
            'notes'         => ['nullable', 'string', 'max:600'],
            'street'        => ['required', 'string', 'max:200'],
            'city'          => ['required', 'string', 'max:100'],
            'district'      => ['nullable', 'string', 'max:100'],
            'province'      => ['nullable', 'string', 'max:100'],
            'documents'     => ['nullable', 'array', 'max:10'],
            'documents.*'   => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'agreeTerms'    => ['accepted'],
        ]);

        $paths = [];
        foreach ($request->file('documents', []) as $file) {
            $paths[] = $file->store('admissions', 'local');
        }

        // TODO: persist $data + $paths in an `admissions` table.
        Log::info('Admission application submitted', ['data' => collect($data)->except('documents')->all(), 'files' => $paths]);

        return redirect()->to(route('frontend.admission') . '?submitted=1');
    }
}
