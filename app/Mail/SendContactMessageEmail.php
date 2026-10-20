<?php

namespace App\Jobs;

use App\Mail\NewContactMail;
use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Emails a saved contact-form query to the college, then flags the row as `email_sent`.
 * A job (rather than a queued mailable) so the flag is only set after the mail really went out.
 */
class SendContactMessageEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    /** @return array<int, int> */
    public function backoff(): array
    {
        return [60, 300];
    }

    public function __construct(public ContactMessage $contactMessage, public string $to)
    {
    }

    public function handle(): void
    {
        Mail::to($this->to)->send(new NewContactMail($this->contactMessage));

        $this->contactMessage->update(['email_sent' => true]);
    }

    public function failed(Throwable $e): void
    {
        Log::error('Contact form email failed permanently', [
            'contact_message_id' => $this->contactMessage->id,
            'error' => $e->getMessage(),
        ]);
    }
}