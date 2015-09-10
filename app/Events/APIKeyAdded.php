<?php

namespace ineluctable\Events;

use ineluctable\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use ineluctable\models\SeatKey;

class APIKeyAdded extends Event
{
    use SerializesModels;

    public $SeatKey;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SeatKey $SeatKey)
    {
        $this->SeatKey = $SeatKey;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
