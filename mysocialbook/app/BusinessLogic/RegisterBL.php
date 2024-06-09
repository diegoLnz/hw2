<?php

namespace App\BusinessLogic;

use Request, App\Models\User, App\Models\UserData;

class RegisterBL
{
    public static function validateFormRequest(Request $request): bool
    {
        $atLeastOneFieldEmpty = empty($request->post('email'))
        || empty($request->post('name'))
        || empty($request->post('username'))
        || empty($request->post('password'))
        || empty($request->post('password-confirm'));

        $email = $request->post('email');
        $name = $request->post('name');
        $username = $request->post('username');
        $password = $request->post('password');
        $password_confirm = $request->post('password-confirm');

        $confirmPass = $password == $password_confirm;
    
        $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

        $user = User::where('LOWER(username) = ?', [strtolower($username)])->first();

        return !$atLeastOneFieldEmpty 
        && $confirmPass 
        && $validEmail 
        && !$user;
    }

    public static function saveUserData(Request $request): int
    {
        $userData = [
            'name_surname' => $request->post('name'),
            'email' => $request->post('email')
        ];

        $savedUserData = UserData::create($userData);
        return $savedUserData->id;
    }

    public static function saveUser(Request $request, $userDataId): bool
    {
        $user = new User();
        $user->username = $request->post('username');
        $user->password = password_hash($request->post('password'), PASSWORD_DEFAULT);
        $user->userdata_id = $userDataId;

        return $user->save();
    }
}