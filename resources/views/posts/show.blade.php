@extends('layouts.app')
@section('content')
    <style>
        main {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 85%;
            min-width: 85%;
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


        .vote-button svg {
            width: 48px; /* Tăng kích thước SVG */
            height: 48px; /* Tăng kích thước SVG */
            fill: gray;
        }

        .toc {
            padding-left: 15px;
            margin: 20px 0;
            max-width: 200px;
            min-width: 200px;
            position: sticky;
            top: 10px;
            height: 100dvh;
        }
        .toc h3 {
            margin-bottom: 10px;
            font-size: 20px;
        }
        .toc ul {
            list-style: none;
            padding-left: 0;
        }
        .toc ul ul {
            margin-left: 20px;
        }
        .toc li {
            margin: 5px 0;
        }
        .toc li a {
            text-decoration: none;
            color: #333;
            font-weight: normal;
        }
        .toc li a:hover {
            color: #007bff;
        }
        .toc li a.active {
            color: #4285f4;
            font-weight: bold;
        }

        .blog{
            max-width: 90%;
            overflow-x: scroll;
        }

        .blog-content img{
            width: 100%;
            height: auto;
        }
    </style>

    <main id = "app">
        <vote-component
            :authenticated="{{ auth()->check() == 1 }}"
            :post-id="{{ $post->id }}"
            :vote-count="{{ $voteCount }}"
            :is-voted="{{ $isVoted }}">
        </vote-component>


        <div class="blog">
            <article class="blog-post">
                <div class="public" style="display: flex; margin-bottom: 30px;">
                    <div class="avt">
                        <img class="avatar" src="{{Storage::url($post->avatar)}}" alt="{{$post->name}}">
                    </div>
                    <div class="info">
                        <a class = "post-author" href="{{ route('user.show', ['id' => $post->user_id]) }}">{{$post->name}}</a>
                        <span class="post-meta">{{$post->created_at}}</span>
                    </div>
                </div>

                <div class="blog-content">
                    <h1 class="post-title">{{$post->title}}</h1>
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>
                </div>

            </article>





            <section class="comments">
                <h3>Comments</h3>



                    <comment-component
                        :initial-comments="{{ $comments->toJson() }}"
                        :authenticated="{{ auth()->check() }}"
                        :post-id="{{ $post->id }}">
                    </comment-component>


                @guest
                    <h2>Bạn cần đăng nhập để cmt</h2>
                @endguest
            </section>
        </div>

        <div class="toc">
            <h3>MỤC LỤC</h3>
            <div id="toc"></div>
        </div>
    </main>
    <script src="{{mix('js/app.js')}}"></script>


    <script>

        function generateTOC(tocContainer, contentSelector) {
            const content = document.querySelector(contentSelector);
            const headings = content.querySelectorAll('h2, h3, h4, h5, h6');
            const toc = document.createElement('ul');

            headings.forEach((heading, index) => {
                const level = parseInt(heading.tagName.substring(1));
                const listItem = document.createElement('li');
                listItem.style.marginLeft = `${(level - 2) * 20}px`;

                // Generate a unique ID for each heading
                const headingId = `heading-${index}`;
                heading.id = headingId;

                const link = document.createElement('a');
                link.textContent = heading.textContent;
                link.href = `#${headingId}`;
                link.classList.add('toc-link');

                listItem.appendChild(link);
                toc.appendChild(listItem);
            });

            tocContainer.appendChild(toc);

            // Smooth scrolling
            const tocLinks = document.querySelectorAll('.toc-link');
            tocLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);

                    window.scrollTo({
                        top: targetElement.offsetTop - 10, // Adjusted to make sure the target is not hidden behind a fixed header
                        behavior: 'smooth'
                    });
                });
            });

            // Highlighting active link on scroll
            window.addEventListener('scroll', () => {
                const fromTop = window.scrollY;

                tocLinks.forEach(link => {
                    const section = document.querySelector(link.hash);
                    if (section.offsetTop <= fromTop + 10 && section.offsetTop + section.offsetHeight > fromTop + 10) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tocContainer = document.getElementById('toc');
            generateTOC(tocContainer, '.blog-content');
        });
    </script>
@endsection
