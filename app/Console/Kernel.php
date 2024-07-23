<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\File;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('swh:updateCron')
            ->timezone('Europe/Berlin')
            ->everyFiveSeconds()
            ->withoutOverlapping();

        $schedule->command('app:delete-unverified-accounts')
            ->timezone('Europe/Berlin')
            ->everyOddHour();

        $schedule->call(
            function (){
                DB::table('global_values')
                    ->updateOrInsert(['key' => 'copyright_year'], ['value' => now()->year]);
            })
            ->timezone('Europe/Berlin')
            ->yearlyOn(1, 1, '00:05');

        $schedule->call(function () {
            $octaneLogPath = storage_path('logs/octane-roadrunner-server.log');

            if (File::exists($octaneLogPath)) {
                File::put($octaneLogPath, '');
            }
        })->daily();
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
