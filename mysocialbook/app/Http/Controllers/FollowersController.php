<?php

namespace App\Http\Controllers;
use App\Extensions\AccountManager;
use App\Models\User;

class FollowersController extends Controller
{
    public function followersList()
    {
        return view('followers-list')
        ->with('user', AccountManager::currentUser());
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
                'name_surname' => $nameAndSurname,
                'image_path' => isset($singleUser->image) ? $singleUser->image->file_path : ""
            ];
        }

        http_response_code(200);
        return json_encode($usersInfo);
    }
}