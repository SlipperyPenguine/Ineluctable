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

namespace ineluctable\EveApi\Character;

use DB;
use ineluctable\EveApi\BaseApi;
use ineluctable\models\EveCharacterAssetList;
use ineluctable\models\EveCharacterAssetListContents;
use ineluctable\models\EveCharacterAssets;
use Pheal\Pheal;

class AssetList extends BaseApi
{

    public static function Update($keyID, $vCode)
    {

        // Start and validate they key pair
        BaseApi::bootstrap();
        BaseApi::validateKeyPair($keyID, $vCode);

        // Set key scopes and check if the call is banned
        $scope = 'Char';
        $api = 'AssetList';

        if (BaseApi::isBannedCall($api, $scope, $keyID))
            return;

        // Get the characters for this key
        $characters = BaseApi::findKeyCharacters($keyID);

        // Check if this key has any characters associated with it
        if (!$characters)
            return;

        // Lock the call so that we are the only instance of this running now()
        // If it is already locked, just return without doing anything
        if (!BaseApi::isLockedCall($api, $scope, $keyID))
            $lockhash = BaseApi::lockCall($api, $scope, $keyID);
        else
            return;

        // Next, start our loop over the characters and upate the database
        foreach ($characters as $characterID)
        {
            // Prepare the Pheal instance
            $pheal = new Pheal($keyID, $vCode);

            // Do the actual API call. pheal-ng actually handles some internal
            // caching too.
            try {

                $asset_list = $pheal
                    ->charScope
                    ->AssetList(array('characterID' => $characterID));

            } catch (\Pheal\Exceptions\APIException $e) {

                // If we cant get account status information, prevent us from calling
                // this API again
                BaseApi::banCall($api, $scope, $keyID, 0, $e->getCode() . ': ' . $e->getMessage());
                return;

            } catch (\Pheal\Exceptions\PhealException $e) {

                throw $e;
            }

            // Check if the data in the database is still considered up to date.
            // checkDbCache will return true if this is the case
            if (!BaseApi::checkDbCache($scope, $api, $asset_list->cached_until, $characterID))
            {
                $assetarray = array();
                $now = \Carbon\Carbon::now();

                //added by JB for new assets table
                //Have to delete everything and recreate - which is a pain!
                EveCharacterAssets::where('characterID', '=', $characterID)->delete();

                // Populate the assets for this character as well as the contents.
                foreach ($asset_list->assets as $asset)
                {
                    static::processasset($asset, $assetarray, $characterID, $now);
                }

                //commit the data
                $rowsPerChunk = 100;

                $assetChunks = array_chunk($assetarray, $rowsPerChunk);
                foreach($assetChunks as $chunk)
                {

                   // \Log::info($chunk);
                    $result = DB::table('character_assets')->insert($chunk);
                    // \Log::info($result);
                }

                // Update the cached_until time in the database for this api call
                BaseApi::setDbCache($scope, $api, $asset_list->cached_until, $characterID);
            }
        }

        // Unlock the call
        BaseApi::unlockCall($lockhash);

        return $asset_list;
    }

    private static function processasset($asset, &$assetarray, $characterID, $now, $parentItemID=0, $parentLocationID=0)
    {
        $rawQuantity = (isset($asset->rawQuantity) ? $asset->rawQuantity : 0);
        $locationID = (isset($asset->locationID) ? $asset->locationID : $parentLocationID);

        //add to array
        $assetarray[] = array(  'characterID'   => $characterID,
            'itemID'        => $asset->itemID,
            'locationID'    => $locationID,
            'typeID'        => $asset->typeID,
            'quantity'      => $asset->quantity,
            'rawQuantity'   => $rawQuantity,
            'flag'          => $asset->flag,
            'singleton'     => $asset->singleton,
            'parentItemID'  => $parentItemID,
            'created_at'    => $now,
            'updated_at'    => $now
        );

        if (isset($asset->contents))
        {
            foreach ($asset->contents as $content)
            {
                 static::processasset($content, $assetarray, $characterID, $now, $asset->itemID, $locationID);
            }
        }

    }


}
