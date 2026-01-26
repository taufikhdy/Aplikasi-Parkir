<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('styles/main.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/components.css') }}">
    <link rel="stylesheet" href="{{ asset('remixicon/remixicon.css') }}">
</head>

<body>

    <section class="layout">
        @include('components.sidebar')
        <div class="main">
            @include('components.navbar')
            @yield('content')
        </div>
    </section>

    <script src="{{asset('js/main.js')}}"></script>
</body>

</html>
