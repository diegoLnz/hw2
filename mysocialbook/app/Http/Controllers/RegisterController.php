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

            $emailValid = RegisterBL::checkExistingEmail($request->post('email'));
            if(!$emailValid)
            {
                throw new Exception('Email già esistente');
            }

            $imageId = null;
            if ($request->hasFile('file'))
            {
                $imageRes = RegisterBL::saveProfilePicture($request);
                if ($imageRes['error'] != "")
                    throw new Exception('Errore durante il salvataggio della foto profilo');
                $imageId = $imageRes['image_id'];
            }
            
            $userDataId = RegisterBL::saveUserData($request);

            if (!RegisterBL::saveUser($request, $userDataId, $imageId))
            {
                throw new Exception("Errore durante il salvataggio dell' utente");
            }

            Session::start();
            Session::put('user', $request->post('username'));
            return redirect('home');
        } 
        catch (Exception $e)
        {
            return redirect('register')->withErrors(['error' => $e->getMessage()]);
        }
    }
}