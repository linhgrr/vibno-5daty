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

    .search .search-bar{
        width: 100%;
    }
</style>

    <div class="content">

        <div class="post-list">
            <div class="search" style="margin-bottom: 30px;">
                <form action="/posts/search" method="post">
                    @csrf
                    <div class="search-bar" style="margin-right: 20px;">
                        <input name = "q" type="text" placeholder="search di...">
                        <button type="submit">
                            <img src="https://img.icons8.com/ios-glyphs/30/ffffff/search.png" alt="Search Icon">
                        </button>
                    </div>
                </form>
            </div>

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
@endsection
