<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Laravel\Octane\Events\WorkerStarting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WorkerStartingListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * Handle the event.
     */

    public function handle(WorkerStarting $event): void
    {
        self::addLogs("WorkerStarting --> ". now());
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param string $infoLog
     * @return void
     */

    public static function addLogs(string $infoLog): void
    {
        Log::channel('octaneLogs')->info($infoLog);
    }
}
