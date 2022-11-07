<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostedMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $users;
    public $user;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($users,$user)
    {
        $this->users = $users;
        $this->user = $user;
    }

}
