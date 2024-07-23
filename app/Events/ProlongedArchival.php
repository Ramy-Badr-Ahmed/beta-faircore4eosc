<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Events;

use App\Models\SoftwareHeritageRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProlongedArchival
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    /**
     * Create a new event instance.
     */

    public function __construct(public SoftwareHeritageRequest $archivalRequest)
    {
        self::addLogs(substr(self::class, strrpos(self::class, "\\" )+1 ). " Event Fired");
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    /**
     * @param string $infoLog
     * @return void
     */

    public static function addLogs(string $infoLog): void
    {
        Log::channel('eventsLogs')->info($infoLog);
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
