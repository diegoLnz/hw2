<?php

namespace App\Extensions;

use App\Models\User;
use Session;

class AccountManager
{
    public static function currentUser()
    {
        $username = Session::get('user');
        if (!$username)
            return null;

        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)]);
        return $user;
    }
}