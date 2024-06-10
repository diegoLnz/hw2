<?php

namespace App\Http\Controllers;

use App\Extensions\AccountManager;
use App\Extensions\ImageUploader;
use App\Models\Post;
use App\Models\Image;
use Request;

class ThreadController extends Controller
{
    public function uploadThread(Request $request)
    {
        $uploader = new ImageUploader();

        $result = $uploader->upload($request, 'file');

        if ($result['error'] !== "") 
            return redirect()->back();

        $filename = basename($result['path']);

        $image = new Image();
        $image->file_name = $filename;
        $image->file_extension = $request->file('file')->getClientOriginalExtension();
        $image->file_path = $result['path'];
        $image->save();

        $user = AccountManager::currentUser();

        $post = new Post();
        $post->post_description = $request->post('description');
        $post->publish_date = now();
        $post->user_id = $user->id;
        $post->image_id = $image->id;
        $post->save();

        return redirect()->back()->with('success', 'Post creato con successo');
    }
}