<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function uploadComment(Request $request)
    {
        $requestData = $request->validate([
            'user' => 'required',
            'post' => 'required',
            'comment_content' => 'required|string|max:100'
        ], [
            'user.required' => 'Il campo utente è obbligatorio.',
            'post.required' => 'Il campo post è obbligatorio.',
            'comment_content.required' => 'Il contenuto del commento è obbligatorio.',
            'comment_content.string' => 'Il contenuto del commento deve essere una stringa.',
            'comment_content.max' => 'Il contenuto del commento non può superare i 100 caratteri.'
        ]);

        $comment = new Comment();
        $comment->user_id = $requestData['user'];
        $comment->post_id = $requestData['post'];
        $comment->content = $requestData['comment_content'];
        $comment->created_at = now();
        $comment->save();

        return redirect()->back()->with('', 'Commento caricato con successo');
    }
}