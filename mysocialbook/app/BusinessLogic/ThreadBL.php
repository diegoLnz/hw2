<?php

namespace App\BusinessLogic;

use App\Models\Post;
use App\Models\User;
use App\Models\UserData;
use App\Models\Comment;
use App\BusinessLogic\UserBL;
use App\Extensions\AccountManager;
use Storage;

class ThreadBL
{
    public static function formatPostAsArray(Post $post)
    {
        $user = $post->user;
        $userData = $user->userdata;
        $image = $post->image;
        $imageIsNull = $image == null;
        $currentUser = AccountManager::currentUser();

        return [
            'post_id' => $post->id,
            'post_description' => $post->post_description,
            'publish_date' => $post->publish_date,
            'liked' => $currentUser->hasLikedPost($post),
            'image' => [
                'file_name' => $imageIsNull ? "" : $image->file_name,
                'file_extension' => $imageIsNull ? "" : $image->file_extension,
                'file_path' => $imageIsNull ? "" : Storage::url($image->file_path)
            ],
            'user' => [
                'username' => $user->username,
                'name_surname' => $user->name_surname,
                'email' => $userData->email,
                'profile_pic' => UserBL::getProfilePicArrayData($user)
            ]
        ];
    }

    public static function formatPostAsArrayWithComments(Post $post)
    {
        $user = $post->user;
        $userData = $user->userdata;
        $image = $post->image;
        $imageIsNull = $image == null;
        $currentUser = AccountManager::currentUser();
        $comments = $post->comments;

        return [
            'post_id' => $post->id,
            'post_description' => $post->post_description,
            'publish_date' => $post->publish_date,
            'liked' => $currentUser->hasLikedPost($post),
            'image' => [
                'file_name' => $imageIsNull ? "" : $image->file_name,
                'file_extension' => $imageIsNull ? "" : $image->file_extension,
                'file_path' => $imageIsNull ? "" : Storage::url($image->file_path)
            ],
            'user' => [
                'username' => $user->username,
                'name_surname' => $user->name_surname,
                'email' => $userData->email,
                'profile_pic' => UserBL::getProfilePicArrayData($user)
            ],
            'comments' => self::formatCommentsAsArray($comments)
        ];
    }

    public static function formatCommentsAsArray($comments)
    {
        $returnedArray = [];

        foreach ($comments as $comment)
        {
            $user = $comment->user;
            $returnedArray[] = [
                'content' => $comment->content,
                'created_at' => $comment->created_at,
                'user' => [
                    'username' => $user->username,
                    'profile_pic' => UserBL::getProfilePicArrayData($user)
                ]
            ];
        }

        return $returnedArray;
    }
}