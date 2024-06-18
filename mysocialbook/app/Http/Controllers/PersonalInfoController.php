<?php

namespace App\Http\Controllers;

use Session;
use App\BusinessLogic\PersonalInfoBL;
use App\Extensions\AccountManager;

class PersonalInfoController extends Controller
{
    public function personalInfo()
    {
        if (!Session::has('user'))
            return redirect('login');

        $userInfo = PersonalInfoBL::getSessionUserInfo();
        return view('personal-info')
        ->with('userInfo', $userInfo)
        ->with('user', AccountManager::currentUser());
    }
}