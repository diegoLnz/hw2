<?php

namespace App\Http\Controllers;

use App\Extensions\AccountManager;
use App\Models\Post;
use App\BusinessLogic\ThreadBL;

class PostDetailController extends Controller
{
    public function postDetail($id)
    {
        $post = Post::find($id);
        $currentUser = AccountManager::currentUser();
        return view('post-detail')
        ->with('postInfo', $post)
        ->with('currentUser', $currentUser)
        ->with('user', AccountManager::currentUser());
    }

    public function getDetail($id)
    {
        $post = Post::find($id);
        $postDetails = ThreadBL::formatPostAsArray($post);
        return response()->json($postDetails);
    }
}