@extends('layouts.app')
@section('content')
    <style>
        .content  {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            height: 100vh;
            padding-top: 20px;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar nav ul li {
            padding: 0;
            position: relative;
        }

        .sidebar nav ul li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar nav ul li a:hover {
            background-color: #7397ba;
            color: #fff;
        }

        .sidebar nav ul ul {
            list-style-type: none;
            padding-left: 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .sidebar nav ul ul.nested {
            max-height: 0;
        }

        .sidebar nav ul ul.nested.open {
            max-height: 500px;
            transition: max-height 0.5s ease-in;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        form div {
            margin-bottom: 15px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="file"] {
            display: block;
        }

        form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #9abbde;
        }

        .content-section {
            display: none;
        }

        .avatar{
            height: 100px;
            width: 100px;
        }

        .update-info{
            margin-right: 400px;
        }

        .main-edit {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .update-info, .upload-avt {
            width: 45%;
        }
        .update-info label, .upload-avt label {
            display: block;
            margin: 10px 0 5px;
        }
        .update-info input, .upload-avt input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .update-info button, .upload-avt button {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .upload-avt img {
            display: block;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

    </style>
    <div class="content">
        <div class="sidebar">
            <nav>
                <ul>
                    <li><a href="#" onclick="toggleSection('infoSection')">Thông Tin Của Tôi</a>
                        <ul id="infoSection" class="nested">
                            <li><a href="#" onclick="showContent('personalInfo')">Thông Tin Cá Nhân</a></li>
                        </ul>
                    </li>
                    <li><a href="#" onclick="toggleSection('securitySection')">Bảo Mật</a>
                        <ul id="securitySection" class="nested">
                            <li><a href="#" onclick="showContent('password')">Mật Khẩu</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <div id="personalInfo" class="content-section" style="margin-left: 30px; display: block">
                <h1>Thông Tin Cá Nhân</h1>
                <div class="main-edit" style="display: flex">
                    <div class="update-info">
                        <form action="/users/edit" method="post">
                            @csrf
                            <label for="name">Tên người dùng</label>
                            <input type="text" name="name"></input>
                            <label for="email">Email</label>
                            <input type="email" name="email"></input>
                            <button style="display: block; margin-top: 20px" type="submit" class="btn btn-outline-info">Cập nhật</button>
                        </form>
                    </div>

                    <div class="upload-avt">
                        <img class="avatar" src="{{ Storage::url(auth()->user()->avatar) }}" alt="User Avatar">

                        <form action="{{ route('avatar.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="avatar">Choose an avatar:</label>
                                <input type="file" name="avatar" id="avatar" required>
                            </div>
                            <div>
                                <button type="submit">Update Avatar</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div id="password" class="content-section" style="display:none;">
                <h1>Mật Khẩu</h1>
                <div class="card">
                    <div class="card-header">{{ __('Đổi Mật Khẩu') }}</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="current-password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu hiện tại') }}</label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control @error('current-password') is-invalid @enderror" name="current-password" required>

                                    @error('current-password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new-password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu mới') }}</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control @error('new-password') is-invalid @enderror" name="new-password" required>

                                    @error('new-password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new-password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Xác nhận mật khẩu mới') }}</label>

                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Đổi mật khẩu') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function toggleSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section.classList.contains('open')) {
            section.classList.remove('open');
        } else {
            section.classList.add('open');
        }
    }

    function showContent(contentId) {
        const sections = document.getElementsByClassName('content-section');
        for (let section of sections) {
            section.style.display = "none";
        }
        document.getElementById(contentId).style.display = "block";
    }


</script>
@endsection
