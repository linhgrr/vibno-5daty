@extends('layouts.app')
@section('content')
    <style>
        main {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 70%;
            margin: 0px auto;
        }

        .blog-post {
            margin-bottom: 20px;
        }

        .post-title {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .post-meta {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .post-content {
            line-height: 1.8;
            margin-top: 30px;
        }

        .post-author{
            color: rgb(111, 185, 235);
        }

        .comments {
            margin-top: 30px;
        }

        .comment-list {
            list-style-type: none;
            padding: 0;
        }

        .comment {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .comment-meta {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .comment-content {
            margin-top: 5px;
        }

        .comment-form {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .comment-form h4 {
            margin-bottom: 10px;
        }

        .comment-form label {
            display: block;
            margin-bottom: 5px;
        }

        .comment-form input[type="text"],
        .comment-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        .comment-form button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        .comment-form button:hover {
            background-color: #555;
        }
    </style>
    <main>

        <article class="blog-post">
            <span class="post-author">Author: {{$post[0]->name}}</span>
            <span class="post-meta">{{$post[0]->created_at}}</span>
            <h2 class="post-title">{{$post[0]->title}}</h2>
            <div class="post-content">
                {!! $post[0]->content !!}
            </div>
        </article>

        <section class="comments">
            <h3>Comments</h3>

            <ul class="comment-list">
                @foreach($comments as $item)
                    <li class="comment">
                        <div class="comment-meta">
                            <span class="comment-author">{{$item->name}}</span>
                            <span class="comment-date">{{$item->created_at}}</span>
                        </div>
                        <p class="comment-content">{{$item->content}}</p>
                    </li>
                @endforeach
            </ul>
            @auth
                <form class="comment-form" action="/comments" method="post">
                    @csrf
                    <h4>Add a Comment</h4>
                    <label for="comment-content">Comment:</label>
                    <textarea id="comment-content" name="comment-content" rows="4" required></textarea>
                    <input style="display: none" value="{{$post[0]->id}}" name="post-id"></input>
                    <button type="submit">Submit</button>
                </form>
            @endauth
            @guest
                <h2>Bạn cần đăng nhập để cmt</h2>
            @endguest
        </section>
    </main>
@endsection
