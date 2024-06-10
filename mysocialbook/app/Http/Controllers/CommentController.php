<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Request;


class CommentController extends Controller
{
    public function uploadComment()
    {
        $userId = Request::post('user');
        $postId = Request::post('post');
        $content = Request::post('comment_content');

        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->post_id = $postId;
        $comment->content = $content;
        $comment->created_at = now();
        $comment->save();

        return redirect()->back()->with('', 'Commento caricato con successo');
    }
}