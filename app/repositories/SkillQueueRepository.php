<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 16/08/2015
 * Time: 10:01
 */

namespace ineluctable\repositories;

use Carbon\Carbon;
use ineluctable\models\EveCharacterSkillQueue;

class SkillQueueRepository
{

    protected $skillqueue;

    public function __construct(array $characterlist)
    {
        $this->skillqueue = EveCharacterSkillQueue::whereIn('characterID', $characterlist )->orderBy('queuePosition')->get();
    }

    public function GetCharacterSkillQueue($characterID)
    {
        return $this->skillqueue->where('characterID', $characterID);
    }

    public function GetEndDate($characterID)
    {
        return $this->skillqueue->where('characterID', $characterID)->last()->endTime;
    }

    public function GetPercentComplete($characterID)
    {
        $now = Carbon::now()->getTimestamp();
        $startdate = $this->skillqueue->where('characterID', $characterID)->first()->startTime->getTimestamp();
        $enddate = $this->skillqueue->where('characterID', $characterID)->last()->endTime->getTimestamp();

        return  round( (($now - $startdate)/ ($enddate - $startdate )) * 100 , 0);

    }

    public function GetTimeToGo($characterID)
    {
        $now = Carbon::now()->getTimestamp();
        $enddate = $this->skillqueue->where('characterID', $characterID)->last()->endTime->getTimestamp();

        return  $enddate - $now;

    }

}