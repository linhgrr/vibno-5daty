<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function show($id){
        $user = DB::table('users')->where('id', $id)->first();
        if ($user == null){
            return view('errors.404');
        }
        if (Auth::user()->id != $id){
            $isFollowing = DB::select('select * from follows where follower_id = ? and following_id = ?', [Auth::user()->id, $id]);
        } else $isFollowing = false;
        $posts = DB::table('posts')->where('user_id', $id)->get();
        return view('users.show',[
            'user' => $user,
            'posts' => $posts,
            'isFollowing' => $isFollowing
        ]);
    }
}
