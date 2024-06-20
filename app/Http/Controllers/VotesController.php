<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VotesController extends Controller
{
    public function upvote(Request $request){
        $user_id = Auth::user()->id;
        $post_id = $request->input("post_id");
        $isVoted = $request->input("is-voted");

        if ($isVoted == 0){
            DB::table('votes')->insert([
                'post_id' => $post_id,
                'user_id' => $user_id,
                'vote_type' => 'up',
            ]);
        }else{
            DB::table('votes')
                ->where('user_id', $user_id)
                ->where('post_id', $post_id)
                ->update(['vote_type' => 'up']);
        }

        return redirect()->back();
    }

    public function downvote(Request $request){
        $user_id = Auth::user()->id;
        $post_id = $request->input("post_id");
        $isVoted = $request->input("is-voted");

        if ($isVoted == 0){
            DB::table('votes')->insert([
                'post_id' => $post_id,
                'user_id' => $user_id,
                'vote_type' => 'down',
            ]);
        }else{
            DB::table('votes')
                ->where('user_id', $user_id)
                ->where('post_id', $post_id)
                ->update(['vote_type' => 'down']);
        }

        return redirect()->back();
    }

    public function unvote(Request $request){
        $user_id = Auth::user()->id;
        $post_id = $request->input("post_id");

        DB::select("DELETE FROM votes WHERE user_id = $user_id AND post_id = $post_id");
        return redirect()->back();
    }
}
