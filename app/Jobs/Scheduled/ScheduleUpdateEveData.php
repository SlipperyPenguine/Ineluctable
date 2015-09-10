<?php

namespace ineluctable\Jobs\Scheduled;

use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use ineluctable\EveApi\Exception\APIServerDown;
use ineluctable\EveApi\Server\ServerStatus;
use ineluctable\Events\ScheduleUpdateEveDataCompleted;
use ineluctable\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use ineluctable\Jobs\UpdateEveAllianceList;
use ineluctable\Jobs\UpdateEveConquerableStationList;
use ineluctable\Jobs\UpdateEveErrorList;
use ineluctable\Jobs\UpdateEveRefTypes;

use Log;

class ScheduleUpdateEveData extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->JobStarted();

        Log::info('Started job ScheduleUpdateEveData', array('src' => __CLASS__));

        try
        {
            $job = new UpdateEveRefTypes();
            $this->dispatch($job);

            $job = new UpdateEveErrorList();
            $this->dispatch($job);

            $job = new UpdateEveConquerableStationList();
            $this->dispatch($job);

            $job = new UpdateEveAllianceList();
            $this->dispatch($job);

        }
        catch (APIServerDown $e)
        {
            //caught an expected error when the server is unavailable, doesn't need queuing again
            Log::info('The API server appears to be down', array('src' => __CLASS__));
        }
        catch (Exception $e)
        {
            //Unexpected error occurred, log it and rethrow to be reqeued presumably
            Log::error('An unexpected error occurred when trying to run the Job', array('src' => __CLASS__));
            throw $e;
        }

        $params = '';

        event(new ScheduleUpdateEveDataCompleted($this->job->getJobId() , $this->job->getQueue() , static::class, $this->starttime, Carbon::Now(), $params));

    }
}
