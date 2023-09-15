<?php

namespace App\Events\Auth;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Authenticated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $requestData;

    /**
     * Authenticated constructor.
     * @param Authenticatable $user
     * @param array $requestData
     */
    public function __construct(Authenticatable $user, array $requestData)
    {
        $this->user = $user;
        $this->requestData = $requestData;
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
