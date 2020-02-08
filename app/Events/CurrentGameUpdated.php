<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CurrentGameUpdated implements ShouldBroadcast
{
    public $currentGame;

    public function __construct(int $currentGame)
    {
        $this->currentGame = $currentGame;
    }

    public function broadcastAs()
    {
        return 'current_game.updated';
    }

    public function broadcastWith()
    {
        return ['current_game' => $this->currentGame];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('messages');
    }
}
