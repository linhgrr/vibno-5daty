<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index(){

        return view('comments.index');
    }

    public function store(Request $request){
        $comment = new Comment();
        $comment->content = $request->input('comment-content');
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->input('post-id');
        $comment->timestamps = now();
        $comment->save();

        return redirect()->back();
    }
}
