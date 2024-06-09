<?php

namespace App\Http\Controllers;

use Session, Request, App\BusinessLogic\UserBL;

class LoginController extends Controller
{
    public function login()
    {
        return Session::has('user')
            ? redirect('home')
            : view('login');
    }

    public function logUser()
    {
        $username = Request::post('username');
        $password = Request::post('password');

        if (UserBL::validateUserCredentials($username, $password))
            return redirect('login?error=invalid_credentials');

        Session::start();
        Session::put('user', $username);
    }
}