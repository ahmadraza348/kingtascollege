<?php

namespace App\Services\Frontend;

use App\Mail\NewContactMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactService
{
    /** The college inbox that receives every new query. */
    private const COLLEGE_EMAIL = 'info@kingtascollege.com';

    /**
     * Save the visitor's query, then email it to the college.
     *
     * The query is saved first, so it is never lost even if the email fails.
     * An email failure is logged and stored in the `email_sent` column.
     *
     * @param array<string, mixed> $data Validated form data.
     */
    public function create(array $data): ContactMessage
    {
        $contactMessage = ContactMessage::create($data);

        $contactMessage->update([
            'email_sent' => $this->sendToCollege($contactMessage),
        ]);

        return $contactMessage;
    }

    /**
     * Returns true when the email was handed to the mail server, false otherwise.
     */
    private function sendToCollege(ContactMessage $contactMessage): bool
    {
        try {
            Mail::to(self::COLLEGE_EMAIL)->send(new NewContactMail($contactMessage));

            return true;
        } catch (Throwable $e) {
            Log::error('Contact form email failed', [
                'contact_message_id' => $contactMessage->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
