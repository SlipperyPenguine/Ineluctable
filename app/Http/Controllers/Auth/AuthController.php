<?php

namespace ineluctable\Http\Controllers\Auth;

use Illuminate\Http\Request;
use ineluctable\models\User;
use Validator;
use ineluctable\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = 'dashboard/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:seat_users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        flash()->success('Success', 'Congratulations, you have successfully registered');

        return User::create([
            'username' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'activated' => 1
        ]);

    }

    public function authenticated(Request $request, $user)
    {
        flash()->success('Success', 'You have successfully logged in as '.$user->username);
        return redirect()->intended($this->redirectPath());
    }

    public function getLogout()
    {
        flash('Logged out', 'You have successfully logged out');
        \Auth::logout();

        return redirect('/');
    }

    /*
     |--------------------------------------------------------------------------
     | isSuperUser()
     |--------------------------------------------------------------------------
     |
     | Checks if a User is a SuperUser
     |
     */
    public function isSuperUser($user = null)
    {

        // If no user is specified, we assume the user context
        // should be the currently logged in user.
        if (is_null($user))
            $user = \Auth::User();

        // Get the groups the user is currently a member of
        $groups = $user->groups;

        // Loop over the groups, and check if any of them
        // have the 'superuser' permission
        foreach($groups as $group) {

            // Reset the permissions to a empty array
            $permissions = array();

            // Check that the group has _any_ permission before
            // we try unserialize a empty string
            if (strlen($group->permissions) > 0)
                $permissions = unserialize($group->permissions);

            // Check that there is at least one permission
            // returned for the group, otherwise we will
            // just continue to the next group
            if(count($permissions) <= 0)
                continue;

            // If we did get some permissions, check if one
            //of them was the superuser permission
            if(array_key_exists('superuser', $permissions)) {

                if($permissions['superuser'] == 1)

                    // A group that this user belongs to with
                    // the superuser permission exists
                    return true;
            }
        }

        // No group was found having the superuser permission
        return false;
    }
}
