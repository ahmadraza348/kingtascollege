<?php

namespace App\Console\Commands;

use App\Services\Admin\AttendanceService;
use Illuminate\Console\Command;

class RebuildAttendanceSummaries extends Command
{
    protected $signature = 'attendance:rebuild';

    protected $description = 'Rebuild the monthly attendance summaries from the attendance logs.';

    public function handle(AttendanceService $service): int
    {
        $months = $service->rebuildAll();

        $this->info("Rebuilt {$months} month(s).");

        return self::SUCCESS;
    }
}