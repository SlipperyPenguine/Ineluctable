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
use ineluctable\models\EveCharacterMailBodies;
use ineluctable\models\EveCharacterMailMessages;
use ineluctable\models\EveCharacterMailRecipients;
use Pheal\Exceptions\APIException;
use Pheal\Exceptions\PhealException;
use Pheal\Pheal;

class MailMessages extends BaseApi
{

    public static function Update($keyID, $vCode)
    {

        // Start and validate they key pair
        BaseApi::bootstrap();
        BaseApi::validateKeyPair($keyID, $vCode);

        // Set key scopes and check if the call is banned
        $scope = 'Char';
        $api = 'MailMessages';

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

                $mail_messages = $pheal
                    ->charScope
                    ->MailMessages(array('characterID' => $characterID));

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
            if (!BaseApi::checkDbCache($scope, $api, $mail_messages->cached_until, $characterID)) {

                // Loop over the list we got from the api and update the db,
                // remebering the messageID's for downloading the bodies too
                $bodies = array();
                foreach ($mail_messages->messages as $message) {

/*                    $mail_body_data = EveCharacterMailMessages::where('characterID', '=', $characterID)
                        ->where('messageID', '=', $message->messageID)
                        ->first();*/

                    //first check if we have the message at all
                    $mailheader = EveCharacterMailMessages::where('messageID', '=', $message->messageID)
                        ->first();

                    //if we don't have the message then create it and record we need to get the body of the message
                    if (!$mailheader) {

                        $mailheader = new EveCharacterMailMessages;
                        $bodies[] = $message->messageID; // Record the messagID to download later


                        $mailheader->messageID = $message->messageID;
                        $mailheader->senderID = $message->senderID;
                        $mailheader->senderName = $message->senderName;
                        $mailheader->sentDate = $message->sentDate;
                        $mailheader->title = $message->title;
                        $mailheader->toCorpOrAllianceID = (strlen($message->toCorpOrAllianceID) > 0 ? $message->toCorpOrAllianceID : null);
                        $mailheader->toCharacterIDs = (strlen($message->toCharacterIDs) > 0 ? $message->toCharacterIDs : null);
                        $mailheader->toListID = (strlen($message->toListID) > 0 ? $message->toListID : null);
                        $mailheader->save();

                    }


                   // Check if we have the body for this existing message, else
                    // we will add it to the list to download
                    $mailbody = EveCharacterMailBodies::where('messageID', '=', $message->messageID)->first();

                    if (!$mailbody)
                    {
                        try {

                            $mail_bodies = $pheal
                                ->charScope
                                ->MailBodies(array('characterID' => $characterID, 'ids' => $message->messageID));

                        } catch (PhealException $e) {

                            \Log::critical($e->getMessage());
                        }
                        $body = reset($mail_bodies->messages);
                        $mailbody = new EveCharacterMailBodies;
                        $mailbody->messageID = $message->messageID;
                        $mailbody->body = $body->__toString();
                        $mailbody->save();

                    }

                    //check if recipient already exists
                    $mailrecipient = $mailheader->recipients->where('characterID', $characterID)->first();

                    if (!$mailrecipient)
                    {
                        //recipient doesn't exist so create it
                        $mailrecipient = new EveCharacterMailRecipients();

                        $mailrecipient->characterID = $characterID;

                        $mailheader->recipients()->save($mailrecipient);
                    }
                }

                // Split the bodies we need to download into chunks of 10 each. Pheal-NG will
                // log the whole request as a file name for chaching...
                // which is tooooooo looooooooooooong
                //$bodies = array_chunk($bodies, 10);

                // Iterate over the chunks.
                //this fails so lets just get each one individually till we find a better solution!
/*                foreach ($bodies as $chunk) {

                    try {

                        $mail_bodies = $pheal
                            ->charScope
                            ->MailBodies(array('characterID' => $characterID, 'ids' => implode(',', $chunk)));

                    } catch (PhealException $e) {

                        throw $e;
                    }

                    // Loop over the received bodies
                    foreach ($mail_bodies->messages as $body) {

                        // Actually, this check is pretty redundant, so maybe remove it
                        $body_data = EveCharacterMailBodies::where('messageID', '=', $body->messageID)->first();

                        if (!$body_data)
                            $new_body = new EveCharacterMailBodies;
                        else
                            continue;

                        $new_body->messageID = $body->messageID;
                        $new_body->body = $body->__toString();
                        $new_body->save();
                    }
                }*/

                // Update the cached_until time in the database for this api call
                BaseApi::setDbCache($scope, $api, $mail_messages->cached_until, $characterID);
            }
        }

        // Unlock the call
        BaseApi::unlockCall($lockhash);

        return $mail_messages;
    }
}
