<?php

namespace App\Http\Controllers;

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

        $userInfo = UserBL::getSearchedUserInfo($user);
        return view('user')->with('userInfo', $userInfo);
    }
}