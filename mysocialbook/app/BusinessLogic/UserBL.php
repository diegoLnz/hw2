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

    public static function getProfilePicArrayData(User $user)
    {
        $image = $user->image;

        return [
            'file_name' => $image->file_name,
            'file_extension' => $image->file_extension,
            'file_path' => $image->file_path
        ];
    }

    public static function getUserPostsArrayData(User $user)
    {
        $userData = $user->userdata;
        $userPosts = $user->posts()->get();
        $posts = [];

        foreach ($userPosts as $userPost)
        {
            $image = $userPost->image();

            $posts[] = [
                'post_id' => $userPost->id,
                'post_description' => $userPost->post_description,
                'publish_date' => $userPost->publish_date,
                'liked' => $user->hasLikedPost($userPost),
                'image' => [
                    'file_name' => $image->file_name,
                    'file_extension' => $image->file_extension,
                    'file_path' => $image->file_path
                ],
                'user' => [
                    'username' => $user->username,
                    'name_surname' => $user->name_surname,
                    'email' => $userData->email,
                    'profile_pic' => self::getProfilePicArrayData($user)
                ]
            ];
        }

        return $posts;
    }
}