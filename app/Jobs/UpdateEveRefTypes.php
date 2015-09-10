<?php

namespace ineluctable\Jobs;

use Exception;
use ineluctable\EveApi\Exception\APIServerDown;
use ineluctable\EveApi\Server\ServerStatus;
use ineluctable\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Log;

use ineluctable\EveApi\Eve\RefTypes;


class UpdateEveRefTypes extends Job implements SelfHandling
{
    use InteractsWithQueue, SerializesModels;

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
        Log::info('Started job ScheduleUpdateEveData', array('src' => __CLASS__));

        try
        {
            RefTypes::Update();

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

    }
}
