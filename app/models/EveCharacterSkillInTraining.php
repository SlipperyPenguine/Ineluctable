<?php
/*
The MIT License (MIT)

Copyright (c) 2014 eve-seat

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
namespace ineluctable\models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EveCharacterSkillInTraining extends \Eloquent
{

    protected $table = 'character_skillintraining';

    protected $dates = ['trainingStartTime', 'trainingEndTime'];

    public function type() {

        return $this->hasOne('ineluctable\models\EveInvTypes','typeID', 'trainingTypeID');
    }

    public static function GetSkillinTraining(array $characterlist)
    {

        return static::whereIn('characterID', $characterlist )->with('type')->get();

    }

    public function getTimeToGoAsTimestamp()
    {
        $enddate = $this->trainingEndTime->getTimestamp();
        $now = Carbon::now()->getTimestamp();

        return $enddate - $now;
    }

    public function getPercentComplete()
    {

        $startdate = $this->trainingStartTime->getTimestamp();
        $enddate = $this->trainingEndTime->getTimestamp();
        $now = Carbon::now()->getTimestamp();

        return round( (($now - $startdate) / ($enddate - $startdate )) * 100 , 0);
    }



}