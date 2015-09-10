<?php

namespace ineluctable\Http\Controllers;

use Illuminate\Http\Request;

use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;
use ineluctable\models\EveAccountAPIKeyInfoCharacters;
use ineluctable\models\EveCharacterAssets;
use ineluctable\models\EveInvTypes;
use DB;

class AssetController extends Controller
{
    public function SearchAllAssets()
    {
        //get the top level - a list of locations where the user has assets
       $locations = EveCharacterAssets::getAssetLocationsForMyCharacters();
        return view('dashboard.assets.SearchAllAssets', compact('locations'));
    }

    public function PostSearchAllAssets(Request $request)
    {
        $assetarray = EveCharacterAssets::GetAssetsByTypeIDForMyCharacters($request->input('items'));

        $showcharactername = true;

        return view('dashboard.assets.ajax.SearchAssets', compact('assetarray', 'showcharactername'));
    }

    public function PostSearchCharacterAssets(Request $request)
    {
        $characterID = $request->input("characterID");
        $types = $request->input('items');

        $assetarray = EveCharacterAssets::GetAssetsByTypeIDForCharacter($characterID, $types);

        $showcharactername = false;

        return view('dashboard.assets.ajax.SearchAssets', compact('assetarray', 'showcharactername'));
    }



    public function AjaxItemSearch(Request $request)
    {
        $items = EveInvTypes::select('typeID as id', 'typeName as text')
                                ->where('typeName', 'like', '%'.$request->input('q').'%')
                                ->get();

        return response()->json($items);

    }

    /**
     * @param $locationID
     *
     * This function gets all the top level assets for a specific location.
     *
     * This means all the assets that have no parents
     *
     * @return string
     */
    public function AjaxGetLocationAssets($locationID)
    {
        $assets = EveCharacterAssets::GetAssetsAtALocationForMyCharacters($locationID);

        $showcharactername = true;

        return view('dashboard.assets.ajax.LocationAssets', compact('assets', 'showcharactername'));
    }

    public function AjaxGetCharacterLocationAssets($characterID, $locationID)
    {
        $assets = EveCharacterAssets::GetAssetsAtALocationForCharacter($characterID, $locationID);

        $showcharactername = false;

        return view('dashboard.assets.ajax.LocationAssets', compact('assets', 'showcharactername'));
    }


    public function AjaxGetAssetsContents($AssetID)
    {
        $assets = EveCharacterAssets::GetAssetContents($AssetID);

        $showcharactername = false;

        return view('dashboard.assets.ajax.LocationAssets', compact('assets', 'showcharactername'));

    }

}
