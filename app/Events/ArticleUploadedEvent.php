<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleUploadedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $userId;
    public $url;
    public $owner;
    public $title;
    public $image;
    public $created_at;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId,$url,$owner,$title,$image,$created_at)
    {
        $this->userId = $userId;
        $this->owner = $owner;
        $this->title = $title;
        $this->image = $image;
        $this->url = $url;
        $this->created_at = $created_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("article.{$this->userId}");
    }

    public function broadcastAs()
    {
        return "article.upload";
    }
}
