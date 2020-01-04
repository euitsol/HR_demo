<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HR Management</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('bubbly/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
{{--    <link rel="stylesheet" href="{{asset('css/vendor/all.min.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('css/vendor/fontawesome_v5.3.1.css')}}">--}}
{{--    <script defer src="{{asset('css/vendor/all.min.js')}}"></script>--}}

<!-- Google fonts - Popppins for copy-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">
    <!-- orion icons-->
{{--    <link rel="stylesheet" href="{{asset('bubbly/css/orionicons.css')}}">--}}
<!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('bubbly/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('bubbly/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('bubbly/img/f.png')}}">


    {{--CKEditor /////////////////////////////////////// Not used in ever page /////////////////////////////////////////////--}}
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>


</head>
<body>
<!-- navbar-->
<header class="header">
    @php
        $Office = Storage::disk('local')->get('office');
        $OfficE = json_decode($Office);
    @endphp
    <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow">
        <a href="#" class="sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead">
            <i class="fas fa-align-left"></i></a>
        <a href="{{route('home')}}" class="navbar-brand font-weight-bold text-uppercase text-base">
            @if($OfficE && $OfficE->logo)
                <img src="{{asset($OfficE->logo)}}" alt="logo" style="max-width: 200px;max-height: 72px;">
            @else
                Dashboard
            @endif
        </a>
        <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
{{--            <li class="nav-item dropdown mr-3"><a id="notifications" href="http://example.com" data-toggle="dropdown"--}}
{{--                                                  aria-haspopup="true" aria-expanded="false"--}}
{{--                                                  class="nav-link dropdown-toggle text-gray-400 px-1"><i--}}
{{--                            class="fa fa-bell"></i><span class="notification-icon"></span></a>--}}
{{--                <div aria-labelledby="notifications" class="dropdown-menu"><a href="#" class="dropdown-item">--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <div class="icon icon-sm bg-violet text-white"><i class="fab fa-twitter"></i></div>--}}
{{--                            <div class="text ml-2">--}}
{{--                                <p class="mb-0">You have 2 followers</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a><a href="#" class="dropdown-item">--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <div class="icon icon-sm bg-green text-white"><i class="fas fa-envelope"></i></div>--}}
{{--                            <div class="text ml-2">--}}
{{--                                <p class="mb-0">You have 6 new messages</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a><a href="#" class="dropdown-item">--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <div class="icon icon-sm bg-blue text-white"><i class="fas fa-upload"></i></div>--}}
{{--                            <div class="text ml-2">--}}
{{--                                <p class="mb-0">Server rebooted</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a><a href="#" class="dropdown-item">--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <div class="icon icon-sm bg-violet text-white"><i class="fab fa-twitter"></i></div>--}}
{{--                            <div class="text ml-2">--}}
{{--                                <p class="mb-0">You have 2 followers</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item text-center">--}}
{{--                        <small class="font-weight-bold headings-font-family text-uppercase">View all notifications--}}
{{--                        </small>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item dropdown ml-auto">
                <a id="userInfo" href="http://example.com" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"
                   class="nav-link dropdown-toggle">
                    @php $LoginUser = Auth::user(); @endphp
                    <img
                            @if($LoginUser->image)
                            src="{{asset($LoginUser->image)}}"
                            @else
                            src="{{asset('bubbly/img/avatar.png')}}"
                            @endif
                            alt="{{$LoginUser->name}}"
                            style="max-width: 2.5rem;"
                            class="img-fluid rounded-circle shadow">
                </a>
                <div aria-labelledby="userInfo" class="dropdown-menu"><a href="#" class="dropdown-item"><strong
                                class="d-block text-uppercase headings-font-family">{{Auth::user()->name}}</strong>
                        {{--<small>Web Developer</small>--}}
                    </a>
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">Settings</a>--}}
{{--                    <a href="#" class="dropdown-item">Activity log </a>--}}
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
</header>