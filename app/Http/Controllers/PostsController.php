<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class PostsController extends Controller
{
    public function index(){
//        $posts = DB::select('select * from posts');
        $posts = DB::select("select p.*, u.name from posts p
                                join users u on p.user_id = u.id");
        return view('posts.index',[
            'posts' => $posts,
        ]);
    }

    public function show($id){
        DB::table('posts')->where('id', $id)->increment('views');
        $post = DB::select("select p.*, u.name from posts p
                                join users u on p.user_id = u.id
                                where p.id = ?",[$id]);
        $comments = DB::select("select c.*, u.name as name from comments c
                                    join users u on c.user_id = u.id
                                    where post_id = ?",[$id]);

        return view('posts.show',[
            'post' => $post,
            'comments' => $comments,
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
}
