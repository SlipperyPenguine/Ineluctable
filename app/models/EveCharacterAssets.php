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
Use DB;

class EveCharacterAssets extends \Eloquent
{

    protected $table = 'character_assets';

    public function type()
    {
        return $this->hasOne('ineluctable\models\EveInvTypes', 'typeID', 'typeID');
    }

    public function location()
    {
        return $this->hasOne('ineluctable\models\EveMapDenormalize', 'itemID', 'locationID');
    }

    public function flaginfo()
    {
        return $this->hasOne('ineluctable\models\EveInvFlags', 'flagID', 'flag');
    }

    public static function getAssetLocationsForMyCharacters()
    {
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();
        return  EveCharacterAssets::whereIn('characterID', $characterlist)
            ->select(
                DB::raw('locationID,
                         count(*) as AssetCount,

                        CASE
                          WHEN character_assets.locationID < 60000000 THEN "System"
                          WHEN character_assets.locationID > 61000000 THEN "Conquerable Station"
                          WHEN character_assets.locationID BETWEEN 60000000 AND 61000000 THEN "Station"
                          END as locationType,

                        CASE
                          WHEN character_assets.locationID < 60000000 THEN (select itemName as locationName from mapDenormalize where itemID = character_assets.locationID)
                          WHEN character_assets.locationID > 61000000 THEN (select stationName as locationName from eve_conquerablestationlist where stationID = character_assets.locationID)
                          WHEN character_assets.locationID BETWEEN 60000000 AND 61000000 THEN (select itemName as locationName from mapDenormalize where itemID = character_assets.locationID)
                          END as locationName'))
            ->groupBy('locationID')
            ->orderBy('locationName')
            ->get();
    }

    public static function GetAssetLocationsForCharacter($characterID)
    {
        return EveCharacterAssets::where('characterID', $characterID)
            ->select(
                DB::raw('locationID,
                         count(*) as AssetCount,

                        CASE
                          WHEN character_assets.locationID < 60000000 THEN "System"
                          WHEN character_assets.locationID > 61000000 THEN "Conquerable Station"
                          WHEN character_assets.locationID BETWEEN 60000000 AND 61000000 THEN "Station"
                          END as locationType,

                        CASE
                          WHEN character_assets.locationID < 60000000 THEN (select itemName as locationName from mapDenormalize where itemID = character_assets.locationID)
                          WHEN character_assets.locationID > 61000000 THEN (select stationName as locationName from eve_conquerablestationlist where stationID = character_assets.locationID)
                          WHEN character_assets.locationID BETWEEN 60000000 AND 61000000 THEN (select itemName as locationName from mapDenormalize where itemID = character_assets.locationID)
                          END as locationName'))
            ->groupBy('locationID')
            ->orderBy('locationName')
            ->get();
    }

    public static function GetAssetsByTypeIDForMyCharacters(array $types)
    {
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        $assets = EveCharacterAssets::whereIn('character_assets.characterID', $characterlist)
            ->whereIn('character_assets.typeID', $types)
            ->join('invTypes', 'character_assets.typeID', '=', 'invTypes.typeID' )
            ->join('invGroups', 'invTypes.groupID', '=', 'invGroups.groupID' )
            ->join('invCategories', 'invGroups.categoryID', '=', 'invCategories.categoryID' )
            ->join('invFlags', 'character_assets.flag', '=', 'invFlags.flagID' )
            ->join('character_charactersheet', 'character_assets.characterID', '=', 'character_charactersheet.characterID' )
            ->select(   'character_assets.*',
                'character_charactersheet.name',
                'invTypes.typeName',
                'invGroups.groupName',
                'invCategories.categoryName',
                'invFlags.flagName',
                'invFlags.flagText',
                DB::raw('

                        CASE
                          WHEN character_assets.locationID < 60000000 THEN "System"
                          WHEN character_assets.locationID > 61000000 THEN "Conquerable Station"
                          WHEN character_assets.locationID BETWEEN 60000000 AND 61000000 THEN "Station"
                          END as locationType,

                        CASE
                          WHEN character_assets.locationID < 60000000 THEN (select itemName as locationName from mapDenormalize where itemID = character_assets.locationID)
                          WHEN character_assets.locationID > 61000000 THEN (select stationName as locationName from eve_conquerablestationlist where stationID = character_assets.locationID)
                          WHEN character_assets.locationID BETWEEN 60000000 AND 61000000 THEN (select itemName as locationName from mapDenormalize where itemID = character_assets.locationID)
                          END as locationName'))
            ->orderBy('locationName')
            ->orderBy('flagText')
            ->get();

        $assetarray = static::CreateAssetArray($assets);

        return $assetarray;

    }

    public static function GetAssetsAtALocationForMyCharacters($locationID)
    {
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        return EveCharacterAssets::whereIn('character_assets.characterID', $characterlist)
            ->where('character_assets.locationID', $locationID )
            ->where('character_assets.parentItemID', 0)
            ->join('invTypes', 'character_assets.typeID', '=', 'invTypes.typeID' )
            ->join('invGroups', 'invTypes.groupID', '=', 'invGroups.groupID' )
            ->join('invCategories', 'invGroups.categoryID', '=', 'invCategories.categoryID' )
            ->join('invFlags', 'character_assets.flag', '=', 'invFlags.flagID' )
            ->join('character_charactersheet', 'character_assets.characterID', '=', 'character_charactersheet.characterID' )
            ->select(   'character_assets.*',
                'character_charactersheet.name',
                'invTypes.typeName',
                'invGroups.groupName',
                'invCategories.categoryName',
                'invFlags.flagName',
                'invFlags.flagText',

                DB::raw('(select count(*) from character_assets as cont where cont.parentItemID = character_assets.itemID) as contents '))
            ->orderBy('invCategories.categoryName')
            ->orderBy('invGroups.groupName')
            ->orderBy('invTypes.typeName')
            ->orderBy('invFlags.flagName')
            ->get();
    }

    public static function GetAssetsAtALocationForCharacter($characterID, $locationID)
    {
        return EveCharacterAssets::where('character_assets.characterID', $characterID)
            ->where('character_assets.locationID', $locationID )
            ->where('character_assets.parentItemID', 0)
            ->join('invTypes', 'character_assets.typeID', '=', 'invTypes.typeID' )
            ->join('invGroups', 'invTypes.groupID', '=', 'invGroups.groupID' )
            ->join('invCategories', 'invGroups.categoryID', '=', 'invCategories.categoryID' )
            ->join('invFlags', 'character_assets.flag', '=', 'invFlags.flagID' )
            ->join('character_charactersheet', 'character_assets.characterID', '=', 'character_charactersheet.characterID' )
            ->select(   'character_assets.*',
                'character_charactersheet.name',
                'invTypes.typeName',
                'invGroups.groupID',
                'invGroups.groupName',
                'invCategories.categoryName',
                'invFlags.flagName',
                'invFlags.flagText',

                DB::raw('(select count(*) from character_assets as cont where cont.parentItemID = character_assets.itemID) as contents '))
            ->orderBy('invCategories.categoryName')
            ->orderBy('invGroups.groupName')
            ->orderBy('invTypes.typeName')
            ->orderBy('invFlags.flagName')
            ->get();
    }

    public static function GetAssetsByTypeIDForCharacter($characterID, array $types)
    {
        $assets = EveCharacterAssets::where('character_assets.characterID', $characterID)
            ->whereIn('character_assets.typeID', $types)
            ->join('invTypes', 'character_assets.typeID', '=', 'invTypes.typeID' )
            ->join('invGroups', 'invTypes.groupID', '=', 'invGroups.groupID' )
            ->join('invCategories', 'invGroups.categoryID', '=', 'invCategories.categoryID' )
            ->join('invFlags', 'character_assets.flag', '=', 'invFlags.flagID' )
            ->join('character_charactersheet', 'character_assets.characterID', '=', 'character_charactersheet.characterID' )
            ->select(   'character_assets.*',
                'character_charactersheet.name',
                'invTypes.typeName',
                'invGroups.groupName',
                'invCategories.categoryName',
                'invFlags.flagName',
                'invFlags.flagText',
                DB::raw('

                        CASE
                          WHEN character_assets.locationID < 60000000 THEN "System"
                          WHEN character_assets.locationID > 61000000 THEN "Conquerable Station"
                          WHEN character_assets.locationID BETWEEN 60000000 AND 61000000 THEN "Station"
                          END as locationType,

                        CASE
                          WHEN character_assets.locationID < 60000000 THEN (select itemName as locationName from mapDenormalize where itemID = character_assets.locationID)
                          WHEN character_assets.locationID > 61000000 THEN (select stationName as locationName from eve_conquerablestationlist where stationID = character_assets.locationID)
                          WHEN character_assets.locationID BETWEEN 60000000 AND 61000000 THEN (select itemName as locationName from mapDenormalize where itemID = character_assets.locationID)
                          END as locationName'))
            ->orderBy('locationName')
            ->orderBy('flagText')
            ->get();

        $assetarray = static::CreateAssetArray($assets);

        return $assetarray;
    }

    public static function GetAssetContents($AssetID)
    {
        return EveCharacterAssets::where('character_assets.parentItemID', $AssetID)
            ->join('invTypes', 'character_assets.typeID', '=', 'invTypes.typeID' )
            ->join('invGroups', 'invTypes.groupID', '=', 'invGroups.groupID' )
            ->join('invCategories', 'invGroups.categoryID', '=', 'invCategories.categoryID' )
            ->join('invFlags', 'character_assets.flag', '=', 'invFlags.flagID' )
            ->join('character_charactersheet', 'character_assets.characterID', '=', 'character_charactersheet.characterID' )
            ->select(   'character_assets.*',
                'character_charactersheet.name',
                'invTypes.typeName',
                'invGroups.groupName',
                'invCategories.categoryName',
                'invFlags.flagName',
                'invFlags.flagText',

                DB::raw('(select count(*) from character_assets as cont where cont.parentItemID = character_assets.itemID) as contents '))

            ->orderBy('invFlags.flagName')
            ->get();
    }


    private static function CreateAssetArray($assets)
    {
        $assetarray = array();
        $stack = array();

        //new way of doing this
        foreach($assets as $asset)
        {
            //add new asset to bottom of stach
            $stack[] = $asset;
            $ItemsToPop = 1;
            $currentasset = $asset;
            $postioninstack = count($stack)-1;

            //loop through to geting the parents
            while($currentasset->parentItemID > 0)
            {
                //check if the stack contains parents yet
                if( ($postioninstack>0) && (count($stack) > 1) )
                {
                    //check if item above is the stack is the correct parent
                    if( $stack[$postioninstack-1]->itemID == $currentasset->parentItemID)
                    {
                        //parent already there so brek out of while loop - set the currentasset to top of stack that we know is parent=0
                        $currentasset = $stack[0];
                        continue;
                    }
                }

                $currentasset = EveCharacterAssets::where('character_assets.itemID', $currentasset->parentItemID)
                    ->join('invTypes', 'character_assets.typeID', '=', 'invTypes.typeID' )
                    ->join('invGroups', 'invTypes.groupID', '=', 'invGroups.groupID' )
                    ->join('invCategories', 'invGroups.categoryID', '=', 'invCategories.categoryID' )
                    ->join('invFlags', 'character_assets.flag', '=', 'invFlags.flagID' )
                    ->select(   'character_assets.*',
                        DB::raw('"'.$currentasset->name.'" as name' ),
                        'invTypes.typeName',
                        'invGroups.groupName',
                        'invCategories.categoryName',
                        'invFlags.flagName',
                        'invFlags.flagText',
                        DB::raw('"'.$currentasset->locationType.'" as locationType' ),
                        DB::raw('"'.$currentasset->locationName.'" as locationName' )
                    )
                    ->first();

                if($postioninstack>0)
                {
                    //replace parent with new parent
                    array_splice($stack, $postioninstack-1,1, array($currentasset) );
                }
                else
                {
                    //add to top of stack
                    array_splice($stack, 0,0, array($currentasset) );
                }

                $ItemsToPop++;
                $postioninstack--;

            }

            //check for extra stray parents that need removing
            while((count($stack)>1) && ($stack[1]->parentItemID == 0))
            {
                unset($stack[0]);
                $stack = array_values($stack);
            }

            $endstackindex = count($stack)-1;
            $startstackindex = count($stack)-$ItemsToPop;

            //add items to array
            for ($i = $startstackindex; $i <= $endstackindex; $i++) {
                $assetarray[] = $stack[$i];
            }

            //remove last item from stack
            $last = array_pop($stack);

        }

        return $assetarray;
    }


}
