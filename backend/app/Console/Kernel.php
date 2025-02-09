<?php

namespace App\Console;

use App\Jobs\SendDailySalesReport;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define commands
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }

    /**
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SendDailySalesReport())->dailyAt('23:59');
    }
}

