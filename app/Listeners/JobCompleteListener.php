<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 14/08/2015
 * Time: 00:35
 */

namespace ineluctable\Listeners;


use ineluctable\Events\JobScheduleUpdateAccountCharactersCompleted;
use ineluctable\Events\ScheduleUpdateCorporationCompleted;
use ineluctable\Events\ScheduleUpdateEveCharactersCompleted;
use ineluctable\Events\ScheduleUpdateEveDataCompleted;
use ineluctable\Events\ScheduleUpdateEveMapCompleted;
use ineluctable\Events\ScheduleUpdateEveServerCompleted;
use ineluctable\models\CompletedJobs;
use ineluctable\Events\JobCompletedEvent;

class JobCompleteListener
{
    protected function Store(JobCompletedEvent $completedEvent)
    {
        $completedjob = new CompletedJobs();
        $completedjob->jobid = $completedEvent->jobid;
        $completedjob->queue = $completedEvent->queue;
        $completedjob->command = $completedEvent->command;
        $completedjob->started = $completedEvent->started;
        $completedjob->ended = $completedEvent->ended;
        $completedjob->duration = $completedEvent->ended->getTimestamp() - $completedEvent->started->getTimestamp();

        $completedjob->params = $completedEvent->params;
        $completedjob->save();

    }

    public function LogJobScheduleUpdateAccountCharactersCompleted(JobScheduleUpdateAccountCharactersCompleted $event)
    {
        $this->Store($event);
    }

    public function LogScheduleUpdateEveServerCompleted(ScheduleUpdateEveServerCompleted $event)
    {
        $this->Store($event);
    }

    public function LogScheduleUpdateEveMapCompleted(ScheduleUpdateEveMapCompleted $event)
    {
        $this->Store($event);
    }

    public function LogScheduleUpdateEveDataCompleted(ScheduleUpdateEveDataCompleted $event)
    {
        $this->Store($event);
    }

    public function LogScheduleUpdateEveCharactersCompleted(ScheduleUpdateEveCharactersCompleted $event)
    {
        $this->Store($event);
    }


    public function LogScheduleUpdateCorporationCompleted(ScheduleUpdateCorporationCompleted $event)
    {
        $this->Store($event);
    }

    //LogScheduleUpdateCorporationCompleted

}