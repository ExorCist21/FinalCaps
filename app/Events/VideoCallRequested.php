<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VideoCallRequested
{
    use Dispatchable, SerializesModels;

    public $from;
    public $appointmentId;
    public $channel;

    public function __construct($from, $appointmentId, $channel)
    {
        $this->from = $from;
        $this->appointmentId = $appointmentId;
        $this->channel = $channel;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('video-call.' . $this->appointmentId);
    }
}
