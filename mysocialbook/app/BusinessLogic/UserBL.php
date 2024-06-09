<?php

namespace App\BusinessLogic;

use App\Models\User;

class UserBL
{
    public static function validateUserCredentials(string $username, string $password): bool
    {
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->first();
        return $user && password_verify($password, $user->password);
    }

    public static function getSearchedUsers(string $search, string $user)
    {
        $users = User::join('userdata', 'users.userdata_id', '=', 'userdata.id')
        ->where(function ($users) use ($search) {
            $users
            ->whereRaw('LOWER(users.username) LIKE ?', ["%$search%"])
            ->orWhereRaw('LOWER(userdata.name_surname) LIKE ?', ["%$search%"]);
        })
        ->whereRaw('LOWER(users.username) != ?', [strtolower($user)])
        ->get();

        return $users;
    }
}