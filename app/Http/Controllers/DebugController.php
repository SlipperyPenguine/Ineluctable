<?php

namespace ineluctable\Http\Controllers;

use Illuminate\Http\Request;

use ineluctable\models\CompletedJobs;
use ineluctable\models\EveAccountAPIKeyInfoCharacters;
use ineluctable\models\EveApiCalllist;
use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;
use ineluctable\models\Jobs;
use ineluctable\Services\Validators\APIKeyValidator;
use ineluctable\EveApi\BaseApi;

use Illuminate\View\View;

use Pheal\Pheal;



class DebugController extends Controller
{

    /**
     * PHP 5 allows developers to declare constructor methods for classes.
     * Classes which have a constructor method call this method on each newly-created object,
     * so it is suitable for any initialization that the object may need before it is used.
     *
     * Note: Parent constructors are not called implicitly if the child class defines a constructor.
     * In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.
     *
     * param [ mixed $args [, $... ]]
     * @return void
     * @link http://php.net/manual/en/language.oop5.decon.php
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    public function browser()
    {

        //$headers = $_SERVER;
        $headers = getallheaders();

        return view('dashboard.debug.browser', compact('headers'));
    }
    /*
|--------------------------------------------------------------------------
| getApi()
|--------------------------------------------------------------------------
|
| Prepare a view with API Related information to post for debugging reasons
|
*/

    public function getApi()
    {

        // Find the available API calls
        $call_list = EveApiCalllist::all()->groupBy('name');



        return view('debug.api')->with('call_list', $call_list);
    }



    /*
       |--------------------------------------------------------------------------
        | postQuery()
        |--------------------------------------------------------------------------
        |
        | Work with the received information to prepare a API call to the server
        | and display its end result
        |
        */

    public function postQuery(Request $request)
    {

        //return dd($request->all());

        // We will validate the key pairs as we dont want to cause unneeded errors
        $validation = new APIKeyValidator;

        if ($validation->passes()) {


            // Bootstrap the Pheal Instance
            BaseApi::bootstrap();
            $pheal = new Pheal($request->input('keyID'), $request->input('vCode'));
            $pheal->scope = strtolower($request->input('api'));

            // Prepare an array with the arguements that we have received.
            // first the character
            $arguements = array();
            if (strlen($request->input('characterid')) > 0)
                $arguements = array('characterid' => $request->input('characterid'));

            // Next, process the option arrays
            if (strlen($request->input('optional1')) > 0)
                $arguements[$request->input('optional1')] = $request->input('optional1value');

            if (strlen($request->input('optional2')) > 0)
                $arguements[$request->input('optional2')] = $request->input('optional2value');

            // Compute the array for the view to sample the pheal call that will be made
            $call_sample = array('keyID' => $request->input('keyID'), 'vCode' => $request->input('vCode'), 'scope' => $request->input('api'), 'call' => $request->input('call'), 'args' => $arguements);

            try {

                $method = $request->input('call');
                $response = $pheal->$method($arguements);

            } catch (\Exception $e) {

                return view('debug.ajax.result')
                    ->with('call_sample', $call_sample)
                    ->with('exception', $e);
            }

            return view('debug.ajax.result')
                ->with('call_sample', $call_sample)
                ->with('response', $response->toArray());

        } else {

            return view('debug.ajax.result')
                ->withErrors($validation->errors);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | AjaxGetCallList()
    |--------------------------------------------------------------------------
    |
    | Called by the UI to update a call list drop down depending on the users
    | selection on the API type
    |
    | Requires an input with the api type in to do the filtering
    |
     */
    public function AjaxGetCallList(Request $request)
    {
      /*  var newOptions = {"Option 1": "value1",
  "Option 2": "value2",
  "Option 3": "value3"
};*/
        $api = $request->input('api');

        //search the database for valid api calls
        $calls =  EveApiCalllist::where('type','=', $api)->get();

        //$response = '{ ';
        $response = '';

        foreach ($calls as $call)
        {
            //$response .=  '<option value="'.$call->name.'">'.$call->name.'</option> ';
            //$response .= '"'.$call->name.'": "'.$call->name.'",';
            $response .= $call->name.',';

        }

        $response = rtrim($response, ",");
        //$response .= ' }';


        return $response;
    }



    /*
    |--------------------------------------------------------------------------
    | DashboardGetApi()
    |--------------------------------------------------------------------------
    |
    | Prepare a view with API Related information to post for debugging reasons
    |
    | This one is designed to work for the dashboard view
    |
    */
    public function DashboardGetApi()
    {

        // Find the available API calls
        $call_list = EveApiCalllist::all()->groupBy('name');

        $characterlist = EveAccountAPIKeyInfoCharacters::MyCharacters();
        $characterlist->load('key');

        //dd($characterlist);
        return view('dashboard.debug.api', compact('call_list', 'characterlist'));
    }


    /*
|--------------------------------------------------------------------------
| DashboardGetApi()
|--------------------------------------------------------------------------
|
| Prepare a view with API Related information to post for debugging reasons
|
| This one is designed to work for the dashboard view
|
*/
    public function logfiles()
    {
        $laravellog = \File::get(base_path('storage/logs/laravel.log'));
        $phealaccesslog = \File::get(base_path('storage/logs/pheal_access.log'));
        $phealerrorlog = \File::get(base_path('storage/logs/pheal_error.log'));


        return view('dashboard.debug.logfiles', compact('laravellog', 'phealaccesslog', 'phealerrorlog'));
    }

    public function jobs()
    {
        $jobs = Jobs::all();
        $completedjobs = CompletedJobs::orderBy('id', 'desc')->take(50)->get();
        return view('dashboard.debug.jobs', compact('jobs', 'completedjobs'));
    }


    public function deletelaravellog()
    {
        $this->clearfile(base_path('storage/logs/laravel.log'));

    }

    public function deletephealaccesslog()
    {
         $this->clearfile(base_path('storage/logs/pheal_access.log'));
    }

    public function deletephealerrorlog()
    {
        $this->clearfile(base_path('storage/logs/pheal_error.log'));
    }

    private function clearfile($filepath)
    {
        \File::delete($filepath);
        \File::put($filepath, '');
    }
}

