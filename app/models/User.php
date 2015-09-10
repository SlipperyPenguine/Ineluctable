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
namespace ineluctable\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    use SoftDeletes;

    //protected $softDelete = true;
    protected $guarded = array('password');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seat_users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    protected $fillable = ['username', 'email', 'password', 'activated'];

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function keys()
    {
        return $this->hasMany('ineluctable\models\SeatKey', 'user_id');
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function groups()
    {
        return $this->belongsToMany('ineluctable\models\Group', 'seat_group_user');
    }

    public function logins()
    {
        return $this->hasMany('ineluctable\models\SeatLoginHistory');
    }


    public function isSuperUser()
    {
        // Get the groups the user is currently a member of
        $groups = $this->groups;

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

    public function ApiKeys()
    {
        return $this->hasMany('ineluctable\models\SeatKey', 'user_id');
    }


}
