<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hr Management System</title>
    <link rel="stylesheet" href="{{asset('bubbly/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('welcome/main.css')}}">
    <link rel="stylesheet" href="{{asset('welcome/responsive.css')}}">
</head>
<body style="background-color: #EFF3F8;">
<section>
    <div id="hero-area" class="hero-area-bg" style='background: url("{{asset('welcome/hero-bg.png')}}"); min-height: 717px;'>
        @auth
            <a href="{{ route('home') }}" class="btn btn-outline-primary text-dark float-right m-4">Home</a>
            <a href="#" class="btn btn-outline-danger btn-sm text-dark m-4"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
            >
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary text-dark float-right m-4">Employee Log In</a>
        @endauth
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="contents text-center">
                        <h2 class="head-title wow fadeInUp">HR Management <br> System</h2>
                        <div class="header-button wow fadeInUp" data-wow-delay="0.3s">
                            <a href="{{route('show-notices')}}" class="btn btn-common">Circulars</a>
                        </div>
                    </div>
                    <div class="img-thumb text-center wow fadeInUp" data-wow-delay="0.6s">
                        <img class="img-fluid" src="{{asset('welcome/hero-1.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>


{{--<!doctype html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--    <head>--}}
{{--        <meta charset="utf-8">--}}
{{--        <meta name="viewport" content="width=device-width, initial-scale=1">--}}

{{--        <title>HR Management</title>--}}

{{--        <!-- Fonts -->--}}
{{--        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">--}}
{{--        <!-- Favicon-->--}}
{{--        <link rel="shortcut icon" href="{{asset('bubbly/img/f.png')}}">--}}
{{--        <!-- Styles -->--}}
{{--        <style>--}}
{{--            html, body {--}}
{{--                background-color: #fff;--}}
{{--                color: #636b6f;--}}
{{--                font-family: 'Nunito', sans-serif;--}}
{{--                font-weight: 200;--}}
{{--                height: 100vh;--}}
{{--                margin: 0;--}}
{{--            }--}}

{{--            .full-height {--}}
{{--                height: 100vh;--}}
{{--            }--}}

{{--            .flex-center {--}}
{{--                align-items: center;--}}
{{--                display: flex;--}}
{{--                justify-content: center;--}}
{{--            }--}}

{{--            .position-ref {--}}
{{--                position: relative;--}}
{{--            }--}}

{{--            .top-right {--}}
{{--                position: absolute;--}}
{{--                right: 10px;--}}
{{--                top: 18px;--}}
{{--            }--}}

{{--            .content {--}}
{{--                text-align: center;--}}
{{--            }--}}

{{--            .title {--}}
{{--                font-size: 84px;--}}
{{--            }--}}

{{--            .links > a {--}}
{{--                color: #636b6f;--}}
{{--                padding: 0 25px;--}}
{{--                font-size: 13px;--}}
{{--                font-weight: 600;--}}
{{--                letter-spacing: .1rem;--}}
{{--                text-decoration: none;--}}
{{--                text-transform: uppercase;--}}
{{--            }--}}

{{--            .m-b-md {--}}
{{--                margin-bottom: 30px;--}}
{{--            }--}}
{{--        </style>--}}
{{--    </head>--}}
{{--    <body>--}}
{{--        <div class="flex-center position-ref full-height">--}}
{{--@if (Route::has('login'))--}}
{{--    <div class="top-right links">--}}
{{--        @auth--}}
{{--            <a href="{{ url('/home') }}">Home</a>--}}
{{--        @else--}}
{{--            <a href="{{ route('login') }}">Login as Employee</a>--}}
{{--            @if (Route::has('register'))--}}
{{--                <a href="{{ route('register') }}">Register</a>--}}
{{--            @endif--}}
{{--        @endauth--}}
{{--    </div>--}}
{{--@endif--}}
{{--            <div class="content">--}}
{{--                <div class="title m-b-md">--}}
{{--                    HR Management System--}}
{{--                </div>--}}
{{--                <div class="links">--}}
{{--                    <a href="{{route('show-notices')}}">Circulars</a>--}}
{{--                    <a href="https://laravel.com/docs">Docs</a>--}}
{{--                    <a href="https://laracasts.com">Laracasts</a>--}}
{{--                    <a href="https://laravel-news.com">News</a>--}}
{{--                    <a href="https://blog.laravel.com">Blog</a>--}}
{{--                    <a href="https://nova.laravel.com">Nova</a>--}}
{{--                    <a href="https://forge.laravel.com">Forge</a>--}}
{{--                    <a href="https://github.com/laravel/laravel">GitHub</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </body>--}}
{{--</html>--}}
