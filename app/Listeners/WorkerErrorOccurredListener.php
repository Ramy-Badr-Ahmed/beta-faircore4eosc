<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Laravel\Octane\Events\WorkerErrorOccurred;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WorkerErrorOccurredListener
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
    public function handle(WorkerErrorOccurred $event): void
    {
        self::addLogs("WorkerErrorOccurred --> ". now(). " --> " .$event->exception->getMessage());
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
