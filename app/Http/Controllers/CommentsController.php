<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index(Post $post)
    {
        return $post->comments;
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'post_id' => 'required|exists:posts,id'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'post_id' => $request->post_id,
            'name' => auth()->user()->name,
        ]);

        return response()->json($comment);
    }
}
