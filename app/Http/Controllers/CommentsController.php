<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|integer'
        ]);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->input('post_id');
        $comment->save();

        // Return the newly created comment as JSON
        return response()->json([
            'id' => $comment->id,
            'name' => Auth::user()->name, // Assuming you want to show the author's name
            'created_at' => $comment->created_at->toDateTimeString(),
            'content' => $comment->content
        ]);
    }

}
