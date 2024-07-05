<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadMessageRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sid;
    public $html;
    public $companyId;

    /**
     * Create a new event instance.
     */
    public function __construct($sid, $html, int $companyId)
    {
        $this->sid = $sid;
        $this->html = $html;
        $this->companyId = $companyId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-lead-message-read.' . $this->companyId);
    }

    public function broadcastAs() : string
    {
        return 'lead.message.read';
    }
}
