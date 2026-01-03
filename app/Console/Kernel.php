<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Activitylog\Models\ActivityLog;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Contoh bawaan Laravel
        // $schedule->command('inspire')->hourly();

        // ✅ PERBAIKAN: Command HARUS di dalam method schedule()
        $schedule->command('model:prune', [
            '--model' => [ActivityLog::class],
        ])->monthly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
