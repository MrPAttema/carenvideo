<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendCallMeta implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $userData = session()->get('carenUserToken');
        $this->userID = $userData->_embedded->person->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('call.' .$this->userID);
    }

    public function broadcastAs()
    {
        return 'call.metadata';
    }

    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->userID,
                'name' => $this->userID,
                'photo' => $this->userID,
            ]
        ];
    }
}
