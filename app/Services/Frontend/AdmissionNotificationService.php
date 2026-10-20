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
     * Queue the "form under process" email to the student and the "new student"
     * email to the college. Nothing slow happens here: the PDFs are built and the
     * mails are sent later by the queue worker (php artisan queue:work).
     * Failures to queue are logged, never thrown, so a saved application is never undone.
     */
    public function send(Admission $admission): void
    {
        // Email to the student
        if (! empty($admission->email)) {
            try {
                Mail::to($admission->email)->queue(new AdmissionReceivedMail($admission));
            } catch (Throwable $e) {
                Log::error('Student admission email could not be queued', [
                    'admission_id' => $admission->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Email to the college / admin (info@kingtascollege.com)
        try {
            Mail::to(config('mail.from.address'))->queue(new NewAdmissionMail($admission));
        } catch (Throwable $e) {
            Log::error('Admin admission email could not be queued', [
                'admission_id' => $admission->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Like makePdf(), but returns null instead of throwing, so an email can still
     * go out (without the attachment) if PDF generation fails.
     */
    public function makePdfSafely(Admission $admission, string $copyLabel = 'Applicant Copy'): ?string
    {
        try {
            return $this->makePdf($admission, $copyLabel);
        } catch (Throwable $e) {
            Log::error('Admission PDF generation failed', [
                'admission_id' => $admission->id,
                'error' => $e->getMessage(),
            ]);

            return null;
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

    /**
     * Build the empty, printable admission form students can download from the website.
     */
    public function makeBlankPdf(): string
    {
        return Pdf::loadView('pdf.admission_form_blank', [
            'logo' => $this->publicImageDataUri('frontend/assets/images/logo/logo.png'),
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