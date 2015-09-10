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
use ineluctable\models\EveCharacterNotifications;
use ineluctable\models\EveCharacterNotificationTexts;
use Pheal\Exceptions\APIException;
use Pheal\Exceptions\PhealException;
use Pheal\Pheal;

class Notifications extends BaseApi
{

    public static function Update($keyID, $vCode)
    {

        // Start and validate they key pair
        BaseApi::bootstrap();
        BaseApi::validateKeyPair($keyID, $vCode);

        // Set key scopes and check if the call is banned
        $scope = 'Char';
        $api = 'Notifications';

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

                $notifications = $pheal
                    ->charScope
                    ->Notifications(array('characterID' => $characterID));

            }
            catch (APIException $e) {

                // If we cant get account status information, prevent us from calling
                // this API again
                BaseApi::banCall($api, $scope, $keyID, 0, $e->getCode() . ': ' . $e->getMessage());
                return;

            }
            catch (PhealException $e) {

                throw $e;
            }

            // Check if the data in the database is still considered up to date.
            // checkDbCache will return true if this is the case
            if (!BaseApi::checkDbCache($scope, $api, $notifications->cached_until, $characterID))
            {

                // Loop over the list we got from the api and update the db,
                // remebering the messageID's for downloading the bodies too
                //$texts = array();
                foreach ($notifications->notifications as $notification)
                {

                    $notification_data = EveCharacterNotifications::where('characterID', '=', $characterID)
                        ->where('notificationID', '=', $notification->notificationID)
                        ->first();

                    if (!$notification_data) {

                        $notification_data = new EveCharacterNotifications;
                        //$texts[] = $notification->notificationID; // Record the notificationID to download later
                    }

                    $notification_data->characterID = $characterID;
                    $notification_data->notificationID = $notification->notificationID;
                    $notification_data->typeID = $notification->typeID;
                    $notification_data->senderID = $notification->senderID;
                    $notification_data->senderName = $notification->senderName;
                    $notification_data->sentDate = $notification->sentDate;
                    $notification_data->read = $notification->read;
                    $notification_data->save();


                    $notificationtext = EveCharacterNotificationTexts::where('notificationID', '=', $notification->notificationID)->first();
                    if (!$notificationtext) {
                        try {
                            //text not stored, go get from the database
                            $notification_api_text = $pheal
                                ->charScope
                                ->NotificationTexts(array('characterID' => $characterID, 'ids' => $notification->notificationID));

                        } catch (PhealException $e) {

                            \Log::critical($e->getMessage());
                        }

                        $apitext = reset($notification_api_text->notifications);

                        $notificationtext = new EveCharacterNotificationTexts();
                        $notificationtext->notificationID = $notification->notificationID;
                        $notificationtext->text = $apitext->__toString();
                        $notificationtext->save();
                    }
                }

                // Update the cached_until time in the database for this api call
                BaseApi::setDbCache($scope, $api, $notifications->cached_until, $characterID);
            }

        }

        // Unlock the call
        BaseApi::unlockCall($lockhash);

        return true;

    }

}
