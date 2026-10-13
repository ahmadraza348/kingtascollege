<?php

namespace App\Mail;

use App\Models\Admission;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Sent to the college (info@kingtascollege.com): a new student filled the form.
 */
class NewAdmissionMail extends Mailable
{
    public function __construct(
        public Admission $admission,
        public ?string $pdf = null
    ) {
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
        if (! $this->pdf) {
            return [];
        }

        return [
            Attachment::fromData(fn () => $this->pdf, 'Admission-Form-' . $this->admission->form_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
