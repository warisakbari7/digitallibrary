<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApprovalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $userId;
    public $title;
    public $type;
    public $image;
    public $url;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userID,$title,$type,$image,$url)
    {
        $this->userId = $userID;
        $this->image =$image;
        $this->type = $type;
        $this->title = $title;
        $this->url = $url;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("approve.event.{$this->userId}");
    }

    public function broadcastAs()
    {
        return 'approve.event';
    }
}
