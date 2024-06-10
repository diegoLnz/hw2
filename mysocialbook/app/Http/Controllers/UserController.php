<?php

namespace App\Http\Controllers;

use Session, Request, App\Extensions\ApiExtensions, App\Models\User;
use App\BusinessLogic\UserBL;

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

        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->first();
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

    public function followUser()
    {
        $userToFollow = Request::get('follow');
        $user = Request::get('user');

        if(!$userToFollow || !$user || ($userToFollow == $user))
        {
            $response = ApiExtensions::setResponse("KO", "Parametri mancanti o errati", 400);
            return $response->toJson();
        }

        $followedUser = User::whereRaw('LOWER(username) = ?', [strtolower($userToFollow)])->first();
        $follower = User::whereRaw('LOWER(username) = ?', [strtolower($user)])->first();
        if (!$followedUser || !$follower)
        {
            $response = ApiExtensions::setResponse("KO", "User inesistente", 400);
            return $response->toJson();
        }

        if (!$follower->isFollowing($followedUser))
        {
            $follower->follow($followedUser);
        }
        else
        {
            $follower->unfollow($followedUser);
        }
        
        $response = ApiExtensions::setResponse("OK", "", 200);
        return $response->toJson();
    }

    public function listForSearchForm()
    {
        $search = strtolower(Request::get('search'));
        $user = strtolower(Request::get('user'));

        if (!$search || !$user)
        {
            $response = ApiExtensions::setResponse("KO", "Parametri errati", 400);
            return $response->toJson();
        }

        $users = UserBL::getSearchedUsers($search, $user);

        $usersInfo = [];

        foreach ($users as $singleUser)
        {
            $users[] = [
                'username' => $singleUser->username,
                'name_surname' => $singleUser->name_surname
            ];
        }

        http_response_code(200);
        return json_encode($usersInfo);
    }
}