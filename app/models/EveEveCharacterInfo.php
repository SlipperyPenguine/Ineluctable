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
use ineluctable\EveApi\Eve\CharacterInfo;

class EveEveCharacterInfo extends \Eloquent
{

    protected $table = 'eve_characterinfo';

    public function employment() {

        return $this->hasMany('ineluctable\models\EveEveCharacterInfoEmploymentHistory', 'characterID', 'characterID');
    }

    public function solarsystem()
    {
        return $this->hasOne('ineluctable\models\EveSolarSystem', 'itemName', 'lastKnownLocation');
    }

    public static function GetCharacterInfoIncludingSolarSystem(array $characterlist)
    {
        return static::whereIn('characterID', $characterlist )->with('solarsystem')->get();
    }

/*    public function getRegion()
    {
        return $this->solarsystem->region()->first();
    }*/

    public static function getCharacter($characterID, $alwayscallapi=false)
    {

        if(!$alwayscallapi) {
            $character = static::where('characterID', $characterID )->first();

            if($character)
            {
                return $character;
            }
        }

        //call API and store data
        $char = CharacterInfo::Update($characterID);

        //now get the record
        $character = static::where('characterID', $characterID )->first();
        return $character;
    }


}
