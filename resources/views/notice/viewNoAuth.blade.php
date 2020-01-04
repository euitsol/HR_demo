<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HR Management Circular</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="{{asset('bubbly/vendor/bootstrap/css/bootstrap.min.css')}}">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"--}}
    {{--integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">
    <link rel="stylesheet" href="{{asset('bubbly/css/style.default.css')}}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{asset('bubbly/css/custom.css')}}">
    <link rel="shortcut icon" href="{{asset('bubbly/img/f.png')}}">

    {{--CKEditor--}}
    {{--<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>--}}

</head>
<body>
<header class="header">
    <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow" style="min-height: 50px;">
        @php
            $Office = Storage::disk('local')->get('office');
            $OfficE = json_decode($Office);
        @endphp
        <a href="{{url('/')}}" class="navbar-brand font-weight-bold text-uppercase text-base lead">
            @if($OfficE && $OfficE->logo)
                <img src="{{asset($OfficE->logo)}}" alt="logo" style="max-width: 200px;max-height: 72px;">
            @else
                Dashboard
            @endif
        </a>
        @if(Auth::guard('applicant')->id())
            <p class="text-secondary" style="position: absolute;right: 200px;">Hi, {{$applicantName}}</p>
            <a href="{{route('applicant.logout')}}" class="btn btn-sm btn-outline-primary"
               style="position: absolute;right: 50px;">Logout</a>
        @else
            <a href="{{route('applicant.login')}}" class="btn btn-sm btn-outline-primary"
               style="position: absolute;right: 50px;">Login</a>
        @endif
    </nav>
</header>
<div class="d-flex align-items-stretch">
    <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">
                @if(session('ApplySuccess'))
                    <div class="alert alert-success text-center">
                        {{session('ApplySuccess')}}
                    </div>
                @endif
                <div class="row">
                    <div class="col mb-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="h6 text-uppercase mb-0">{{$t}}</h3>
                                <h6>{{$n->branchTitle}} Branch, {{$n->type}}</h6>
                            </div>
                            <div class="card-body">
                                {!! $n->notice !!}
                            </div>
                            <div class="card-footer">
                                @if($n->is_applied == 0)
                                    <a href="{{route('apply', ['nid' => $n->id])}}"
                                       class="btn btn-primary btn-sm">Apply</a>
                                @else
                                    <a href="#" class="btn btn-outline-primary btn-sm disabled">Already Applied</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 text-center text-md-left text-primary">
                        <p class="mb-2 mb-md-0">
                            @if($OfficE && $OfficE->footer)
                                {{$OfficE->footer}}
                            @else
                                European IT &copy; 2019-2020
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-right text-gray-400">
                        <p class="mb-0">Developed by <a href="https://euitsols.com/" target="_blank"
                                                     class="external text-gray-400">European IT</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
{{--<script src="{{asset('bubbly/vendor/jquery/jquery.min.js')}}"></script>--}}
{{--<script src="{{asset('bubbly/vendor/popper.js/umd/popper.min.js')}}"></script>--}}
{{--<script src="{{asset('bubbly/vendor/bootstrap/js/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{asset('bubbly/vendor/jquery.cookie/jquery.cookie.js')}}"></script>--}}
{{--<script src="{{asset('bubbly/vendor/chart.js/Chart.min.js')}}"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>--}}
{{--<script src="{{asset('bubbly/js/charts-home.js')}}"></script>--}}
{{--<script src="{{asset('bubbly/js/front.js')}}"></script>--}}


</body>
</html>