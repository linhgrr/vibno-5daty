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

    .change-info{
        height: 50%;
    }

    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
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
        <a href="/users/update" class="btn btn-outline-primary change-info">Change info</a>
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
                        <a href="/posts/{{$item->id}}/edit"  type="button" class="btn btn-primary edit">Edit</a>
                        <button type="button" class="btn btn-danger delete">Delete</button>
                    </div>

                        <div class="popup-overlay" id="popup-overlay">
                            <div class="popup">
                                <p>Are you sure you want to delete?</p>
                                <div class="btn-action" style="display:flex;">
                                    <form action="/posts/{{$item->id}}/delete" method="post">
                                        @csrf
                                        <button type="submit" id="confirm-delete" class="btn btn-danger">Yes</button>
                                    </form>
                                    <button type="button" id="cancel-delete" class="btn btn-secondary">No</button>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div id="following" class="tab-content" style="display:none;">
        <div class="post-list" style="display: flex">
            @if(!empty($followings))
                @foreach($followings as $x)
                    <div class="user" style="width: calc(33% - 20px); display: flex">
                        <img class="avatar" src="{{Storage::url($x->avatar)}}" alt="{{$x->name}}">
                        <a href="{{route('user.show', ['id' => $x->id])}}"><h3 class="user-name">{{$x->name}}</h3></a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div id="follower" class="tab-content" style="display:none;">
        <div class="post-list" style="display: flex">
            @if(!empty($followers))
                @foreach($followers as $x)
                    <div class="user" style="width: calc(33% - 20px); display: flex">
                        <img class="avatar" src="{{Storage::url($x->avatar)}}" alt="{{$x->name}}">
                        <a href="{{route('user.show', ['id' => $x->id])}}"><h3 class="user-name">{{$x->name}}</h3></a>
                    </div>
                @endforeach
            @endif
        </div>
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

    document.querySelector('.delete').addEventListener('click', function() {
        document.getElementById('popup-overlay').style.display = 'block';
    });

    document.getElementById('popup-overlay').addEventListener('click', function(event) {
        if (event.target === this) {
            this.style.display = 'none';
        }
    });

    document.getElementById('cancel-delete').addEventListener('click', function() {
        document.getElementById('popup-overlay').style.display = 'none';
    });

    document.getElementById('confirm-delete').addEventListener('click', function() {

        document.getElementById('popup-overlay').style.display = 'none';
    });
</script>
@endsection
