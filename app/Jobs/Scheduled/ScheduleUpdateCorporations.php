<?php

namespace ineluctable\Jobs\Scheduled;

use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use ineluctable\Events\ScheduleUpdateEveCharactersCompleted;
use ineluctable\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use ineluctable\EveApi;
use ineluctable\EveApi\Account;
//use ineluctable\Services\Settings\SettingHelper as Settings;

use ineluctable\models\SeatKey;
use ineluctable\Jobs\Scheduled\ScheduleUpdateAccountCharacters;


class ScheduleUpdateCorporations extends Job implements SelfHandling, ShouldQueue
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

        // Log what we are going to do in the laravel.log file
        \Log::info('Started job ScheduleUpdateCorporations', array('src' => __CLASS__));

        // Get the keys that are not disabled and process them.
        foreach (SeatKey::where('isOk', '=', 1)->get() as $key) {

            // It is important to know the type of key we are working
            // with so that we may know which API calls will
            // apply to it. For that reason, we run the
            // Seat\EveApi\BaseApi\determineAccess()
            // function to get this.
            $access = EveApi\BaseApi::determineAccess($key->keyID);

            // If we failed to determine the access type of the
            // key, continue to the next key.
            if (!isset($access['type'])) {

                //TODO: Log this key's problems and disable it
                continue;
            }

            // If the key is a of type 'Character', then we can
            // continue to submit a updater job
            if ($access['type'] == 'Corporation') {

                // Do a fresh AccountStatus lookup
                Account\AccountStatus::update($key->keyID, $key->vCode);

                // Once the fresh account status lookup is done, call the
                // addToQueue helper to queue a new job.
                //\ineluctable\Services\Queue\QueueHelper::addToQueue('\Seat\EveQueues\Full\Character', $key->keyID, $key->vCode, 'Character', 'Eve');

                EveApi\Character\Info::Update($key->keyID, $key->vCode);

                //queue a job to get all the character info
                $job = new ScheduleUpdateCorporation($key->keyID, $key->vCode);
                $this->dispatch($job);
            }
        }


        $params = '';

        event(new ScheduleUpdateEveCharactersCompleted($this->job->getJobId() , $this->job->getQueue() , static::class, $this->starttime, Carbon::Now(), $params));

    }
}
