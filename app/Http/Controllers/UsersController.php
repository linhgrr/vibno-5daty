<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function show($id){
        $user = DB::table('users')->where('id', $id)->first();
        if ($user == null){
            return view('errors.404');
        }
        $numberOfFollowers = DB::table('follows')->where('following_id', $id)->count();
        if (Auth::user()->id != $id){
            $isFollowing = DB::select('select * from follows where follower_id = ? and following_id = ?', [Auth::user()->id, $id]);
        } else $isFollowing = false;
        $posts = DB::table('posts')->where('user_id', $id)->get();
        $followers = DB::table('follows')->where('following_id', $id)->join('users', 'users.id', '=', 'follows.follower_id')->get();
        $followings = DB::table('follows')->where('follower_id', $id)->join('users', 'users.id', '=', 'follows.following_id')->get();
        return view('users.show',[
            'user' => $user,
            'posts' => $posts,
            'isFollowing' => $isFollowing,
            'numberOfFollowers' => $numberOfFollowers,
            'followers' => $followers,
            'followings' => $followings
        ]);
    }

    public function update()
    {
        return view('users.update');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->file('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Lưu avatar mới
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();

            return back()
                ->with('success', 'Avatar updated successfully.');
        }

        return back()->with('error', 'Avatar update failed.');
    }
}
