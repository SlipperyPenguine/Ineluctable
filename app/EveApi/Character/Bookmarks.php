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

use ineluctable\EveApi\BaseApi;
use ineluctable\models\EveCharacterBookmarks;
use Pheal\Exceptions\APIException;
use Pheal\Exceptions\PhealException;
use Pheal\Pheal;

class Bookmarks extends BaseApi
{

    public static function Update($keyID, $vCode)
    {

        // To start processing this API Updater, lets take a moment and
        // examine a sample XML for a Bookmark (taken 2014-12-04 15:24:40):


        //<rowset name="folders" key="folderID" columns="folderName">
        //<row folderID="0" folderName="">
        //<rowset name="bookmarks" key="bookmarkID" columns="creatorID,created,itemID,typeID,locationID,x,y,z,memo,note">
        //<row bookmarkID="371081938" creatorID="0" created="2006-12-31 06:12:00" itemID="0" typeID="5" locationID="30002761" x="-458718403197.855" y="-92351478446.5049" z="1306682602006.23" memo="ss" note=""/>
        //<row bookmarkID="371081990" creatorID="0" created="2006-12-31 06:13:00" itemID="0" typeID="5" locationID="30002762" x="1505468153255.1" y="-162812814561.755" z="986924680559.195" memo="ss" note=""/>
        //<row bookmarkID="371082034" creatorID="0" created="2006-12-31 06:14:00" itemID="0" typeID="5" locationID="30002763" x="1232537095869.49" y="-2300587562786.13" z="-1479274312896.34" memo="ss" note=""/>
        //<row bookmarkID="371176502" creatorID="0" created="2007-01-01 18:22:00" itemID="0" typeID="5" locationID="30002764" x="-565794613741.996" y="38716993024.8367" z="1319363049314.45" memo="ss" note=""/>

        // Based on the above, we can see we have 2 sections that need to be kept up to date Folders and bookmarks
        // as it will be hard tp tell what has been deleted and not it's probably easiest just to delete all bookmarks and reinsert - hopefully not too slow!

        // Start and validate they key pair
        BaseApi::bootstrap();
        BaseApi::validateKeyPair($keyID, $vCode);

        // Set key scopes and check if the call is banned
        $scope = 'Char';
        $api = 'Bookmarks';

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
        foreach ($characters as $characterID) {

            // Prepare the Pheal instance
            $pheal = new Pheal($keyID, $vCode);

            // Do the actual API call. pheal-ng actually handles some internal
            // caching too.
            try {

                $bookmarks = $pheal
                    ->charScope
                    ->Bookmarks(array('characterID' => $characterID));

            } catch (APIException $e) {

                // If we cant get account status information, prevent us from calling
                // this API again
                BaseApi::banCall($api, $scope, $keyID, 0, $e->getCode() . ': ' . $e->getMessage());
                return;

            } catch (PhealException $e) {

                throw $e;
            }

            // Check if the data in the database is still considered up to date.
            // checkDbCache will return true if this is the case
            if (!BaseApi::checkDbCache($scope, $api, $bookmarks->cached_until, $characterID)) {


                //delete the existing records
                EveCharacterBookmarks::where('characterID', '=', $characterID)->delete();

                // Populate the assets for this character as well as the contents.
                foreach ($bookmarks->folders as $folder) {

                    //don't add folders, just include in the bookmarks

                    // Process the contents if there are any
                    if (isset($folder->bookmarks)) {

                        foreach ($folder->bookmarks as $bookmark) {

                          //added by JB
                            $newcontent_data = new EveCharacterBookmarks;

                            $newcontent_data->characterID = $characterID;
                            $newcontent_data->folderID = $folder->folderID;
                            $newcontent_data->folderName = $folder->folderName;
                            $newcontent_data->bookmarkID = $bookmark->bookmarkID;
                            $newcontent_data->creatorID = $bookmark->creatorID;
                            $newcontent_data->created = $bookmark->created;
                            $newcontent_data->itemID = $bookmark->itemID;
                            $newcontent_data->typeID = $bookmark->typeID;
                            $newcontent_data->locationID = $bookmark->locationID;
                            $newcontent_data->x = $bookmark->x;
                            $newcontent_data->y = $bookmark->y;
                            $newcontent_data->z = $bookmark->z;
                            $newcontent_data->memo = $bookmark->memo;
                            $newcontent_data->note = $bookmark->note;


                            $newcontent_data->save();



                        }
                    }
                }

                // Update the cached_until time in the database for this api call
                BaseApi::setDbCache($scope, $api, $bookmarks->cached_until, $characterID);
            }
        }

        // Unlock the call
        BaseApi::unlockCall($lockhash);

        return $bookmarks;
    }
}

