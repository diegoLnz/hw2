<?php

namespace App\BusinessLogic;

use App\Models\User;

class UserBL
{
    public static function validateUserCredentials(string $username, string $password): bool
    {
        $user = User::where('username', $username)->first();
        return $user && password_verify($password, $user->password);
    }
}