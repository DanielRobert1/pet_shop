<?php

namespace App\Events\Auth;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $password;

    /**
     * NewRegistered constructor.
     * @param Authenticatable $user
     * @param string $password
     */
    public function __construct(Authenticatable $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
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
