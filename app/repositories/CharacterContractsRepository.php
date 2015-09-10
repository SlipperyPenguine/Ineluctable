<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 16/08/2015
 * Time: 10:01
 */

namespace ineluctable\repositories;

use DB;
use ineluctable\models\EveCharacterContracts;
use ineluctable\models\EveCharacterContractsItems;

class CharacterContractsRepository
{

    public static function GetCharacterCourierContracts($characterID)
    {
        $select = self::GetSelectStatement();

        return EveCharacterContracts::where('character_contracts.characterID', $characterID)
            ->where('character_contracts.type', 'Courier')
            ->with('items.type')
            ->select(DB::raw( $select))
            ->get();
    }

    public static function GetCharacterNonCourierContracts($characterID)
    {
        $select = self::GetSelectStatement();

        return EveCharacterContracts::where('character_contracts.characterID', $characterID)
            ->where('character_contracts.type', '<>', 'Courier')
            ->with('items.type')
            ->select(DB::raw( $select))
            ->get();
    }

    public static function GetCharacterContracts($characterID)
    {
        $select = self::GetSelectStatement();

        return EveCharacterContracts::where('character_contracts.characterID', $characterID)
            ->with('items')
            ->select($select)
            ->get();


/*        return DB::table(DB::raw('character_contracts as a'))
            ->select(DB::raw(
                "*, CASE
                when a.startStationID BETWEEN 66015148 AND 66015151 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.startStationID-6000000)
                when a.startStationID BETWEEN 66000000 AND 66014933 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.startStationID-6000001)
                when a.startStationID BETWEEN 66014934 AND 67999999 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.startStationID-6000000)
                when a.startStationID BETWEEN 60014861 AND 60014928 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.startStationID)
                when a.startStationID BETWEEN 60000000 AND 61000000 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.startStationID)
                when a.startStationID>=61000000 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.startStationID)
                else (SELECT m.itemName FROM mapDenormalize AS m
                    WHERE m.itemID=a.startStationID) end
                AS startlocation,
                CASE
                when a.endstationID BETWEEN 66015148 AND 66015151 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.endStationID-6000000)
                when a.endStationID BETWEEN 66000000 AND 66014933 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.endStationID-6000001)
                when a.endStationID BETWEEN 66014934 AND 67999999 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.endStationID-6000000)
                when a.endStationID BETWEEN 60014861 AND 60014928 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.endStationID)
                when a.endStationID BETWEEN 60000000 AND 61000000 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.endStationID)
                when a.endStationID>=61000000 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.endStationID)
                else (SELECT m.itemName FROM mapDenormalize AS m
                    WHERE m.itemID=a.endStationID) end
                AS endlocation "))
            ->where('a.characterID', $characterID)
            ->get();*/
    }

    public static function GetCharacterContractItems($characterID)
    {
        return EveCharacterContractsItems::where('characterID', $characterID)
            ->with('type')
            ->get();
/*        return DB::table('character_contracts_items')
            ->leftJoin('invTypes', 'character_contracts_items.typeID', '=', 'invTypes.typeID')
            ->where('characterID', $characterID)
            ->get();*/

    }

    private static function GetSelectStatement()
    {
        return '*, CASE
                when character_contracts.startStationID BETWEEN 66015148 AND 66015151 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_contracts.startStationID-6000000)
                when character_contracts.startStationID BETWEEN 66000000 AND 66014933 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_contracts.startStationID-6000001)
                when character_contracts.startStationID BETWEEN 66014934 AND 67999999 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_contracts.startStationID-6000000)
                when character_contracts.startStationID BETWEEN 60014861 AND 60014928 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_contracts.startStationID)
                when character_contracts.startStationID BETWEEN 60000000 AND 61000000 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_contracts.startStationID)
                when character_contracts.startStationID>=61000000 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_contracts.startStationID)
                else (SELECT m.itemName FROM mapDenormalize AS m
                    WHERE m.itemID=character_contracts.startStationID) end
                AS startlocation,
                CASE
                when character_contracts.endstationID BETWEEN 66015148 AND 66015151 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_contracts.endStationID-6000000)
                when character_contracts.endStationID BETWEEN 66000000 AND 66014933 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_contracts.endStationID-6000001)
                when character_contracts.endStationID BETWEEN 66014934 AND 67999999 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_contracts.endStationID-6000000)
                when character_contracts.endStationID BETWEEN 60014861 AND 60014928 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_contracts.endStationID)
                when character_contracts.endStationID BETWEEN 60000000 AND 61000000 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=character_contracts.endStationID)
                when character_contracts.endStationID>=61000000 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=character_contracts.endStationID)
                else (SELECT m.itemName FROM mapDenormalize AS m
                    WHERE m.itemID=character_contracts.endStationID) end
                AS endlocation';
    }
}