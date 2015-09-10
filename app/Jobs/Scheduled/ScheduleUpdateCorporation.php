<?php

namespace ineluctable\Jobs\Scheduled;

use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use ineluctable\Events\ScheduleUpdateCorporationCompleted;
use ineluctable\Events\ScheduleUpdateEveCharactersCompleted;
use ineluctable\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use ineluctable\EveApi;
use ineluctable\EveApi\Account;
//use ineluctable\Services\Settings\SettingHelper as Settings;

use ineluctable\Jobs\UpdateCorporationAccount;
use ineluctable\models\SeatKey;
use ineluctable\Jobs\Scheduled\ScheduleUpdateAccountCharacters;


class ScheduleUpdateCorporation extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    protected $keyID;
    protected  $vCode;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($keyID, $vCode)
    {
        $this->keyID = $keyID;
        $this->vCode = $vCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->JobStarted();

        // Log what we are going to do in the laravel.log file
        \Log::info('Started job ScheduleUpdateCorporation', array('src' => __CLASS__));


        $job = new UpdateCorporationAccount($this->keyID, $this->vCode);
        $this->dispatch($job);


        $params = '';

        event(new ScheduleUpdateCorporationCompleted($this->job->getJobId() , $this->job->getQueue() , static::class, $this->starttime, Carbon::Now(), $params));

    }
}
