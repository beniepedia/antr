<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class DebugBroadcast implements ShouldBroadcast
{
    public $message;

    public function __construct($message = "Halo Debug 🚀")
    {
        $this->message = $message;
        Log::info("🔥 Event TestBroadcast dikirim: " . $this->message);
    }

    public function broadcastOn()
    {
        return new Channel('debug-channel');
        Log::info("🔥 Event TestBroadcast dikirim: " . $this->message);
    }

    public function broadcastAs()
    {
        Log::info("🔥 Event TestBroadcast dikirim: debug eventr" . $this->message);
        return 'debug.event';
    }
}
