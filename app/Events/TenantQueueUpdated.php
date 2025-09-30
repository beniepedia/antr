<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;

class TenantQueueUpdated implements ShouldBroadcast
{
    use InteractsWithSockets;

    public $tenantId;
    public $action;
    public $queueData;

    public function __construct($tenantId, $action, $queueData = null)
    {
        $this->tenantId = $tenantId;
        $this->action = $action; // 'called', 'completed', 'skipped'
        $this->queueData = $queueData;
    }

    public function broadcastOn()
    {
        // public channel untuk tenant tertentu
        return new Channel('tenant.' . $this->tenantId . '.queue');
    }

    public function broadcastAs()
    {
        return 'queue.updated';
    }
}