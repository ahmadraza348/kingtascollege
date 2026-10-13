<?php

namespace App\Services\Frontend;

use App\Mail\AdmissionReceivedMail;
use App\Mail\NewAdmissionMail;
use App\Models\Admission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AdmissionNotificationService
{
    /**
     * Send the "form under process" email to the student and the
     * "new student" email to the college. Failures are logged, never thrown.
     */
    public function send(Admission $admission): void
    {
        $studentPdf = null;
        $adminPdf = null;

        try {
            $studentPdf = $this->makePdf($admission, 'Applicant Copy');
            $adminPdf = $this->makePdf($admission, 'Office Copy');
        } catch (Throwable $e) {
            Log::error('Admission PDF generation failed', [
                'admission_id' => $admission->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Email to the student
        if (! empty($admission->email)) {
            try {
                Mail::to($admission->email)->send(new AdmissionReceivedMail($admission, $studentPdf));
            } catch (Throwable $e) {
                Log::error('Student admission email failed', [
                    'admission_id' => $admission->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Email to the college / admin (info@kingtascollege.com)
        try {
            Mail::to(config('mail.from.address'))->send(new NewAdmissionMail($admission, $adminPdf));
        } catch (Throwable $e) {
            Log::error('Admin admission email failed', [
                'admission_id' => $admission->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Build the admission form PDF and return the raw PDF bytes.
     */
    public function makePdf(Admission $admission, string $copyLabel = 'Applicant Copy'): string
    {
        return Pdf::loadView('pdf.admission_form', [
            'admission' => $admission,
            'copyLabel' => $copyLabel,
            'logo'      => $this->publicImageDataUri('frontend/assets/images/logo/logo.png'),
            'photo'     => $this->storedImageDataUri($admission->personal_picture_path),
        ])->setPaper('a4', 'portrait')->output();
    }

    /** Embed a public-folder image as a data URI (DomPDF needs no remote access). */
    private function publicImageDataUri(string $relativePath): ?string
    {
        $path = public_path($relativePath);

        return is_file($path) ? $this->toDataUri(file_get_contents($path), $path) : null;
    }

    /** Embed a private-disk image (the student's photo) as a data URI. */
    private function storedImageDataUri(?string $path): ?string
    {
        if (! $path || ! Storage::disk('local')->exists($path)) {
            return null;
        }

        return $this->toDataUri(Storage::disk('local')->get($path), $path);
    }

    private function toDataUri(string $binary, string $path): string
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = in_array($ext, ['jpg', 'jpeg'], true) ? 'image/jpeg' : 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode($binary);
    }
}
