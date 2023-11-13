<?php

namespace App\Listeners;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogPasswordReset
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
     * @throws AuthenticationException
     */

    public function handle(PasswordReset $event): void
    {
        self::addLogs('PasswordReset Event --> User '.$event->user->getAuthIdentifier().' has performed password reset');

        Auth::logoutOtherDevices($event->user->getAuthPassword());

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
