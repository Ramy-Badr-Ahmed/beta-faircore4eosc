<?php

namespace App\Listeners;

use Laravel\Octane\Events\RequestReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RequestReceivedListener
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

    public function handle(RequestReceived $event): void
    {
        self::addLogs('RequestReceived --> Incoming '.$event->request->method().' for pathInfo: '.$event->request->getPathInfo().' by: '.$event->request->header('X-Forwarded-For'));
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
