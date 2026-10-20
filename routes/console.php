<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Queue worker for shared hosting (Hostinger)
|--------------------------------------------------------------------------
| Shared hosting cannot keep a "php artisan queue:work" process alive, so the
| scheduler starts a short worker every minute. It processes every waiting job
| (emails, PDFs), then stops. One cron entry runs the scheduler:
|   * * * * * php /path/to/project/artisan schedule:run
| On a VPS with Supervisor you can delete this block and run queue:work permanently.
*/
Schedule::command('queue:work --stop-when-empty --max-time=55 --tries=3 --timeout=60 --sleep=3')
    ->name('queue-worker')
    ->everyMinute()
    ->withoutOverlapping(5);

// Keep the failed_jobs table small (forget failures older than 30 days).
Schedule::command('queue:prune-failed --hours=720')->daily();