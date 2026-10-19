<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Http\Requests\Frontend\AdmissionFormRequest;
use App\Services\Frontend\AdmissionNotificationService;
use App\Services\Frontend\AdmissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AdmissionController extends Controller
{
    public function admission(): View
    {
        return view('frontend.admission');
    }

    /**
     * "View admission form" page (linked from the navbar).
     *
     * Shows how the form looks (inline PDF preview) with a Download button.
     * The form is NOT downloaded automatically when the student opens this page.
     */
    public function viewForm(): View
    {
        $ownFile = $this->ownFormFile();
        $extension = $ownFile ? strtolower(pathinfo($ownFile, PATHINFO_EXTENSION)) : 'pdf';

        return view('frontend.admission_form_view', [
            // Word documents cannot be previewed in the browser; everything else can.
            'canPreview' => in_array($extension, ['pdf', 'jpg', 'jpeg', 'png'], true),
        ]);
    }

    /** The form shown inside the preview frame (inline, never forced to download). */
    public function previewForm(AdmissionNotificationService $notifications): Response
    {
        $ownFile = $this->ownFormFile();

        if ($ownFile) {
            return response()->file($ownFile, [
                'Content-Disposition' => 'inline; filename="King-TAS-College-Admission-Form.' . pathinfo($ownFile, PATHINFO_EXTENSION) . '"',
            ]);
        }

        return response($notifications->makeBlankPdf(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="King-TAS-College-Admission-Form.pdf"',
        ]);
    }

    /**
     * Download the admission form. Only reached from the Download button on the
     * "View admission form" page.
     *
     * If you put your own form at public/downloads/admission-form.pdf (or .doc / .docx / .jpg / .png)
     * that exact file is downloaded. Otherwise a printable blank form is generated.
     */
    public function downloadForm(AdmissionNotificationService $notifications): Response
    {
        $ownFile = $this->ownFormFile();

        if ($ownFile) {
            $extension = pathinfo($ownFile, PATHINFO_EXTENSION);

            return response()->download($ownFile, 'King-TAS-College-Admission-Form.' . $extension);
        }

        return response($notifications->makeBlankPdf(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="King-TAS-College-Admission-Form.pdf"',
        ]);
    }

    /** A custom form placed by the college in public/downloads/, if there is one. */
    private function ownFormFile(): ?string
    {
        $files = glob(public_path('downloads/admission-form.*')) ?: [];

        return $files[0] ?? null;
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
            'id'          => $admission->id,
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

        // Documents the student just uploaded, so they can view them after applying.
        $admission = isset($data['id']) ? Admission::find($data['id']) : null;

        return view('frontend.admission_success', [
            'admission' => $data,
            'documents' => $admission ? $admission->documents() : collect(),
        ]);
    }

    /**
     * Let the student who just applied view one of their own uploaded documents.
     * Access is tied to the session of the submission, and the file path always
     * comes from the database (never from the URL).
     */
    public function myDocument(string $key): Response
    {
        $admission = $this->submittedAdmission();

        $doc = $admission->documents()->firstWhere('key', $key);
        abort_unless($doc && Storage::disk('local')->exists($doc['path']), 404);

        return Storage::disk('local')->response($doc['path'], null, [
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /** Let the student view the form they submitted (PDF, applicant copy). */
    public function myForm(AdmissionNotificationService $notifications): Response
    {
        $admission = $this->submittedAdmission();

        return response($notifications->makePdf($admission, 'Applicant Copy'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Admission-Form-' . $admission->form_number . '.pdf"',
        ]);
    }

    /** The application submitted in this browser session, or a 404. */
    private function submittedAdmission(): Admission
    {
        $id = session('admission_success.id');
        abort_unless($id, 404);

        return Admission::findOrFail($id);
    }
}
