@extends('layouts.app')

@section('content')
    <style>
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"], textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .ck-content{
            min-height: 60vh;
        }
    </style>

    <div class="container">
        <form action="/posts/{{$post->id}}/edit-done" method="post">
            @csrf
            <label for="title">Title:</label>
            <input value="{{$post->title}}" type="text" id="title" name="title" required>

            <label for="content">Content:</label>
            <textarea class="content" name="content" id="editor">{{$post->content}}</textarea>

            <button style="margin-top: 30px" class="btn btn-outline-primary" type="submit">Cập nhật bài viết</button>
        </form>
    </div>

    <!-- Load CKEditor from CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
