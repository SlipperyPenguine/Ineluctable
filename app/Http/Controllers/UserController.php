<?php

namespace ineluctable\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use ineluctable\models\GroupUserPivot;
use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;
use ineluctable\models\SeatKey;
use ineluctable\Services\Validators\SeatUserRegisterValidator;
use ineluctable\models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();

        //dd($users);

        return view('dashboard.users.index')
            ->with(array('users' => $users));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Grab the inputs and validate them
        $new_user = $request->only(
            'email', 'username', 'password', 'password_confirmation', 'first_name', 'last_name', 'is_admin'
        );

        $validation = new SeatUserRegisterValidator;

        // Should the form validation pass, continue to attempt to add this user
        if ($validation->passes()) {

            // Because users are soft deleted, we need to check if if
            // it doesnt actually exist first.
            $user = User::withTrashed()
                ->where('email', $request->email)
                ->orWhere('username', $request->username)
                ->first();

            // If we found the user, restore it and set the
            // new values found in the post
            if($user)
                $user->restore();
            else
                $user = new User;

            // With the user object ready, work the update
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = \Hash::make($request->password);
            $user->activated = 1;

            $user->save();

            // After user is saved and has a user_id
            // we can add it to the admin group if necessary
            if ($request->is_admin == 'yes') {

                $adminGroup = Auth::findGroupByName('Administrators');
                Auth::addUserToGroup($user, $adminGroup);
            }

            flash()->success('Success', 'Added user '.$request->username.' to the system');

            return redirect()->action('UserController@index');

        } else {

            return redirect()->back()
                ->withInput()
                ->withErrors($validation->errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * Shows user.  Call via /dashboard/users/{userID}
     *
     * @param $userID
     * @return Response
     * @internal param int $id
     */
    public function show($userID)
    {
        return ' do we not have a show function...hhhmmm';

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($userID)
    {
        $user = Auth::findUserById($userID);
        $allGroups = Auth::findAllGroups();
        $tmp = Auth::getUserGroups($user);
        $hasGroups = array();

        foreach($tmp as $group)
            $hasGroups = array_add($hasGroups, $group->name, '1');

        return view('dashboard.users.edit')
            ->with('user', $user)
            ->with('availableGroups', $allGroups)
            ->with('hasGroups', $hasGroups);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param          $userID
     *
     * @return Response
     * @internal param int $id
     */
    public function update(Request $request, $userID)
    {
        // Find the user
        $user = Auth::findUserById($request->userID);

        // Find the administrators group
        $admin_group = Auth::findGroupByName('Administrators');

        // ... and check that it exists
        if(!$admin_group)
            return redirect()->back()
                ->withInput()
                ->withErrors('Administrators group could not be found');

        $user->email = $request->email;

        if ($request->username != '')
            $user->username = $request->username;

        if ($request->password != '')
            $user->password = Hash::make($request->password);

        $groups = $request->except('_token', '_method', 'username', 'password', 'first_name', 'last_name', 'userID', 'email');

        // Delete all the permissions the user has now
        GroupUserPivot::where('user_id', '=', $user->id)
            ->delete();

        // Restore the permissions.
        //
        // NB Todo. Check that we not revoking 'Administrors' access from
        // the site admin
        foreach($groups as $group => $value) {

            $thisGroup = Auth::findGroupByName(str_replace("_", " ", $group));
            Auth::addUserToGroup($user, $thisGroup);
        }

        if ($user->save()) {
            flash()->success('Success', 'User '.$request->username.' was successfully updated');

            return redirect()->action('UserController@index');
        }
        else
            return redirect()->back()
                ->withInput()
                ->withErrors('Error updating user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($userID)
    {
        $user = Auth::findUserById($userID);

        // Lets return the keys that this user owned back
        // to the admin user
        SeatKey::where('user_id', $user->id)
            ->update(array('user_id' => 1));

        $user->forceDelete();

        flash()->success('Success', 'The user has been deleted.  All keys have been moved to the administrator');
        return redirect()->action('UserController@index');
    }


    /**
     * Custom function to impersonate a User
     * @param $userID
     * @return mixed
     */
    public function Impersonate(Request $request)
    {
        $userID = $request->userID;

        // Find the user
        $user = Auth::findUserById($userID);

        // Attempt to authenticate using the user->id
        Auth::loginUsingId($userID);

        flash()->warning('Impersonating User', 'You are now impersonating ' . $user->email );

        return redirect()->action('DashboardController@home');

        return redirect()->action('DashboardController@Home')
            ->with('warning', 'You are now impersonating ' . $user->email);
    }
}
