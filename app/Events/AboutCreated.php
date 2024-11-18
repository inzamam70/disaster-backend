<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AboutCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $about;

    /**
     * Create a new event instance.
     */
    public function __construct($about)
    {
        //
        $this->about = $about;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('my-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'about-created';
    }

    public function broadcastWith(): array
    {
        return [
            'about' => $this->about,
        ];
    }
}
