<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
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

    public function handle(Login $event): void
    {
        self::addLogs('Login Event --> User '.$event->user->getAuthIdentifier().' has successfully logged in. Remember: '. var_export($event->remember, true)) ;
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param string $infoLog
     * @return void
     */

    public static function addLogs(string $infoLog): void
    {
        Log::channel('loginLogs')->info($infoLog);
    }
}
