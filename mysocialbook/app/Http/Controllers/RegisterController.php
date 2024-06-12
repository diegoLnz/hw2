<?php

namespace App\Http\Controllers;

use Session, Exception;
use Illuminate\Http\Request;
use App\BusinessLogic\RegisterBL, App\Models\User, App\Models\UserData;

class RegisterController extends Controller
{
    public function register()
    {
        return Session::has('user')
            ? redirect('home')
            : view('register'); 
    }

    public function registerUser(Request $request)
    {
        try
        {
            if (!RegisterBL::validateFormRequest($request))
            {
                throw new Exception("Dati non validi");
            }

            $userDataId = RegisterBL::saveUserData($request);

            if (!RegisterBL::saveUser($request, $userDataId))
            {
                throw new Exception("Errore durante il salvataggio dell' utente");
            }

            Session::start();
            Session::put('user', $request->post('username'));
            return redirect('home');
        } 
        catch (Exception $e)
        {
            return redirect('register?message='.$e->getMessage());
        }
    }
}