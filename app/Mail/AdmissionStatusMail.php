<?php

namespace App\Mail;

use App\Models\Admission;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Sent to the student when the admissions office changes the application status.
 */
class AdmissionStatusMail extends Mailable
{
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
