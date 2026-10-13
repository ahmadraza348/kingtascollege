<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AdmissionFormRequest;
use App\Services\Frontend\AdmissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function admission(): View
    {
        return view('frontend.admission');
    }

    public function store(
        AdmissionFormRequest $request,
        AdmissionService $admissionService
    ): RedirectResponse {
        $admissionService->create($request->validated());
        toastr()->success('Admission application submitted successfully.');
        return redirect()->route('frontend.admission_success', ['submitted' => 1]);
    }
}
