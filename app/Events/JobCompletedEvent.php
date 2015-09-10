<?php

namespace ineluctable\Events;

use Carbon\Carbon;
use ineluctable\models\CompletedJobs;

abstract class JobCompletedEvent extends Event
{

    public $jobid;
    public $queue;
    public $command;
    public $started;
    public $ended;
    public $params;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($jobid, $queue, $command, $started, $ended, $params)
    {
        $this->jobid = $jobid;
        $this->queue = $queue;
        $this->command = $command;
        $this->started = $started;
        $this->ended = $ended;
        $this->params = $params;
    }

}
