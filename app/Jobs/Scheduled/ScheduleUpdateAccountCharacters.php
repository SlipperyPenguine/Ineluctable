<?php

namespace ineluctable\Jobs\Scheduled;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use ineluctable\Jobs\Job;
use ineluctable\Jobs\UpdateAccountCharacters;
use SuperClosure\Serializer;

use ineluctable\Events\JobScheduleUpdateAccountCharactersCompleted;

class ScheduleUpdateAccountCharacters extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    private $keyid;
    private $vcode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($keyid, $vcode)
    {
        $this->keyid = $keyid;
        $this->vcode = $vcode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->JobStarted();

        try
        {
            $job = new UpdateAccountCharacters($this->keyid, $this->vcode);
            $this->dispatch($job);
        }
        catch (\Exception $e)
        {
            \Log::critical($e->getCode() . ':' . $e->getMessage());
        }

        $params = array( 'keyid'=>$this->keyid, 'vcode'=>$this->vcode);
        $params = serialize($params);

        event(new JobScheduleUpdateAccountCharactersCompleted($this->job->getJobId() , $this->job->getQueue() , static::class, $this->starttime, Carbon::Now(), $params));

        //$this->JobFinsishedSuccessFully(static::class, $this->queue, ['keyid'=>$this->keyid, 'vcode'=>$this->vcode]);
    }
}
