<?php

namespace App\BusinessLogic;

use App\Models\User, Session, stdClass;

class PersonalInfoBL
{
    public static function getSessionUserInfo()
    {
        $username = Session::get('user');
        if (!$username)
            return null;

        $user = User::where('username', $username)->first();
        if(!$user)
            return null;

        $userData = $user->userdata;
        if(!$userData)
            return null;

        $userInfo = new stdClass();
        $userInfo->id = $user->id;
        $userInfo->username = $user->username;
        $userInfo->name = $userData->name_surname;
        $userInfo->followersNum = $user->followers()->count();

        return $userInfo;
    }
}