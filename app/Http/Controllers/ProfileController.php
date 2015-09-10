<?php

namespace ineluctable\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use ineluctable\Http\Requests;
use ineluctable\Http\Requests\ProfileSettingsRequest;
use ineluctable\Http\Requests\UserPasswordChangeRequest;
use ineluctable\Http\Controllers\Controller;
use ineluctable\models\SeatKey;
use ineluctable\Services\Settings\SettingHelper;

class ProfileController extends Controller
{
    public function showProfile()
    {

        $user = auth()->user();
        //$groups = $user->groups()->get();
        //$issuperuser = $user->isSuperUser();
        //$groups = auth()->getUserGroups();
        //$groups = \Auth::getUserGroups();


        $key_count = SeatKey::where('user_id', $user->id)
            ->count();


        $characters = DB::table('account_apikeyinfo_characters')
            ->select('characterID', 'characterName')
            ->join('seat_keys', 'account_apikeyinfo_characters.keyID', '=', 'seat_keys.keyID')
            ->where('seat_keys.user_id', \Auth::User()->id)
            ->get();

        // Prep a small array for the Form builder to let
        // the user choose a 'main' character
        $available_characters = array();
        foreach ($characters as $character_info)
            $available_characters[$character_info->characterID] = $character_info->characterName;

        return view('dashboard.profile')
            ->with('user', $user)
            ->with('key_count', $key_count)
            ->with('available_characters', $available_characters)
            ->with('thousand_seperator', SettingHelper::getSetting('thousand_seperator'))
            ->with('decimal_seperator', SettingHelper::getSetting('decimal_seperator'));


    }


    /** postProfile
     *
     * Posts changes when the user clicks save on the settings
     *
     * @param ProfileSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function postProfile(ProfileSettingsRequest $request)
    {
        $character_name = DB::table('account_apikeyinfo_characters')
            ->where('characterID', $request->main_character_id)
            ->value('characterName');

        SettingHelper::setSetting('color_scheme',  $request->color_scheme, \Auth::User()->id);
        SettingHelper::setSetting('thousand_seperator',  $request->thousand_seperator, \Auth::User()->id);
        SettingHelper::setSetting('decimal_seperator',  $request->decimal_seperator, \Auth::User()->id);
        SettingHelper::setSetting('main_character_id',  $request->main_character_id, \Auth::User()->id);
        SettingHelper::setSetting('main_character_name', $character_name, \Auth::User()->id);
        SettingHelper::setSetting('email_notifications',  $request->email_notifications, \Auth::User()->id);

        flash()->success('Success', 'Profile Settings Saved');

        return redirect()->back()
            ->with('success', 'Settings Saved!');
    }


    /*
|--------------------------------------------------------------------------
| postChangePassword()
|--------------------------------------------------------------------------
|
| Changes the password but sends an email to the user
| to confirm the password change
|
*/

    public function postChangePassword(UserPasswordChangeRequest $request)
    {

        $user = \Auth::User();

        if(\Auth::validate(array('email' => \Auth::User()->email, 'password' => $request->oldPassword))) {

            $user->password = \Hash::make($request->newPassword_confirmation);
            $user->save();

            flash()->success('Success', 'you have successfully changed your password');
            return redirect()->back()
                ->with('success', 'Your password has successfully been changed.');

        } else {

            //flash()->warning('Failed', 'Your password was not changed as your current password did not match');

            return redirect()->back()
                ->withInput()
                ->withErrors('Your current password did not match.');
        }


    }

    /*
     |--------------------------------------------------------------------------
     | postSetSettings()
     |--------------------------------------------------------------------------
     |
     | Sets some user configured settings
     |
     */

    public function postSetSettings(ProfileSettingsRequest $request)
    {

        $character_name = DB::table('account_apikeyinfo_characters')
            ->where('characterID', $request->main_character_id)
            ->value('characterName');

        SettingHelper::setSetting('color_scheme', Input::get('color_scheme'), \Auth::User()->id);
        SettingHelper::setSetting('thousand_seperator', Input::get('thousand_seperator'), \Auth::User()->id);
        SettingHelper::setSetting('decimal_seperator', Input::get('decimal_seperator'), \Auth::User()->id);
        SettingHelper::setSetting('main_character_id', Input::get('main_character_id'), \Auth::User()->id);
        SettingHelper::setSetting('main_character_name', $character_name, \Auth::User()->id);
        SettingHelper::setSetting('email_notifications', Input::get('email_notifications'), \Auth::User()->id);

        flash()->success('Success', 'Profile settings saved');

        return redirect()->back()
            ->with('success', 'Settings Saved!');

    }

    /*
     |--------------------------------------------------------------------------
     | getAccessLog()
     |--------------------------------------------------------------------------
     |
     | Gets the account access history
     |
     */

    public function getAccessLog()
    {

        $access_log = DB::table('seat_login_history')
            ->where('user_id', auth()->user()->id)
            ->orderBy('login_date', 'desc')
            ->take(50)
            ->get();

        return view('dashboard.ajax.accesslog')
            ->with('access_log', $access_log);
    }
}
