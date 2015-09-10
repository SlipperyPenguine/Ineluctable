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

class EveCharacterPlanetaryPins extends \Eloquent
{

    protected $table = 'character_planetary_pins';
    
    public function scopeRoutesForCharacter($query, $characterID)
    {
        return $query->join('character_planetary_routes as route', 'character_planetary_pins.pinID', '=', 'route.sourcePinID')
            ->join('character_planetary_pins as destination', 'destination.PinID', '=', 'route.destinationPinID')
            ->where('character_planetary_pins.characterID', $characterID)
            ->select(
                'character_planetary_pins.planetID', 'character_planetary_pins.typeName as sourceTypeName', 'character_planetary_pins.typeID as sourceTypeID',
                'character_planetary_pins.cycleTime', 'character_planetary_pins.quantityPerCycle', 'character_planetary_pins.installTime', 'character_planetary_pins.expiryTime',
                'route.contentTypeID', 'route.contentTypeName', 'route.quantity',
                'destination.typeName as destinationTypeName', 'destination.typeID as destinationTypeID'
            );
    }
    
    public function scopeForCharacter($query, $characterID)
    {
        return $query->join('character_planetary_links as link', 'link.sourcePinID', '=', 'character_planetary_pins.pinID')
            ->join('character_planetary_pins as destination', 'link.destinationPinID', '=', 'destination.pinID')
            ->where('character_planetary_pins.characterID', $characterID)
            ->select(
                'character_planetary_pins.planetID', 'character_planetary_pins.typeName as sourceTypeName', 'character_planetary_pins.typeID as sourceTypeID',
                'link.linkLevel', 'destination.typeName as destinationTypeName',
                'destination.typeID as destinationTypeID'
            );
    }

    public function scopeInstallationsForCharacter($query, $characterID)
    {
        return $query->where('character_planetary_pins.characterID', $characterID)
            ->where('cycleTime', '=', '0')
            ->where('schematicID', '=', '0');
    }
}
