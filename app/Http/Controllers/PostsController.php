<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index(){
        $posts = DB::table('posts as p')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.*', 'u.name', 'u.avatar')
            ->orderBy('p.created_at', 'desc')
            ->get();

        $oneWeekAgo = Carbon::now()->subWeek()->toDateString();

        $trendingPosts = DB::table('posts as p')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.*', 'u.name', 'u.avatar')
            ->where('p.created_at', '>=', $oneWeekAgo)
            ->orderBy('p.views', 'desc')
            ->get();

        if (Auth::check()) {
            $followingPosts = DB::table('posts as p')
                ->join('users as u', 'p.user_id', '=', 'u.id')
                ->whereIn('p.user_id', function ($query) {
                    $query->select('following_id')
                        ->from('follows')
                        ->where('follower_id', Auth::user()->id);
                })
                ->select('p.*', 'u.name', 'u.avatar')
                ->orderBy('p.created_at', 'desc')
                ->get();
        } else $followingPosts = null;

        return view('posts.index',[
            'posts' => $posts,
            'followingPosts' => $followingPosts,
            'trendingPosts' => $trendingPosts
        ]);
    }

    public function show($id){
        if (Auth::check()) {
            $user_id = Auth::user()->id;

            $voted = DB::table('votes')
                ->where('post_id', $id)
                ->where('user_id', $user_id)
                ->first();

            if (is_null($voted)) {
                $isVoted = 0;
            } else if ($voted->vote_type == "up") {
                $isVoted = 1;
            } else {
                $isVoted = -1;
            }

            $userUpVotes = DB::table('votes')
                ->where('post_id', $id)
                ->where('vote_type', 'up')
                ->count();

            $userDownVotes = DB::table('votes')
                ->where('post_id', $id)
                ->where('vote_type', 'down')
                ->count();

            $voteCount = $userUpVotes - $userDownVotes;
        } else {
            $isVoted = 0;
            $voteCount = null;
        }

        DB::table('posts')->where('id', $id)->increment('views');
        $post = DB::table('posts as p')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->where('p.id', $id)
            ->select('p.*', 'u.name', 'u.avatar')
            ->first();

        $comments = DB::table('comments as c')
            ->join('users as u', 'c.user_id', '=', 'u.id')
            ->where('c.post_id', $id)
            ->select('c.*', 'u.name', 'u.avatar')
            ->get();

        if ($post == null){
            return redirect(route('posts'));
        }


        return view('posts.show',[
            'post' => $post,
            'comments' => $comments,
            'isVoted' => $isVoted,
            'voteCount' => $voteCount
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request){
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        //3 truong ben duoi can update....
        $post->user_id = Auth::id();
//        okla
        $post->views = 0;
//        save to db
        $post->save();

        return redirect()->route('posts');
    }

    public function update($id){
        $post = DB::table('posts')
                ->where('id', $id)
                ->first();
        if ($post->user_id != Auth::user()->id){
            return redirect('/');
        }

        return view('posts.update', [
            'post'=>$post
        ]);
    }

    public function edit(Request $request, $id)
    {
        $title = $request->input('title');
        $content = $request->input('content');

        DB::table('posts')
            ->where('id', $id)
            ->update(['title' => $title, 'content' => $content]);

        return redirect()->route('post.show', ['id' => $id]);
    }

    public function search(Request $request){
        $search = $request->input('q');
        $posts = DB::table('posts as p')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->where('title', 'like', '%'.$search.'%')
            ->orWhere('content', 'like', '%'.$search.'%')
            ->select('p.*', 'u.name', 'u.avatar')
            ->get();

        return view('search.index', ['posts' => $posts]);
    }

    public function delete($id)
    {
        DB::table('posts')
            ->delete($id);

        return redirect()->back();
    }
}
