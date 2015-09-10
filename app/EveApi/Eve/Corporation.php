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

namespace ineluctable\EveApi\Eve;

use Exception;
use ineluctable\EveApi\BaseApi;
//use ineluctable\models\EveEveAllianceList;
//use ineluctable\models\EveEveAllianceListMemberCorporations;

use ineluctable\models\EveCorporations;

use Pheal\Pheal;

class Corporation extends BaseApi
{

    public static function Update($corporationID)
    {
        BaseApi::bootstrap();

        $scope = 'Corp';
        $api = 'CorporationSheet';

        // Prepare the Pheal instance
        $pheal = new Pheal();

        // Do the actual API call. pheal-ng actually handles some internal
        // caching too.
        try {

            $corporation = $pheal
                ->corpScope
                ->CorporationSheet(array('corporationID' => $corporationID));

        } catch (Exception $e) {

            throw $e;
        }

        // Check if the data in the database is still considered up to date.
        // checkDbCache will return true if this is the case
        if (!BaseApi::checkDbCache($scope, $api, $corporation->cached_until)) {

            // Really crappy method to do this I guess. But oh well.
            //JB replaced with the array approach
            //EveEveAllianceListMemberCorporations::truncate();

            if ($corporation) {

                $corp_check = EveCorporations::where('corporationID', '=', $corporation->corporationID)->first();

                if (!$corp_check)
                    $corp_data = new EveCorporations;
                else
                {
                    $corp_data = $corp_check;
                  }

                $corp_data->corporationID = $corporation->corporationID;
                $corp_data->corporationName = $corporation->corporationName;
                $corp_data->ticker = $corporation->ticker;
                $corp_data->ceoID = $corporation->ceoID;
                $corp_data->ceoName = $corporation->ceoName;
                $corp_data->stationID = $corporation->stationID;
                $corp_data->stationName = $corporation->stationName;
                $corp_data->description = $corporation->description;
                $corp_data->url = $corporation->url;
                $corp_data->allianceID = $corporation->allianceID;
                $corp_data->allianceName = $corporation->allianceName;
                $corp_data->taxRate = $corporation->taxRate;
                $corp_data->memberCount = $corporation->memberCount;

                $corp_data->save();
          }

            // Set the cached entry time
            BaseApi::setDbCache($scope, $api, $corporation->cached_until);
        }

        return $corporation;
    }
}
