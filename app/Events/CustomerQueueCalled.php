<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CustomerQueueCalled implements ShouldBroadcast
{
    use InteractsWithSockets;

    public $queueNumber;

    public $userId;

    public function __construct($queueNumber, $userId)
    {
        $this->queueNumber = $queueNumber;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        // private channel untuk user tertentu
        return new PrivateChannel('customer.'.$this->userId);
    }
}
