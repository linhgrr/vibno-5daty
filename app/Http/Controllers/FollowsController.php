<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowsController extends Controller
{
    public function follow(Request $request): \Illuminate\Http\RedirectResponse
    {
        $following = $request->input('following');
        $follower = $request->input('follower');

        DB::insert("insert into follows (follower_id, following_id) values('$follower','$following')");
        return redirect()->back();
    }

    public function unfollow(Request $request){
        $following = $request->input('following');
        $follower = $request->input('follower');
        DB::delete("delete from follows where following_id='$following' and follower_id='$follower'");

        return redirect()->back();
    }
}
