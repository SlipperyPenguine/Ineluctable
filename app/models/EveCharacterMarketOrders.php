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

class EveCharacterMarketOrders extends \Eloquent
{

    protected $table = 'character_marketorders';

    public function scopeForCharacter($query, $characterID)
    {
        $selectstatement = self::getSelect();

        return $query->where('character_marketorders.characterID', $characterID)
                        ->select(DB::raw($selectstatement))
                        ->join('invTypes', 'character_marketorders.typeID', '=', 'invTypes.typeID')
                        ->join('invGroups', 'invTypes.groupID', '=', 'invGroups.groupID')
                        ->orderBy('character_marketorders.issued', 'DESC');
    }

    public static function getOrderStates()
    {
        // Order states from: https://neweden-dev.com/Character/Market_Orders
        // Valid states: 0 = open/active, 1 = closed, 2 = expired (or fulfilled), 3 = cancelled, 4 = pending, 5 = character deleted.
        return array(
            '0' => 'Active',
            '1' => 'Closed',
            '2' => 'Expired / Fulfilled',
            '3' => 'Cancelled',
            '4' => 'Pending',
            '5' => 'Deleted'
        );
    }


    private static function getSelect()
    {
        return "*, CASE
                when character_marketorders.stationID BETWEEN 66015148 AND 66015151 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_marketorders.stationID-6000000)
                when character_marketorders.stationID BETWEEN 66000000 AND 66014933 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_marketorders.stationID-6000001)
                when character_marketorders.stationID BETWEEN 66014934 AND 67999999 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_marketorders.stationID-6000000)
                when character_marketorders.stationID BETWEEN 60014861 AND 60014928 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_marketorders.stationID)
                when character_marketorders.stationID BETWEEN 60000000 AND 61000000 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_marketorders.stationID)
                when character_marketorders.stationID>=61000000 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_marketorders.stationID)
                else (SELECT m.itemName FROM mapDenormalize AS m
                    WHERE m.itemID=character_marketorders.stationID) end
                    AS location,character_marketorders.stationID AS locID";
    }
}
