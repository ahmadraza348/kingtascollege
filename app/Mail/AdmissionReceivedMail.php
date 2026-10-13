<?php

namespace App\Mail;

use App\Models\Admission;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Sent to the student: "your admission form is under process" + PDF copy.
 */
class AdmissionReceivedMail extends Mailable
{
    public function __construct(
        public Admission $admission,
        public ?string $pdf = null
    ) {
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
        if (! $this->pdf) {
            return [];
        }

        return [
            Attachment::fromData(fn () => $this->pdf, 'Admission-Form-' . $this->admission->form_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
