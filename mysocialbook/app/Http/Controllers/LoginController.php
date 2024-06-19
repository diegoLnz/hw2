<?php

namespace App\Http\Controllers;

use Session, App\BusinessLogic\UserBL;
use Illuminate\Http\Request;
use App\Extensions\AccountManager;
use Validator;

class LoginController extends Controller
{
    public function login()
    {
        if (Session::has('user'))
        {
            return redirect('home');
        }

        $user = AccountManager::currentUser();
        if(!$user || strtolower($user->username) != strtolower(Session::get('user')))
        {
            Session::forget('user');
        }

        return view('login');
    }

    public function logUser(Request $request)
    {
        $requestData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username mancante',
            'password.required' => 'Password mancante'
        ]);
    
        $username = $requestData['username'];
        $password = $requestData['password'];

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