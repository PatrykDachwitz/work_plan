<?php
declare(strict_types=1);
namespace App\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment, $user, $action;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $comment, int $user, string $action)
    {
        $this->user = $user;
        $this->comment = $comment;
        $this->action = $action;
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
}
