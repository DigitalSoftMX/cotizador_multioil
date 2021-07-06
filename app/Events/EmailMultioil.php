<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailMultioil
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $order, $state, $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $state, $message = '')
    {
        $this->order = $order;
        $this->state = $state;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getOrder()
    {
        return $this->order;
    }
    public function getState()
    {
        return $this->state;
    }
    public function getMessage()
    {
        return $this->message;
    }
}
