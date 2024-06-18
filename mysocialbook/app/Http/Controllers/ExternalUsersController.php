<?php

namespace App\Http\Controllers;

use App\Extensions\AccountManager;
use Session;
use App\BusinessLogic\UserBL;
use App\Models\User;

class ExternalUsersController extends Controller
{
    public function user($username)
    {
        if (!$username)
            return redirect()->back();

        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->first();
        if (!$user)
            return redirect()->back();

        $currentUser = AccountManager::currentUser();
        $userInfo = UserBL::getSearchedUserInfo($user);
        return view('user')
        ->with('userInfo', $userInfo)
        ->with('userExt', $user)
        ->with('currentUser', $currentUser)
        ->with('user', AccountManager::currentUser());
    }
}