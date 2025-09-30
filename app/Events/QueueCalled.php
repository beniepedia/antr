<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QueueCalled implements ShouldBroadcast
{
    use InteractsWithSockets;

    public $queueNumber;

    public function __construct($queueNumber)
    {
        $this->queueNumber = $queueNumber;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('queue');
    }
}
