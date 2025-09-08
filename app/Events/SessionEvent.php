<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionEvent implements ShouldBroadcast 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data,$type;

    public function __construct($data,$type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    public function broadcastOn(): array
    {
        return [
           new Channel('session'), 
        ];
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->data,
            'type' => $this->type
        ];
    }
}
