<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Listeners;

use App\Providers\RouteServiceProvider;
use Laravel\Octane\Events\RequestHandled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RequestHandledListener
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

    public function handle(RequestHandled $event): void
    {
        self::addLogs('RequestHandled --> Method '.$event->request->method().' pathInfo: '. $event->request->getPathInfo(). " for ". $event->request->header('X-Forwarded-For')) ;
        self::addLogs('RequestHandled --> CollectGarbage was called');

        $event->response->setCache([
            'no_cache' => true,
            'must_revalidate' => true,
            'private' => true
        ]);

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
