<?php

namespace ineluctable\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;

abstract class Job
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */

    use Queueable;

    protected $starttime;

    protected function JobStarted()
    {
        $this->starttime = Carbon::now();
    }

    protected function JobFinsishedSuccessFully($command, $queue, $parameters)
    {
        $endtime = Carbon::now();
        $duration = $endtime->getTimestamp() - $endtime->getTimestamp();

        //queue
        //command
        $serialized = serialize($parameters);

        //store in DB

        //fire an event that will store in db etc
    }

}
