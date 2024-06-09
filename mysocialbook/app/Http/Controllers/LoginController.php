<?php

namespace App\Http\Controllers;

use Session;

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

    }
}