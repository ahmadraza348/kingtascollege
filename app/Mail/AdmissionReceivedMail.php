<?php

namespace App\Mail;

use App\Models\Admission;
use App\Services\Frontend\AdmissionNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the student: "your admission form is under process" + PDF copy.
 *
 * Queued: the PDF is built by the queue worker (not while the student waits),
 * so only the Admission id is stored in the jobs table.
 */
class AdmissionReceivedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** Try 3 times (1 min, then 5 min apart) before the job lands in failed_jobs. */
    public int $tries = 3;

    public int $timeout = 60;

    /** @return array<int, int> */
    public function backoff(): array
    {
        return [60, 300];
    }

    public function __construct(public Admission $admission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admission form received (' . $this->admission->form_number . ') - King TAS College',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.admission_student');
    }

    /** @return array<int, Attachment> */
    public function attachments(): array
    {
        $pdf = app(AdmissionNotificationService::class)->makePdfSafely($this->admission, 'Applicant Copy');

        if (! $pdf) {
            return [];
        }

        return [
            Attachment::fromData(fn () => $pdf, 'Admission-Form-' . $this->admission->form_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}