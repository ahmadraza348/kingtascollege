<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AdmissionFormRequest;
use App\Services\Frontend\AdmissionNotificationService;
use App\Services\Frontend\AdmissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AdmissionController extends Controller
{
    public function admission(): View
    {
        return view('frontend.admission');
    }

    /**
     * Download the admission form (linked from the navbar).
     *
     * If you put your own form at public/downloads/admission-form.pdf (or .doc / .docx / .jpg / .png)
     * that exact file is downloaded. Otherwise a printable blank form is generated.
     */
    public function downloadForm(AdmissionNotificationService $notifications): Response
    {
        $ownFile = glob(public_path('downloads/admission-form.*')) ?: [];

        if ($ownFile) {
            $extension = pathinfo($ownFile[0], PATHINFO_EXTENSION);

            return response()->download($ownFile[0], 'King-TAS-College-Admission-Form.' . $extension);
        }

        return response($notifications->makeBlankPdf(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="King-TAS-College-Admission-Form.pdf"',
        ]);
    }

    public function store(
        AdmissionFormRequest $request,
        AdmissionService $admissionService,
        AdmissionNotificationService $notifications
    ): RedirectResponse {
        // 1. Save the application and its documents.
        $admission = $admissionService->create($request->validated());

        // 2. Send the student + admin emails (with PDF). This never throws,
        //    so a mail problem can't undo a successfully saved application.
        $notifications->send($admission);

        // 3. Keep the details in the session so the success page survives a refresh.
        session()->put('admission_success', [
            'form_number' => $admission->form_number,
            'full_name'   => $admission->full_name,
            'program'     => $admission->program,
            'email'       => $admission->email,
        ]);
        toastr()->success('Your application has been submitted successfully. Please check your email for confirmation.');
        return redirect()->route('frontend.admission_success');
    }

    public function success(): View|RedirectResponse
    {
        $data = session('admission_success');

        // Someone opened /admission/success directly without applying.
        if (! $data) {
            toastr()->error('Invalid request.');
            return redirect()->route('frontend.admission');
        }

        return view('frontend.admission_success', ['admission' => $data]);
    }
}
