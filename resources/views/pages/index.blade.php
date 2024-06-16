@extends('layouts.app')
@section('content')
    <style>
        .hero {
            /*background-image: url('hero-background.jpg');*/
            background-size: cover;
            background-position: center;
            padding: 100px 20px;
            text-align: center;
            color: #fff;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 40px;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        /* Recent Posts Section */
        .recent-posts {
            padding: 60px 20px;
        }

        .recent-posts h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .post-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 40px;
        }

        .post-card {
            background-color: #f4f4f4;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .post-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .post-card h3 {
            padding: 20px;
            font-size: 18px;
        }

        .post-card p {
            padding: 0 20px 20px;
            font-size: 16px;
        }

        .post-card .btn {
            display: block;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to Viabno</h1>
                <p>Explore our latest blog posts and insights.</p>
                <a href="#" class="btn">Read More</a>
            </div>
        </section>

        <section class="recent-posts">
            <h2>Recent Posts</h2>
            <div class="post-list">
                <div class="post-card">
                    <img src="post-image-1.jpg" alt="Post 1">
                    <h3>Post 1 Title</h3>
                    <p>Post 1 excerpt...</p>
                    <a href="#" class="btn">Read More</a>
                </div>
                <div class="post-card">
                    <img src="post-image-2.jpg" alt="Post 2">
                    <h3>Post 2 Title</h3>
                    <p>Post 2 excerpt...</p>
                    <a href="#" class="btn">Read More</a>
                </div>
                <div class="post-card">
                    <img src="post-image-3.jpg" alt="Post 3">
                    <h3>Post 3 Title</h3>
                    <p>Post 3 excerpt...</p>
                    <a href="#" class="btn">Read More</a>
                </div>
            </div>
        </section>
    </main>
@endsection
