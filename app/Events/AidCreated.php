<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AidCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $aid;

    public function __construct($aid)
    {
        $this->aid = $aid;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('my-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'aid-created';
    }

    public function broadcastWith(): array
    {
        return [
            'aid' => $this->aid,
        ];
    }
}
