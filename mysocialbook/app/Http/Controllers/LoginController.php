<?php

namespace App\Http\Controllers;

use Session, App\BusinessLogic\UserBL;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return Session::has('user')
            ? redirect('home')
            : view('login');
    }

    public function logUser(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');

        if (!UserBL::validateUserCredentials($username, $password))
            return redirect('login')->withErrors(['invalid_credentials' => 'Username o password errati']);

        Session::put('user', $username);
        return redirect('home');
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }
}