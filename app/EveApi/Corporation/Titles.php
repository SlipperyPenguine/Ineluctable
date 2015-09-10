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

namespace ineluctable\EveApi\Corporation;

use ineluctable\EveApi\BaseApi;
use ineluctable\models\EveCorporationTitlemap;
use Pheal\Pheal;

class Titles extends BaseApi
{

    static function getRolesFromRolegroup($rolegroup)
    {
        $roles = array();
        if(count($rolegroup) > 0) {
            foreach($rolegroup as $role) {
                array_push($roles, $role->roleID);
            }
        }
        return json_encode($roles);
    }

    public static function Update($keyID, $vCode)
    {

        // Start and validate they key pair
        BaseApi::bootstrap();
        BaseApi::validateKeyPair($keyID, $vCode);

        // Set key scopes and check if the call is banned
        $scope = 'Corp';
        $api = 'Titles';


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

        // So I think a corporation key will only ever have one character
        // attached to it. So we will just use that characterID for auth
        // things, but the corporationID for locking etc.
        $corporationID = BaseApi::findCharacterCorporation($characters[0]);

        // Prepare the Pheal instance
        $pheal = new Pheal($keyID, $vCode);

        // Do the actual API call. pheal-ng actually handles some internal
        // caching too.
        try {

            $title_list = $pheal
                ->corpScope
                ->Titles(array('characterID' => $characters[0]));

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
        if (!BaseApi::checkDbCache($scope, $api, $title_list->cached_until, $corporationID)) {

            foreach ($title_list->titles as $title) {

                $title_data = EveCorporationTitlemap::where('corporationID', '=', $corporationID)
                    ->where('titleID', '=', $title->titleID)
                    ->first();

                if (!$title_data)
                    $title_info = new EveCorporationTitlemap;
                else
                    $title_info = $title_data;

                $title_info->corporationID         = $corporationID;
                $title_info->titleID               = $title->titleID;
                $title_info->titleName             = $title->titleName;
                $title_info->roles                 = Titles::getRolesFromRolegroup($title->roles);
                $title_info->grantableRoles        = Titles::getRolesFromRolegroup($title->grantableRoles);
                $title_info->rolesAtHQ             = Titles::getRolesFromRolegroup($title->rolesAtHQ);
                $title_info->grantableRolesAtHQ    = Titles::getRolesFromRolegroup($title->grantableRolesAtHQ);
                $title_info->rolesAtBase           = Titles::getRolesFromRolegroup($title->rolesAtBase);
                $title_info->grantableRolesAtBase  = Titles::getRolesFromRolegroup($title->grantableRolesAtBase);
                $title_info->rolesAtOther          = Titles::getRolesFromRolegroup($title->rolesAtOther);
                $title_info->grantableRolesAtOther = Titles::getRolesFromRolegroup($title->grantableRolesAtOther);
                $title_info->save();

            }

            // Update the cached_until time in the database for this api call
            BaseApi::setDbCache($scope, $api, $title_list->cached_until, $corporationID);
        }

        // Unlock the call
        BaseApi::unlockCall($lockhash);

        return $title_list;
    }
}
