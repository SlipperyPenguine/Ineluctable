<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 16/08/2015
 * Time: 10:01
 */

namespace ineluctable\repositories;

use Carbon\Carbon;
use DB;
use ineluctable\models\EveCharacterCharacterSheetImplants;
use ineluctable\models\EveCharacterCharacterSheetSkills;
use ineluctable\models\EveCharacterSkillQueue;
use ineluctable\models\EveEveCharacterInfo;
use ineluctable\models\EveEveCharacterInfoEmploymentHistory;

class CharacterRepository
{

   public static function getApiKeyInfoCharacterPlusDetails($characterID)
   {
       return DB::table('account_apikeyinfo_characters')
           ->leftJoin('account_apikeyinfo', 'account_apikeyinfo_characters.keyID', '=', 'account_apikeyinfo.keyID')
           ->leftJoin('seat_keys', 'account_apikeyinfo_characters.keyID', '=', 'seat_keys.keyID')
           ->join('account_accountstatus', 'account_apikeyinfo_characters.keyID', '=', 'account_accountstatus.keyID')
           ->join('character_charactersheet', 'account_apikeyinfo_characters.characterID', '=', 'character_charactersheet.characterID')
           ->join('character_skillintraining', 'account_apikeyinfo_characters.characterID', '=', 'character_skillintraining.characterID')
           ->leftJoin('invTypes', 'character_skillintraining.trainingTypeID', '=', 'invTypes.typeID')
           ->where('character_charactersheet.characterID', $characterID)
           ->first();
   }

    public static function getEveCharacterInfo($characterID)
    {
        return EveEveCharacterInfo::where('characterID', $characterID)->first();

    }

    public static function getEmploymentHistory($characterID)
    {
        return EveEveCharacterInfoEmploymentHistory::where('characterID', $characterID)
            -> orderBy('startDate','desc')
            ->get();
    }

    public static function getTotalSkillPoints($characterID)
    {
        return EveCharacterCharacterSheetSkills::where('characterID', $characterID)
            ->sum('skillpoints');
    }

    public static function getSkillQueue($characterID)
    {
        return EveCharacterSkillQueue::where('characterID', $characterID)
            ->orderBy('queuePosition')
            ->with('skilltype')
            ->get();
    }

    public static function getImplants($characterID)
    {
        return EveCharacterCharacterSheetImplants::where('characterID', $characterID)
            ->get();
    }

    public static function getJumpClones($characterID)
    {
        return DB::table(DB::raw('character_charactersheet_jumpclones as a'))
            ->select(DB::raw("
                *, CASE
                when a.locationID BETWEEN 66015148 AND 66015151 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.locationID-6000000)
                when a.locationID BETWEEN 66000000 AND 66014933 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.locationID-6000001)
                when a.locationID BETWEEN 66014934 AND 67999999 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.locationID-6000000)
                when a.locationID BETWEEN 60014861 AND 60014928 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.locationID)
                when a.locationID BETWEEN 60000000 AND 61000000 then
                    (SELECT s.stationName FROM staStations AS s
                      WHERE s.stationID=a.locationID)
                when a.locationID>=61000000 then
                    (SELECT c.stationName FROM `eve_conquerablestationlist` AS c
                      WHERE c.stationID=a.locationID)
                else (SELECT m.itemName FROM mapDenormalize AS m
                    WHERE m.itemID=a.locationID) end
                    AS location,a.locationId AS locID"))
            ->join('invTypes', 'a.typeID', '=', 'invTypes.typeID')
            ->where('a.characterID', $characterID)
            ->get();
    }
}