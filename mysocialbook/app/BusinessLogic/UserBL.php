<?php

namespace App\BusinessLogic;

use App\Extensions\AccountManager;
use App\Models\User;
use Storage;
use stdClass;

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
        $imageIsNull = $image == null;
        return [
            'file_name' => $imageIsNull ? "" : $image->file_name,
            'file_extension' => $imageIsNull ? "" : $image->file_extension,
            'file_path' => $imageIsNull ? "" : Storage::url($image->file_path)
        ];
    }

    public static function getUserPostsArrayData(User $user)
    {
        $userData = $user->userdata;
        $userPosts = $user->posts()->get();
        $currentUser = AccountManager::currentUser();
        $posts = [];

        foreach ($userPosts as $userPost)
        {
            $image = $userPost->image()->first();
            $imageIsNull = $image == null;

            $posts[] = [
                'post_id' => $userPost->id,
                'post_description' => $userPost->post_description,
                'publish_date' => $userPost->publish_date,
                'liked' => $currentUser->hasLikedPost($userPost),
                'image' => [
                    'file_name' => $imageIsNull ? "" : $image->file_name,
                    'file_extension' => $imageIsNull ? "" : $image->file_extension,
                    'file_path' => $imageIsNull ? "" : Storage::url($image->file_path)
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

    public static function getSearchedUserInfo(User $user)
    {
        $currentUser = AccountManager::currentUser();

        if(!$user)
            return null;

        $userData = $user->userdata;
        if(!$userData)
            return null;

        $userInfo = new stdClass();
        $userInfo->id = $user->id;
        $userInfo->username = $user->username;
        $userInfo->name = $userData->name_surname;
        $userInfo->followersNum = $user->followers()->count();
        $userInfo->alreadyFollowed = $currentUser->isFollowing($user);

        return $userInfo;
    }
}