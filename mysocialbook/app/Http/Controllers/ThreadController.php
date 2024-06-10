<?php

namespace App\Http\Controllers;

use App\Extensions\AccountManager;
use App\Extensions\ImageUploader;
use App\Models\Post;
use App\Models\Image;
use App\Models\User;
use App\Models\UserData;
use App\BusinessLogic\UserBL;
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

    public function likeThread()
    {
        $userId = Request::input('user');
        $postId = Request::input('post');
        if (!$userId || !$postId)
            return response()->json(['message' => 'KO', 'error' => 'Parametri mancanti'], 400);

        $user = User::find($userId);
        $post = Post::find($postId);
        if (!$user || !$post)
            return response()->json(['message' => 'KO', 'error' => 'Parametri errati'], 400);

        $existingLike = $user->hasLikedPost($post);

        if ($existingLike) {
            $user->unlikePost($post);
            return response()->json(['message' => 'OK', 'error' => 'Hai tolto il "mi piace" a questo post']);
        }

        $user->likePost($post);
        return response()->json(['message' => 'OK', 'error' => 'Hai messo "mi piace" a questo post']);
    }

    public function getPostsByUserId()
    {
        $userId = Request::get('id');
        if (!$userId){
            response()->json(['message' => 'KO', 'error' => 'Parametri mancanti'], 400);
        }

        $user = User::find($userId);
        if (!$user){
            response()->json(['message' => 'KO', 'error' => 'Parametri errati'], 400);
        }
        
        $posts = UserBL::getUserPostsArrayData($user);

        return response()->json($posts, 200);
    }
}