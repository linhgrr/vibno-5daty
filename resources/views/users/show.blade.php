@extends('layouts.app')
@section('content')
<style>
    .navbar {
        display: flex;
        justify-content: space-around;
        background-color: #fff;
        padding: 14px 20px;
        border-bottom: 1px solid #ccc;
    }

    .navbar a {
        text-decoration: none;
        color: #555;
        padding: 8px 16px;
        position: relative;
        display: inline-block;
        transition: color 0.3s ease;
    }

    .navbar a:hover,
    .navbar a.active {
        color: #0073e6;
    }

    .navbar a::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: #0073e6;
        transform-origin: bottom right;
        transition: transform 0.3s ease-out;
    }

    .navbar a:hover::after,
    .navbar a.active::after {
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
    .infomation{
        margin: 20px auto;
        max-width: 80%;
        display: flex;
        justify-content: space-between;
    }

    .personal{
        display: flex;
    }

    .infomation button{
        display: block;
    }

    .function{
        margin-left: auto;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />


<div class="infomation">
    <div class="personal">
        <img src="{{Storage::url($user->avatar)}}" class="avatar" alt="{{$user->name}}"></img>
        <div class="thong-tin">
            <h1 class="name">{{$user->name}}</h1>
            <p class="follower">{{$numberOfFollowers}} follower</p>
        </div>
    </div>

    @if(Auth::user()->id != $user->id)
        @if($isFollowing)

            <form action="/follows/unfollow" method="post">
                @csrf
                <input name = "following" type="text" style="display: none" value="{{$user->id}}">
                <input name = "follower" type="text" style="display: none" value="{{Auth::user()->id}}">
                <button class="btn btn-outline-primary">Unfollow</button>
            </form>

        @else

            @method('PUT')
            <form action="/follows/follow" method="post">
                @csrf
                <input name = "following" type="text" style="display: none" value="{{$user->id}}">
                <input name = "follower" type="text" style="display: none" value="{{Auth::user()->id}}">
                <button class="btn btn-outline-primary">Follow</button>
            </form>

        @endif
    @else
        <a href="/users/update" class="btn btn-outline-primary">Change info</a>
    @endif

</div>

<div class="navbar">
    <a href="#" onclick="showContent('bai_viet')">Bài viết</a>
    <a href="#" onclick="showContent('following')">Đang theo dõi</a>
    <a href="#" onclick="showContent('follower')">Người theo dõi</a>
</div>
<div class="content">
    <div id="bai_viet" class="tab-content" style="display: block">
        <div class="post-list">
            @foreach($posts as $item)
                <div class="post-card">
                    <div class="avatar">
                        <img class="avatar" src="{{Storage::url($user->avatar)}}" alt="{{$user->name}}">
                    </div>
                    <div class="info">
                        <span class="date">{{$item->created_at}}</span>
                        <a href="/posts/{{$item->id}}">
                            <h3 class="title">{{ $item->title }}</h3>
                        </a>
                        <p class="view"><i class="fas fa-eye"></i>{{$item->views}}</i> </p>
                    </div>
                    @if(Auth::user()->id == $user->id)
                    <div class="function">
                        <button  type="button" class="btn btn-primary edit">Edit</button>
                        <button type="button" class="btn btn-danger delete">Danger</button>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div id="following" class="tab-content" style="display:none;">
        @if(!empty($followings))
            @foreach($followings as $x)
                <h2>{{$x->name}}</h2>
            @endforeach
        @endif
    </div>
    <div id="follower" class="tab-content" style="display:none;">
        @if(!empty($followers))
            @foreach($followers as $x)
                <h2>{{$x->name}}</h2>
            @endforeach
        @endif
    </div>
</div>

<script>
    function showContent(tabId) {
        // Hide all tab contents
        var contents = document.querySelectorAll('.tab-content');
        contents.forEach(function(content) {
            content.style.display = 'none';
        });

        // Show the selected tab content
        var activeTab = document.getElementById(tabId);
        if (activeTab) {
            activeTab.style.display = 'block';
        }
    }

</script>
@endsection
