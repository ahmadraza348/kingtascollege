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
 * Sent to the college (info@kingtascollege.com): a new student filled the form.
 *
 * Queued: the PDF is built by the queue worker, not during the student's request.
 */
class NewAdmissionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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
            subject: 'New admission form: ' . $this->admission->full_name . ' (' . $this->admission->form_number . ')',
            // Hitting "Reply" in the inbox answers the student directly.
            replyTo: $this->admission->email ? [$this->admission->email] : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.admission_admin');
    }

    /** @return array<int, Attachment> */
    public function attachments(): array
    {
        $pdf = app(AdmissionNotificationService::class)->makePdfSafely($this->admission, 'Office Copy');

        if (! $pdf) {
            return [];
        }

        return [
            Attachment::fromData(fn () => $pdf, 'Admission-Form-' . $this->admission->form_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}