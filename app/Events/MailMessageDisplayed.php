<?php

namespace ineluctable\Events;

use ineluctable\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use ineluctable\models\EveCharacterMailMessages;
use Monolog\Handler\LogglyHandler;
use Log;

class MailMessageDisplayed extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    private $userid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EveCharacterMailMessages $message)
    {
        $this->message = $message;
        $this->userid = auth()->user()->id;
        //Log::info('MailMessageDisplayed event fired');

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        //Log::info('BroadcastOn called');
        //return ['test'];
        return ['UserChannel-'.$this->userid];
    }
}
