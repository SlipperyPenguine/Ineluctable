<?php

namespace ineluctable\Events;

use ineluctable\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScheduleUpdateEveCharactersCompleted  extends JobCompletedEvent
{
    use SerializesModels;



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
