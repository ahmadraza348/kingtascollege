<?php

namespace App\Services\Frontend;

use App\Jobs\SendContactMessageEmail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Throwable;

class ContactService
{
    /** The college inbox that receives every new query. */
    private const COLLEGE_EMAIL = 'info@kingtascollege.com';

    /**
     * Save the visitor's query, then queue the email to the college.
     *
     * The query is saved first, so it is never lost. `email_sent` stays false until the
     * queue worker has really sent the email (then the job sets it to true), so staff can
     * still find unsent queries in the database.
     *
     * @param array<string, mixed> $data Validated form data.
     */
    public function create(array $data): ContactMessage
    {
        $contactMessage = ContactMessage::create($data);

        try {
            SendContactMessageEmail::dispatch($contactMessage, self::COLLEGE_EMAIL);
        } catch (Throwable $e) {
            Log::error('Contact form email could not be queued', [
                'contact_message_id' => $contactMessage->id,
                'error' => $e->getMessage(),
            ]);
        }

        return $contactMessage;
    }
}