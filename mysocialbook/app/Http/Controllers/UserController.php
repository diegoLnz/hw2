<?php

namespace App\Http\Controllers;

use Session, Request, App\Extensions\ApiExtensions, App\Models\User;

class UserController extends Controller
{
    public function checkExistingUser()
    {
        $username = Request::get('username');
        if (!$username)
        {
            $response = ApiExtensions::setResponse('KO', 'Username mancante', 400);
            return $response->toJson();
        }

        $user = User::where('username', $username)->first();
        if(!$user)
        {
            $response = ApiExtensions::setResponse('OK', '', 200);
        }
        else
        {
            $response = ApiExtensions::setResponse('KO', 'Username già esistente', 400);
        }

        return $response->toJson();
    }
}