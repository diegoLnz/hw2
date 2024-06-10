<?php

namespace App\BusinessLogic;

use App\Models\Post;
use App\Models\User;
use App\Models\UserData;
use App\BusinessLogic\UserBL;

class ThreadBL
{
    public static function formatPostAsArray(Post $post)
    {
        $user = $post->user;
        $userData = $user->userdata;
        $image = $post->image;

        return [
            'post_id' => $post->id,
            'post_description' => $post->post_description,
            'publish_date' => $post->publish_date,
            'liked' => $user->hasLikedPost($post),
            'image' => [
                'file_name' => $image->file_name,
                'file_extension' => $image->file_extension,
                'file_path' => $image->file_path
            ],
            'user' => [
                'username' => $user->username,
                'name_surname' => $user->name_surname,
                'email' => $userData->email,
                'profile_pic' => UserBL::getProfilePicArrayData($user)
            ]
        ];
    }
}