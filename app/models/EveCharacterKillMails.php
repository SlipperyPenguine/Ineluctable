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
use DB;
use Illuminate\Database\Eloquent\Model;

class EveCharacterKillMails extends \Eloquent
{

    protected $table = 'character_killmails';

    public function detail()
    {
        return $this->hasOne('ineluctable\models\EveCharacterKillMailDetail', 'killID', 'killID');
    }

    public function scopeForCharacter($query, $characterID)
    {
        return $query->select(DB::raw('*, `mapDenormalize`.`itemName` AS solarSystemName'))
            ->leftJoin('character_killmail_detail', 'character_killmails.killID', '=', 'character_killmail_detail.killID')
            ->leftJoin('invTypes', 'character_killmail_detail.shipTypeID', '=', 'invTypes.typeID')
            ->leftJoin('mapDenormalize', 'character_killmail_detail.solarSystemID', '=', 'mapDenormalize.itemID')
            ->where('character_killmails.characterID', $characterID)
            ->orderBy('character_killmail_detail.killTime', 'desc');
    }
}
