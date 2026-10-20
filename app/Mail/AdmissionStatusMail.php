<?php

namespace App\Mail;

use App\Models\Admission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the student when the admissions office changes the application status.
 * Queued, so the admin's "Update status" click returns instantly.
 */
class AdmissionStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    /** @return array<int, int> */
    public function backoff(): array
    {
        return [60, 300];
    }

    public function __construct(
        public Admission $admission,
        public ?string $remarks = null
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admission update: ' . $this->admission->status_label . ' (' . $this->admission->form_number . ') - King TAS College',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.admission_status');
    }
}