<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('styles/main.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/components.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/login.css') }}">
    <link rel="stylesheet" href="{{ asset('remixicon/remixicon.css') }}">
    <title>Parkeasy - Login</title>
</head>

<body>
    <div class="login-box">
        <div class="login-banner">
            <div class="title">
                <h1>Parkeasy.</h1>
                <p class="fs-18">Set your parking system easily</p>
            </div>
            <div class="media-link pl-40">
                <p><a href=""><i class="ri-instagram-line"></i> Instagram</a> <a href=""><i
                            class="ri-github-fill"></i> github</a></p>
            </div>
        </div>
        <div class="form-box">
            <h1>Login</h1>
            <p class="fs-12 text-desc mb-20">Login untuk menggunakan aplikasi</p>

            <form method="POST" action="{{route('authenticate')}}">
                @csrf
                <div class="input-login">
                    <label for="username" class="mb-6">Username</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="input-login">
                    <label for="password" class="mb-6">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <input type="submit" name="" id="" value="Login" class="login mt-20">

                <div class="form-link">
                    <p><a href=""><i class="ri-instagram-line"></i> Instagram</a> <a href=""><i
                                class="ri-github-fill"></i> github</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
