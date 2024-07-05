<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $companyId;
    public $html;

    /**
     * Create a new event instance.
     */
    public function __construct($message, $companyId, $html)
    {
        $this->message = $message;
        $this->companyId = $companyId;
        $this->html = $html;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn() : PrivateChannel
    {
        return new PrivateChannel('channel-chat.' . $this->companyId);
    }

    public function broadcastAs() : string{
        return 'message.received';
    }
}
