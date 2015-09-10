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

use Illuminate\Database\Eloquent\Model;

class EveAccountAPIKeyInfoCharacters extends \Eloquent
{

	protected $table = 'account_apikeyinfo_characters';

    public function keyinfo() {

        return $this->belongsTo('ineluctable\models\EveAccountAPIKeyInfo', 'keyID', 'keyID');
    }

    public function key()
    {
        return $this->belongsTo('ineluctable\models\SeatKey', 'keyID', 'keyID' );
    }

    public function characterInfo()
    {
        return $this->hasOne('ineluctable\models\EveEveCharacterInfo', 'characterID', 'characterID' );
    }

    /**
     * searches for all characters that are linked to the logged in user
     */
    public function scopeMyCharacters()
    {

        $characters = EveAccountAPIKeyInfoCharacters::whereHas('key', function($query)
        {
            $query->where('user_id', '=', auth()->user()->id);
        })->whereHas('keyinfo', function($query)
        {
            $query->where('type', '=', 'Account');
        })  ->has('characterInfo')
            ->with('characterInfo')
            ->orderBy('characterName')
            ->get();

        return $characters;
    }

    public static function MyCharactersAsArray()
    {

        $characters = EveAccountAPIKeyInfoCharacters::whereHas('key', function($query)
        {
            $query->where('user_id', '=', auth()->user()->id);
        })->whereHas('keyinfo', function($query)
        {
            $query->where('type', '=', 'Account');
        })
            ->has('characterInfo')
            ->with('characterInfo')->get();

        $characterlist=array();

        //create the where in list
        foreach($characters as $character)
        {
            $characterlist[] = $character->characterID;
        }

        return $characterlist;
    }

    public function scopeMyCorporations()
    {

        $characters = EveAccountAPIKeyInfoCharacters::whereHas('key', function($query)
        {
            $query->where('user_id', '=', auth()->user()->id);
        })->whereHas('keyinfo', function($query)
        {
            $query->where('type', '=', 'Corporation');
        })->get();

        return $characters;
    }
}
