<?php

namespace ineluctable\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

use ineluctable\EveApi\BaseApi;
use ineluctable\Events\APIKeyAdded;
use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;
use ineluctable\models\SeatKey;
use ineluctable\Services\Settings\SettingHelper;
use ineluctable\Services\Validators\APIKeyValidator;
use ineluctable\models\User;
use Input;
use Pheal\Exceptions\PhealException;
use Pheal\Pheal;

use App;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $apikeys = auth()->user()->ApiKeys()->get();



        return view('dashboard.apikeys.index', compact('apikeys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('dashboard.apikeys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = new APIKeyValidator(array('keyID' => $request->keyID, 'vCode' => $request->vCode));

        if ($validation->passes()) {

            // Check if we have this key in the db, even those that are soft deleted
            $key_data = SeatKey::withTrashed()
                ->where('keyID', $request->keyID)
                ->first();

            if (!$key_data)
                $key_data = new SeatKey;

            $key_data->keyID = $request->keyID;
            $key_data->vCode = $request->vCode;
            $key_data->isOk = 1;
            $key_data->lastError = null;
            $key_data->deleted_at = null;
            $key_data->user_id = Auth::User()->id;
            $key_data->save();

            // Fire the event that an API key was added
            event(new APIKeyAdded($key_data));


            flash()->success('Success', 'API Key successfully added, jobs have been queued to bring in all the character details');
            return redirect('dashboard/apikeys');

        } else {

            return redirect('dashboard/apikeys/create')
                ->withInput()
                ->withErrors($validation->errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

        // TODO : Ensure that this user may access the data for $keyID
/*        if (!auth()->user()->isSuperUser())
            if (!in_array($keyID, Session::get('valid_keys')))
                App::abort(404);*/

        $key_information = DB::table('seat_keys')
            ->select(
                'seat_keys.keyID', 'seat_keys.vCode', 'seat_keys.isOk', 'seat_keys.lastError',
                'account_apikeyinfo.accessMask', 'account_apikeyinfo.type', 'account_apikeyinfo.expires'
            )
            ->leftJoin('account_apikeyinfo', 'seat_keys.keyID', '=', 'account_apikeyinfo.keyID')
            ->where('seat_keys.keyID', $id)
            ->first();

        $key_characters = DB::table('account_apikeyinfo_characters')
            ->where('keyID', $id)
            ->get();

        $key_bans = DB::table('banned_calls')
            ->where('ownerID', $id)
            ->get();

        $key_owner = DB::table('seat_keys')
            ->join('seat_users', 'seat_keys.user_id', '=', 'seat_users.id')
            ->where('seat_keys.keyID', $id)
            ->get();

        //get the user list for the transfer
        $userlist = User::all('id', 'username', 'email');

        return view('dashboard.apikeys.show', compact('key_information','key_characters', 'key_bans', 'key_owner', 'userlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return 'EDIT A KEY';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return 'update a key';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /*
|--------------------------------------------------------------------------
| postTransferOwnership()
|--------------------------------------------------------------------------
|
| Set a new owner for a API key
|
*/

    public function TransferOwnership(Request $request)
    {

        // Ensure that this user is a super admin
        if (!Auth::isSuperUser())
            App::abort(404);

        // Find the API Key and user...
        $key_information  = SeatKey::where('keyID', $request->keyID)->first();
        $seat_user = User::where('id', $request->accountid)->first();

        // ... and check that they exist
        if (!$key_information || !$seat_user)
            App::abort(404);

        $key_information->user_id = Input::get('accountid');
        $key_information->save();

        flash()->success('Success', 'Key successfully transferred');

        return redirect()->action('ApiKeyController@show', array($request->keyID));
    }

    public function ajaxcheckkey(Request $request)
    {
        if ($request->ajax())
        {

            // We will validate the key pais as we dont want to cause unneeded errors
            $validation = new APIKeyValidator;

            if ($validation->passes()) {

                // Setup a pheal instance and get some API data :D
                BaseApi::bootstrap();
                $pheal = new Pheal($request->keyID, $request->vCode);

                // Get API Key Information
                try {

                    $key_info = $pheal->accountScope->APIKeyInfo();

                } catch (PhealException $e) {

                    return view('keys.ajax.errors')
                        ->withErrors(array('error' => $e->getCode() . ': ' . $e->getMessage()));
                }

                // Here, based on the type of key, we will either call some further information,
                // or just display what we have learned so far.
                if ($key_info->key->type == 'Corporation') {

                    // Just return the view for corporation keys
                    return view('dashboard.apikeys.ajax.corporation')
                        ->with('keyID', Input::get('keyID'))
                        ->with('vCode', Input::get('vCode'))
                        ->with('key_info', $key_info)
                        ->with('existance', SeatKey::where('keyID', Input::get('keyID'))->count());
                }
                elseif($key_info->key->accessMask < SettingHelper::getSetting('required_mask')) {

                    return view('keys.ajax.errors')
                        ->withErrors(array('error' => 'Invalid API Mask!'));
                }

                // Get API Account Status Information
                try {

                    $status_info = $pheal->accountScope->AccountStatus();

                } catch (PhealException $e) {

                    return view('dashboard.apikeys.ajax.errors')
                        ->withErrors(array('error' => $e->getCode() . ': ' . $e->getMessage()));
                }

                // Return the view
                return view('dashboard.apikeys.ajax.character')
                    ->with('keyID', $request->keyID)
                    ->with('vCode', $request->vCode)
                    ->with('key_info', $key_info)
                    ->with('status_info', $status_info)
                    ->with('existance', SeatKey::where('keyID', $request->keyID)->count());

            } else {

                return view('dashboard.apikeys.ajax.errors')
                    ->withErrors($validation->errors);
            }
        }

    }
}
