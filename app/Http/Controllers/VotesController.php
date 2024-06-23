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
        $isVoted = $request->input("is_voted");  // Note: make sure the input name matches your Vue component

        if ($isVoted == 0){
            DB::table('votes')->insert([
                'post_id' => $post_id,
                'user_id' => $user_id,
                'vote_type' => 'up',
            ]);
        } else {
            DB::table('votes')
                ->where('user_id', $user_id)
                ->where('post_id', $post_id)
                ->update(['vote_type' => 'up']);
        }

        // Fetch updated vote count and vote status
        $voteDownCount = DB::table('votes')
            ->where('post_id', $post_id)
            ->where('vote_type', 'down')
            ->count();

        $voteUpCount = DB::table('votes')
            ->where('post_id', $post_id)
            ->where('vote_type', 'up')
            ->count();

        $voteCount = $voteUpCount - $voteDownCount;
        $isVoted = 1; // Update vote status

        return response()->json(['voteCount' => $voteCount, 'isVoted' => $isVoted]);
    }

    public function downvote(Request $request){
        $user_id = Auth::user()->id;
        $post_id = $request->input("post_id");
        $isVoted = $request->input("is_voted");  // Note: make sure the input name matches your Vue component

        if ($isVoted == 0){
            DB::table('votes')->insert([
                'post_id' => $post_id,
                'user_id' => $user_id,
                'vote_type' => 'down',
            ]);
        } else {
            DB::table('votes')
                ->where('user_id', $user_id)
                ->where('post_id', $post_id)
                ->update(['vote_type' => 'down']);
        }

        // Fetch updated vote count and vote status
        $voteDownCount = DB::table('votes')
            ->where('post_id', $post_id)
            ->where('vote_type', 'down')
            ->count();

        $voteUpCount = DB::table('votes')
            ->where('post_id', $post_id)
            ->where('vote_type', 'up')
            ->count();

        $voteCount = $voteUpCount - $voteDownCount;

        $isVoted = -1; // Update vote status

        return response()->json(['voteCount' => $voteCount, 'isVoted' => $isVoted]);
    }


    public function unvote(Request $request){
        $user_id = Auth::user()->id;
        $post_id = $request->input("post_id");

        DB::table('votes')
            ->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->delete();

        $voteDownCount = DB::table('votes')
            ->where('post_id', $post_id)
            ->where('vote_type', 'down')
            ->count();

        $voteUpCount = DB::table('votes')
            ->where('post_id', $post_id)
            ->where('vote_type', 'up')
            ->count();

        $voteCount = $voteUpCount - $voteDownCount;


        return response()->json(['voteCount' => $voteCount, 'isVoted' => 0]); // No vote status
    }
}
