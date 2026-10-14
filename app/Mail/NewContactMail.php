<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Sent to the college (info@kingtascollege.com): a visitor sent a new query.
 */
class NewContactMail extends Mailable
{
    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New website query: ' . $this->contactMessage->subject,
            // Hitting "Reply" in the inbox answers the visitor directly.
            replyTo: [$this->contactMessage->email],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.contact_admin');
    }
}
