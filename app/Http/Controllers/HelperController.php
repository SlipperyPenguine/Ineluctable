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

namespace ineluctable\Http\Controllers;

use Cache;
use DB;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ineluctable\EveApi\BaseApi;
use Pheal\Pheal;

class HelperController extends Controller
{

    /*
   |--------------------------------------------------------------------------
   | postResolveNames()
   |--------------------------------------------------------------------------
   |
   | Take a list of ids and resolve them to in game names. We will store
   | already resolved names in the cache and just pick them up from there.
   | The remainder of the names will be queried by the API
   |
   */

    public function postResolveNames(Request $request)
    {

        // Create an array from the ids and make them unique
        $ids = explode(',', $request->input('ids'));
        $ids = array_unique($ids);

        // Set the array that we will eventually return, containing the resolved
        // names
        $return = array();

        // Start by doing a cache lookups for each of the ids to see what we have
        // already resolved
        foreach ($ids as $id) {

            if(Cache::has('nameid_' . $id)) {

                // Retreive the name from the cache and place it in the results.
                $return[$id] = Cache::get('nameid_' . $id);

                // Remove it from the $ids array as we don't need to lookup
                // this one.
                unset($ids[$id]);
            }
        }

        // Check if there is anything left to lookup, and prepare a pheal instance
        // to handle the API call for this
        if (count($ids) > 0) {

            // Get pheal ready
            BaseApi::bootstrap();
            $pheal = new Pheal();

            // Loop over the ids for a max of 30 ids, and resolve the names
            foreach (array_chunk($ids, 15) as $resolvable) {

                // Attempt actual API lookups
                try {

                    $names = $pheal->eveScope->CharacterName(array('ids' => implode(',', $resolvable)));

                } catch (\Exception $e) {

                    throw $e;
                }

                // Add the results to the cache and the $return array
                foreach ($names->characters as $lookup_result) {

                    Cache::forever('nameid_' . $lookup_result->characterID, $lookup_result->name);
                    $return[$lookup_result->characterID] = $lookup_result->name;
                }
            }
        }

        // With all the work out of the way, return the $return array as Json
        return response()->json($return);
    }


    /*
    |--------------------------------------------------------------------------
    | getAccounts()
    |--------------------------------------------------------------------------
    |
    | Return the currently available SeAT accounts
    |
    */

    public function getAccounts(Request $request)
    {
        return response()->json( \ineluctable\models\User::all('username', 'id'));

/*        $accounts = DB::table('seat_users')
            ->select('id', DB::raw('username as text'))
            ->where('username', 'like', '%' . $request->q . '%')
            ->get();


        return response()->json($accounts);

        return Response::json($accounts);*/
        //return $accounts;
    }


}
