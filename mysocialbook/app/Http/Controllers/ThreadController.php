<?php

namespace App\Http\Controllers;

use App\Extensions\AccountManager;
use App\Extensions\ImageUploader;
use App\Models\Post;
use App\Models\Image;
use App\Models\User;
use App\Models\UserData;
use App\BusinessLogic\UserBL;
use App\BusinessLogic\ThreadBL;
use App\BusinessLogic\PersonalInfoBL;
use Illuminate\Http\Request;
use Storage;

class ThreadController extends Controller
{
    public function uploadThread(Request $request)
    {
        $post = new Post();

        if ($request->hasFile('file'))
        {
            $uploader = new ImageUploader();
    
            $result = $uploader->upload($request, 'file');
    
            if ($result['error'] !== "") 
                return response()->json(['isSuccess' => false]);
    
            $filename = basename($result['path']);
    
            $image = new Image();
            $image->file_name = $filename;
            $image->file_extension = $request->file('file')->getClientOriginalExtension();
            $image->file_path = $result['path'];
            $image->save();
            
            $post->image_id = $image->id;
        }

        $user = AccountManager::currentUser();

        $post->post_description = $request->post('description');
        $post->publish_date = now();
        $post->user_id = $user->id;

        return response()->json(['isSuccess' => $post->save()]);
    }

    public function likeThread($userId, $postId)
    {
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

    public function deleteThread($postId)
    {
        $image = null;
        $result = true;
        $post = Post::findOrFail($postId);

        if ($post->user != AccountManager::currentUser())
        {
            return ['isSuccess' => false];
        }

        $post->comments()->delete();
        $post->likes()->delete();

        if ($post->image)
        {
            $image = $post->image;
        }
        
        $result = $post->delete();
        if ($result && $image)
        {
            if (Storage::disk('public')->exists($post->image->file_path))
            {
                Storage::disk('public')->delete($post->image->file_path);
            }
            $result = $image->delete();
        }

        return ['isSuccess' => $result];
    }

    public function getPostsByUserId($id)
    {
        $userId = $id;
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

    public function getFollowedUsersPosts($id, $page)
    {
        $perPage = 5;
        $offset = ($page - 1) * $perPage;
        $userId = $id;
        if (!$userId){
            response()->json(['message' => 'KO', 'error' => 'Parametri mancanti'], 400);
        }

        $user = User::find($userId);
        if (!$user){
            response()->json(['message' => 'KO', 'error' => 'Parametri errati'], 400);
        }

        $followedUserIds = $user->followings()->pluck('followed_user_id');

        $postList = Post::whereIn('user_id', $followedUserIds)
            ->orderBy('publish_date', 'desc')
            ->limit($perPage)
            ->offset($offset)
            ->get();
            
        $posts = [];

        foreach ($postList as $post)
        {
            $posts[] = ThreadBL::formatPostAsArray($post);
        }

        return response()->json($posts, 200);
    }

    public function getLikedPosts()
    {
        $user = AccountManager::currentUser();
        if (!$user){
            response()->json(['message' => 'KO', 'error' => 'Non sei loggato'], 400);
        }

        $posts = UserBL::getUserLikedPostsArrayData($user);

        return response()->json($posts, 200);
    }

    public function likedPosts()
    {
        $userInfo = PersonalInfoBL::getSessionUserInfo();
        return view('likedPosts')
        ->with('userInfo', $userInfo)
        ->with('user', AccountManager::currentUser());
    }
}