<?php

namespace App\BusinessLogic;

use Illuminate\Http\Request, App\Models\User, App\Models\UserData;
use App\Extensions\ImageUploader;
use App\Models\Image;

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

        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->first();

        return !$atLeastOneFieldEmpty 
        && $confirmPass 
        && $validEmail 
        && !$user;
    }

    public static function checkExistingEmail(string $email): bool
    {
        $users = UserData::whereRaw('LOWER(email) = ?', [strtolower($email)])->get();
        return $users->count() == 0;
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

    public static function saveUser(Request $request, $userDataId, $profilePicId): bool
    {
        $user = new User();
        $user->username = trim($request->post('username'));
        $user->password = password_hash($request->post('password'), PASSWORD_DEFAULT);
        $user->userdata_id = $userDataId;

        if ($profilePicId != null)
            $user->profile_pic_id = $profilePicId;

        return $user->save();
    }

    public static function saveProfilePicture(Request $request)
    {
        $uploader = new ImageUploader();

        $result = $uploader->upload($request, 'file', $request->post('username'), 'profilePictures');

        if ($result['error'] !== "") 
            return ['error' => $result['error']];

        $filename = basename($result['path']);
        
        $image = new Image();
        $image->file_name = $filename;
        $image->file_extension = $request->file('file')->getClientOriginalExtension();
        $image->file_path = $result['path'];
        $image->save();

        return ['image_id' => $image->id, 'error' => ""];
    }
}