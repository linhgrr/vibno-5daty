@extends('layouts.app')

@section('content')
    <style>
        * {
            font-family: sans-serif;
        }

        .avatar{
            width: 40px;
            height: 40px;
            border-radius: 999px;
            margin-right: 15px;
        }

        .post-list {
            min-width: 60%;
            max-width: 60%;
            margin: 40px auto;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a::hover{
            color: rgb(111, 185, 235);
        }

        .author {
            color: rgb(111, 185, 235);
            font-size: 12.8px;
        }

        .date {
            color: #888;
            font-size: 12.8px;
        }

        .view {
            color: #888;
            font-size: 14px;
            margin-top: -5px;
        }

        .title {
            font-weight: 500;
            margin-top: 5px;
            font-size: 17.6px;
        }

        .post-card {
            position: relative;
            display: flex;
            /* Đảm bảo rằng phần tử cha có thuộc tính position: relative */
            margin-bottom: 20px;
        }

        .post-card::after {
            content: '';
            position: absolute;
            bottom: 6px;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #ccc;
            /* Sử dụng background-color thay vì color */
        }

        .thumbnail{
            display: flex;
            color: white;
            text-align: center;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background-color: white;
            background-image: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
            height: 100px;
            width: 100vw;
        }

        .navbar-under {
            display: flex;
            justify-content: space-around;
            background-color: black;
            padding: 14px 20px;
            border-bottom: 1px solid white;
        }

        .navbar-under a {
            text-decoration: none;
            color: white;
            padding: 8px 16px;
            position: relative;
            display: inline-block;
        }

        .navbar-under a::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: white;
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .navbar-under a:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .content {
            padding: 20px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <img src="https://images.viblo.asia/full/9bbf02eb-7bf9-49d9-96c5-0a37fbeee91a.png" alt="">

    <div class="thumbnail">
        Tưng bừng khai trương, tăng giá 100%!
    </div>

    <div class="navbar-under">
        <a href="#" onclick="showContent('bai_viet_moi')">Bài viết mới</a>
        @if(Auth::check())
        <a href="#" onclick="showContent('following-post')">Đang theo dõi</a>
        @endif
        <a href="#" onclick="showContent('trending')">Trending</a>
    </div>
    <div class="content">
        <div id="bai_viet_moi" class="tab-content" style = "display: block">
            <div class="post-list">
                @foreach($posts as $item)
                    <div class="post-card">
                        <div class="avatar">
                            <img class = "avatar" src="{{Storage::url($item->avatar)}}" alt="{{$item->name}}">
                        </div>
                        <div class="info">
                            <a href="{{route('user.show', ['id' => $item->user_id])}}"> <span class="author">{{$item->name}}</span></a>
                            <span class="date">{{$item->created_at}}</span>
                            <a href="/posts/{{$item->id}}">
                                <h3 class="title">{{ $item->title }}</h3>
                            </a>
                            <p class="view"><i class="fas fa-eye"></i>{{$item->views}}</i> </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if(Auth::check())
        <div id="following-post" class="tab-content" style="display:none;">
            <div class="post-list">
                @foreach($followingPosts as $item)
                    <div class="post-card">
                        <div class="avatar">
                            <img class = "avatar" src="{{Storage::url($item->avatar)}}" alt="{{$item->name}}">
                        </div>
                        <div class="info">
                            <a href="{{route('user.show', ['id' => $item->user_id])}}"> <span class="author">{{$item->name}}</span></a>
                            <span class="date">{{$item->created_at}}</span>
                            <a href="/posts/{{$item->id}}">
                                <h3 class="title">{{ $item->title }}</h3>
                            </a>
                            <p class="view"><i class="fas fa-eye"></i>{{$item->views}}</i> </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div id="trending" class="tab-content" style = "display: none">
            <div class="post-list">
                @foreach($trendingPosts as $item)
                    <div class="post-card">
                        <div class="avatar">
                            <img class = "avatar" src="{{Storage::url($item->avatar)}}" alt="{{$item->name}}">                        </div>
                        <div class="info">
                            <a href="{{route('user.show', ['id' => $item->user_id])}}"> <span class="author">{{$item->name}}</span></a>
                            <span class="date">{{$item->created_at}}</span>
                            <a href="/posts/{{$item->id}}">
                                <h3 class="title">{{ $item->title }}</h3>
                            </a>
                            <p class="view"><i class="fas fa-eye"></i>{{$item->views}}</i> </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>






    <script>
        function showContent(tabId) {
            // Hide all tab contents
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(function(content) {
                content.style.display = 'none';
            });

            // Show the selected tab content
            const activeTab = document.getElementById(tabId);
            if (activeTab) {
                activeTab.style.display = 'block';
            }
        }

    </script>
@endsection
