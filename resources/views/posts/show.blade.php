@extends('layouts.app')
@section('content')
    <style>
        main {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 80%;
            min-width: 80%;
            margin: 0px auto;
            display: flex;
        }

        .blog{
            flex: 1;
        }

        .user-vote{
            margin-right: 40px;
            position: sticky;
            top: 0;
            height: 100dvh;
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

        a{
            text-decoration: none;
        }

        .post-title{
            font-size: 40px;
            font-weight: 500;
        }

        .vote-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .vote-button {
            border: none;
            background: none;
            cursor: pointer;
            padding: 10px; /* Thêm padding để tăng kích thước vùng bấm */
        }
        .vote-button:focus {
            outline: none;
        }
        .vote-button svg {
            width: 48px; /* Tăng kích thước SVG */
            height: 48px; /* Tăng kích thước SVG */
            fill: gray;
        }
        .vote-count {
            font-size: 24px;
            color: gray;
            margin: -20px 0;
        }

        .active{
            fill: #4158D0 !important;
        }
    </style>

    <main>
        @auth
            <div class="user-vote">
                <div class="vote-container">
                    <form id="upvoteForm" action="/votes/upvote" method="post">
                        @csrf
                        <input name="post_id" style="display: none" value="{{$post->id}}"></input>
                        <input name="is-voted" style="display: none" value="{{$isVoted}}"></input>

                        <button type="button" class="vote-button" id="upvote">
                            <svg class="{{$isVoted == 1 ? 'active' : ''}}" viewBox="0 0 24 24">
                                <path d="M12 4.5l-7 7h14z"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="vote-count" id="vote-count">{{$voteCount}}</div>

                    <form id="downvoteForm" action="/votes/downvote" method="post">
                        @csrf
                        <input name="post_id" style="display: none" value="{{$post->id}}"></input>
                        <input name="is-voted" style="display: none" value="{{$isVoted}}"></input>

                        <button type="button" class="vote-button" id="downvote">
                            <svg class="{{$isVoted == -1 ? 'active' : ''}}" viewBox="0 0 24 24">
                                <path d="M12 19.5l-7-7h14z"></path>
                            </svg>
                        </button>
                    </form>

                    <form id="myForm" action="/votes/unvote" method="POST">
                        @csrf
                        <input name="post_id" style="display: none" value="{{$post->id}}"></input>
                        <input name="is-voted" style="display: none" value="{{$isVoted}}"></input>
                    </form>

                </div>
            </div>
        @endauth
        <div class="blog">
            <article class="blog-post">
                <a class = "post-author" href="{{ route('user.show', ['id' => $post->user_id]) }}">{{$post->name}}</a>
                <span class="post-meta">{{$post->created_at}}</span>
                <h1 class="post-title">{{$post->title}}</h1>
                <div class="post-content">
                    {!! $post->content !!}
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
                        <input style="display: none" value="{{$post->id}}" name="post-id"></input>
                        <button type="submit">Submit</button>
                    </form>
                @endauth
                @guest
                    <h2>Bạn cần đăng nhập để cmt</h2>
                @endguest
            </section>
        </div>
    </main>

    <script>
        document.getElementById('upvote').addEventListener('click', function(event) {
            var svgElement = this.querySelector('svg');

            if (svgElement.classList.contains('active')) {
                // Ngăn chặn hành động mặc định của form upvote
                event.preventDefault();

                // Gửi form myForm
                document.getElementById('myForm').submit();
            } else {
                // Gửi form upvoteForm
                document.getElementById('upvoteForm').submit();
            }
        });

        document.getElementById('downvote').addEventListener('click', function(event) {
            var svgElement = this.querySelector('svg');

            if (svgElement.classList.contains('active')) {
                // Ngăn chặn hành động mặc định của form downvote
                event.preventDefault();

                // Gửi form myForm
                document.getElementById('myForm').submit();
            } else {
                // Gửi form downvoteForm
                document.getElementById('downvoteForm').submit();
            }
        });
    </script >
@endsection
