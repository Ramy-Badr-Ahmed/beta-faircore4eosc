<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Listeners;

use App\Events\ProlongedArchival;
use App\Mail\EOSCMailer;
use App\Models\SoftwareHeritageRequest;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProlongedArchivalListener
{

    protected array $userData;

#__________________________________________________________________________________________________________________________________________________________________________________________________
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
    public function handle(ProlongedArchival $event): void
    {
        self::addLogs('ProlongedArchival Event handle: For URL --> ' .$event->archivalRequest->originUrl);

        $event->archivalRequest->delete();

        $this->setUserData($event->archivalRequest);

        self::addLogs('Archival Request Deleted : '.$event->archivalRequest->originUrl." Created by: "
            .$this->userData['id']." -- ".$this->userData['name']." -- Last Update: ".$event->archivalRequest->updated_at);

        $this->notifyUser($event->archivalRequest);
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param string $infoLog
     * @return void
     */

    public static function addLogs(string $infoLog): void
    {
        Log::channel('eventsLogs')->info($infoLog);
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param SoftwareHeritageRequest $archivalRequest
     * @return array
     */

    private function setUserData(SoftwareHeritageRequest $archivalRequest): void
    {
        $userData = User::where('id', '=', $archivalRequest->createdBy_id)->first();

        $this->userData = ["id" => $userData->id , "name" => $userData->name, "email" => $userData->email];
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param SoftwareHeritageRequest $archivalRequest
     * @return void
     */

    private function notifyUser(SoftwareHeritageRequest $archivalRequest): void
    {
        $mailData = [
            'recipient' => $this->userData['email'],
            'user'   => $this->userData['name'],
            'subject' => 'Prolonged Archival Request',
            'url' => $archivalRequest->originUrl,
            'view' => 'emails.prolonged'
        ];

        Mail::to($this->userData['email'])->send(new EOSCMailer($mailData));
    }
}
