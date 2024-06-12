<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function uploadComment(Request $request)
    {
        $userId = $request->post('user');
        $postId = $request->post('post');
        $content = $request->post('comment_content');

        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->post_id = $postId;
        $comment->content = $content;
        $comment->created_at = now();
        $comment->save();

        return redirect()->back()->with('', 'Commento caricato con successo');
    }
}