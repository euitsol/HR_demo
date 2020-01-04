<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>Employee Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="icon" href="{{asset('joli/favicon.ico')}}" type="image/x-icon"/>
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" href="{{asset('bubbly/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('joli/css/theme-default.css')}}"/>
    <!-- EOF CSS INCLUDE -->
</head>
<body>

<div class="login-container lightmode">
    @php
        $Office = Storage::disk('local')->get('office');
        $OfficE = json_decode($Office);
    @endphp
    <div class="login-box animated fadeInDown">
        <div>
            <h1 class="text-center text-light">
                <a href="{{url('/')}}" style="text-decoration: none !important; color: inherit !important;">Hr
                    Management System</a>
            </h1>
        </div>
        <div class="login-body">
            <div class="login-title">
                <a href="{{route('notice.view.noAuth', ['nid' => $n->id])}}" style="text-decoration: none !important; color: inherit !important;">
                    <strong>
                        {{$j->title}}
                    </strong>
                </a>
                <span class="text-secondary">{{$j->et}}</span>
            </div>
            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @endif
            <form action="{{route('applicant.login')}}" class="form-horizontal" method="post">
                @csrf
                <input type="hidden" value="{{$n->id}}" name="nid">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="email" name="email"
                               class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                               value="{{old('email')}}" autofocus placeholder="E-mail" required>
                        @if($errors->has('email'))
                            <span class="help-block text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" name="password"
                               class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                               placeholder="Password" required>
                        @if($errors->has('password'))
                            <span class="help-block text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <a href="{{ route('password.request') }}" class="btn btn-link btn-block">Forgot your
                            password?</a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-info btn-block">Log In</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="login-subtitle text-secondary">
                Don't have an account yet? Register below
            </div>
            <br>
            <form action="{{route('applicant.store')}}" class="form-horizontal" method="post">
                @csrf
                <input type="hidden" value="{{$n->id}}" name="nid">
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="form-control-label text-secondary">Email</label>
                        <input type="email" name="email"
                               class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                               value="{{old('email')}}" autofocus placeholder="@" required>
                        @if($errors->has('email'))
                            <span class="help-block text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="form-control-label text-secondary">Password</label>
                        <input type="password" name="password"
                               class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                               placeholder="Password" required>
                        @if($errors->has('password'))
                            <span class="help-block text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="form-control-label text-secondary">Password Confirmation</label>
                        <input type="password" name="password_confirmation"
                               class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                               placeholder="Confirm Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="form-control-label text-secondary">Full Name</label>
                        <input type="text" name="name"
                               class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                               value="{{old('name')}}" placeholder="Full Name" required>
                        @if($errors->has('name'))
                            <span class="help-block text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="form-control-label text-secondary">Date Of Birth</label>
                        <input type="date" name="dateOfBirth"
                               class="form-control datepicker {{$errors->has('dateOfBirth') ? 'is-invalid' : ''}}"
                               value="{{old('dateOfBirth')}}" required>
                        @if($errors->has('dateOfBirth'))
                            <span class="help-block text-danger">{{$errors->first('dateOfBirth')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-info btn-block">Register</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                @if($OfficE && $OfficE->footer)
                {{$OfficE->footer}}
                @else
                &copy; 2020 European IT
                @endif
            </div>
        </div>
    </div>

</div>

</body>
</html>


{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
{{--    <title>HR Management</title>--}}
{{--    <meta name="description" content="">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <meta name="robots" content="all,follow">--}}
{{--    <link rel="stylesheet" href="{{asset('bubbly/vendor/bootstrap/css/bootstrap.min.css')}}">--}}
{{--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">--}}
{{--    <link rel="stylesheet" href="{{asset('bubbly/css/style.default.css')}}" id="theme-stylesheet">--}}
{{--    <link rel="stylesheet" href="{{asset('bubbly/css/custom.css')}}">--}}
{{--    <link rel="shortcut icon" href="{{asset('bubbly/img/f.png')}}">--}}


{{--</head>--}}
{{--<body>--}}
{{--<header class="header">--}}
{{--    <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow" style="min-height: 50px;">--}}
{{--        @php--}}
{{--            $Office = Storage::disk('local')->get('office');--}}
{{--            $OfficE = json_decode($Office);--}}
{{--        @endphp--}}
{{--        <a href="{{url('/')}}" class="navbar-brand font-weight-bold text-uppercase text-base lead">--}}
{{--            @if($OfficE && $OfficE->logo)--}}
{{--                <img src="{{asset($OfficE->logo)}}" alt="logo" style="max-width: 200px;max-height: 72px;">--}}
{{--            @else--}}
{{--                Dashboard--}}
{{--            @endif--}}
{{--        </a>--}}
{{--    </nav>--}}
{{--</header>--}}
{{--<div class="d-flex align-items-stretch">--}}
{{--    <div class="page-holder w-100 d-flex flex-wrap align-items-center">--}}
{{--        <div class="container-fluid px-xl-5">--}}
{{--            <section class="py-5">--}}
{{--                <div class="row align-items-center" style="padding: 0 100px;">--}}
{{--                    <div class="col-lg-5 mb-5">--}}
{{--                        <div class="pr-lg-5">--}}
{{--                            <img src="{{asset('bubbly/img/illustration.svg')}}" alt="" class="img-fluid">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-5 mb-5 pl-5 ml-5">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header">--}}
{{--                                <h3 class="h6 text-uppercase mb-0">{{$j->title}}</h3>--}}
{{--                                <h6 class="h6 text-uppercase mb-0" style="color: #6c757d;">{{$j->et}}</h6>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                @if(session('error'))--}}
{{--                                    <div class="alert alert-danger text-center">--}}
{{--                                        {{session('error')}}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                                <form action="{{route('applicant.login')}}" class="form-horizontal" method="post">--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" value="{{$n->id}}" name="nid">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-md-3 form-control-label">email</label>--}}
{{--                                        <div class="col-md-9">--}}
{{--                                            <input type="email" name="email" value="{{old('email')}}"--}}
{{--                                                   class="form-control form-control-success {{$errors->has('email') ? 'is-invalid' : ''}}"--}}
{{--                                                   required>--}}
{{--                                            @if($errors->has('email'))--}}
{{--                                                <span class="help-block text-danger">{{$errors->first('email')}}</span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-md-3 form-control-label">Password</label>--}}
{{--                                        <div class="col-md-9">--}}
{{--                                            <input type="password" name="password"--}}
{{--                                                   class="form-control form-control-success {{$errors->has('password') ? 'is-invalid' : ''}}"--}}
{{--                                                   required>--}}
{{--                                            @if($errors->has('password'))--}}
{{--                                                <span class="help-block text-danger">{{$errors->first('password')}}</span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <div class="col-md-9 ml-auto">--}}
{{--                                            <button type="submit" class="btn btn-primary btn-block">Login</button>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-9 ml-auto">--}}
{{--                                            <a href="{{ route('password.request') }}">Forgot Your Password ?</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                                <hr>--}}
{{--                                <hr>--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    Do not have an account. Please Register below--}}
{{--                                </div>--}}
{{--                                <br>--}}
{{--                                <div>--}}
{{--                                    <form action="{{route('applicant.store')}}" class="form-horizontal" method="post">--}}
{{--                                        @csrf--}}
{{--                                        <input type="hidden" value="{{$n->id}}" name="nid">--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <label class="col-md-3 form-control-label">Email</label>--}}
{{--                                            <div class="col-md-9">--}}
{{--                                                <input type="email" placeholder="Email address" name="email"--}}
{{--                                                       class="form-control form-control-success {{$errors->has('email') ? 'is-invalid' : ''}}"--}}
{{--                                                       required>--}}
{{--                                                @if($errors->has('email'))--}}
{{--                                                    <span class="help-block text-danger">Someone has already registered with this email address.</span>--}}
{{--                                                @endif--}}
{{--                                                <small class="form-text text-muted ml-3">Duplicate entry is not--}}
{{--                                                    allowed*.--}}
{{--                                                </small>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <label class="col-md-3 form-control-label">Password</label>--}}
{{--                                            <div class="col-md-9">--}}
{{--                                                <input type="password" placeholder="Password" name="password"--}}
{{--                                                       class="form-control form-control-success {{$errors->has('password') ? 'is-invalid' : ''}}"--}}
{{--                                                       required>--}}
{{--                                                @if($errors->has('password'))--}}
{{--                                                    <span class="help-block text-danger">{{$errors->first('password')}}</span>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <label class="col-md-3 form-control-label">Confirm Password</label>--}}
{{--                                            <div class="col-md-9">--}}
{{--                                                <input type="password" placeholder="Confirm Password"--}}
{{--                                                       name="password_confirmation"--}}
{{--                                                       class="form-control form-control-success {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}"--}}
{{--                                                       required>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <label class="col-md-3 form-control-label">Name</label>--}}
{{--                                            <div class="col-md-9">--}}
{{--                                                <input type="text" placeholder="User Name" name="name"--}}
{{--                                                       class="form-control form-control-success {{$errors->has('name') ? 'is-invalid' : ''}}"--}}
{{--                                                       required>--}}
{{--                                                @if($errors->has('name'))--}}
{{--                                                    <span class="help-block text-danger">{{$errors->first('name')}}</span>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <label class="col-md-3 form-control-label">Date Of Birth</label>--}}
{{--                                            <div class="col-md-9">--}}
{{--                                                <input type="date" name="dateOfBirth"--}}
{{--                                                       class="form-control form-control-success {{$errors->has('dateOfBirth') ? 'is-invalid' : ''}}"--}}
{{--                                                       required>--}}
{{--                                                @if($errors->has('dateOfBirth'))--}}
{{--                                                    <span class="help-block text-danger">{{$errors->first('dateOfBirth')}}</span>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <div class="col-md-9 ml-auto">--}}
{{--                                                <button type="submit" class="btn btn-primary btn-block">Register--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </section>--}}
{{--        </div>--}}
{{--        <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">--}}
{{--            <div class="container-fluid">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6 text-center text-md-left text-primary">--}}
{{--                        <p class="mb-2 mb-md-0">--}}
{{--                            @if($OfficE && $OfficE->footer)--}}
{{--                                {{$OfficE->footer}}--}}
{{--                            @else--}}
{{--                                European IT &copy; 2019-2020--}}
{{--                            @endif--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6 text-center text-md-right text-gray-400">--}}
{{--                        <p class="mb-0">Developed by <a href="https://euitsols.com/" target="_blank"--}}
{{--                                                     class="external text-gray-400">European IT</a></p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </footer>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}