<?php

namespace App\Http\Controllers;
use App\Extensions\AccountManager;
use App\Models\User;

class FollowersController extends Controller
{
    public function followersList()
    {
        return view('followers-list');
    }

    public function getFollowersList()
    {
        $user = AccountManager::currentUser();
        $followers = $user->followers;

        foreach ($followers as $singleUser)
        {
            $nameAndSurname = $singleUser->userdata->name_surname;
            $usersInfo[] = [
                'username' => $singleUser->username,
                'name_surname' => $nameAndSurname
            ];
        }

        http_response_code(200);
        return json_encode($usersInfo);
    }
}