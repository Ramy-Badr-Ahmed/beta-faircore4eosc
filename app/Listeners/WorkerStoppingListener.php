<?php

namespace App\Listeners;

use Laravel\Octane\Events\WorkerStopping;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class WorkerStoppingListener
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

    public function handle(WorkerStopping $event): void
    {
        self::addLogs("WorkerStopping --> ". now());
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
