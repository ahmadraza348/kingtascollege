<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Sent to an admin who asked for a password reset link.
 */
class AdminResetPasswordMail extends Mailable
{
    public function __construct(
        public Admin $admin,
        public string $token,
        public int $minutes = 60
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Reset your admin password - King TAS College');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_reset_password',
            with: ['resetUrl' => route('reset.password.get', ['token' => $this->token])],
        );
    }
}
