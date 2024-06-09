<?php

namespace App\Http\Controllers;

use Session;
use App\BusinessLogic\PersonalInfoBL;

class PersonalInfoController extends Controller
{
    public function personalInfo()
    {
        if (!Session::has('user'))
            return redirect('login');

        $userInfo = PersonalInfoBL::getSessionUserInfo();
        return view('personal-info')->with('userInfo', $userInfo);
    }
}