<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HR Management</title>
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
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>

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
                @if(session('unsuccess'))
                    <div class="alert alert-danger text-center">
                        {{session('unsuccess')}}
                    </div>
                @endif
                <div class="row" style="padding: 0 100px;">
                    <div class="col-lg-8 offset-lg-2 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="h6 text-uppercase mb-0">{{$j->title}}</h3>
                                <h6 class="h6 text-uppercase mb-0" style="color: #6c757d;">{{$j->et}}</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{route('apply.submit', ['aid' => $a->id,'nid' => $n->id])}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" value="{{$a->name}}"
                                                   class="form-control form-control-success {{$errors->has('name') ? 'is-invalid' : ''}}"
                                                   required>
                                            @if($errors->has('name'))
                                                <span class="help-block text-danger">{{$errors->first('name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">email</label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" value="{{$a->email}}"
                                                   class="form-control form-control-success {{$errors->has('email') ? 'is-invalid' : ''}}"
                                                   required>
                                            <small class="form-text text-muted ml-3">Email has to be unique*
                                            </small>
                                            @if($errors->has('email'))
                                                {{--<span class="help-block text-danger">{{$errors->first('email')}}</span>--}}
                                                <span class="help-block text-danger">Someone has already applied with this email address !</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Father's Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="fathersName" value="{{$a->FathersName}}"
                                                   class="form-control form-control-success {{$errors->has('fathersName') ? 'is-invalid' : ''}}"
                                                   required>
                                            @if($errors->has('fathersName'))
                                                <span class="help-block text-danger">{{$errors->first('fathersName')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Mother's Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="mothersName" value="{{$a->MothersName}}"
                                                   class="form-control form-control-success {{$errors->has('mothersName') ? 'is-invalid' : ''}}"
                                                   required>
                                            @if($errors->has('mothersName'))
                                                <span class="help-block text-danger">{{$errors->first('mothersName')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Date Of Birth</label>
                                        <div class="col-md-9">
                                            <input type="date" name="dateOfBirth" value="{{$a->dob}}"
                                                   class="form-control form-control-success {{$errors->has('dateOfBirth') ? 'is-invalid' : ''}}"
                                                   required>
                                            @if($errors->has('dateOfBirth'))
                                                <span class="help-block text-danger">{{$errors->first('dateOfBirth')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Mobile</label>
                                        <div class="col-md-9">
                                            <input type="text" name="mobile" value="{{$a->mobile}}"
                                                   class="form-control form-control-success {{$errors->has('mobile') ? 'is-invalid' : ''}}"
                                                   required>
                                            @if($errors->has('mobile'))
                                                <span class="help-block text-danger">{{$errors->first('mobile')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Nationality</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nationality" value="{{$a->nationality}}"
                                                   class="form-control form-control-success {{$errors->has('nationality') ? 'is-invalid' : ''}}"
                                                   required>
                                            @if($errors->has('nationality'))
                                                <span class="help-block text-danger">{{$errors->first('nationality')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">About Me</label>
                                        <div class="col-md-9">
                                            <textarea
                                                class="form-control form-control-success {{$errors->has('aboutMe') ? 'is-invalid' : ''}}"
                                                name="aboutMe" id="" cols="30" rows="4" required>{{$a->about_me}}</textarea>
                                            <script>
                                                CKEDITOR.replace('aboutMe');
                                            </script>
                                            @if($errors->has('aboutMe'))
                                                <span class="help-block text-danger">{{$errors->first('aboutMe')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Address</label>
                                        <div class="col-md-9">
                                            <textarea
                                                class="form-control form-control-success {{$errors->has('address') ? 'is-invalid' : ''}}"
                                                name="address" id="" cols="30" rows="4" required>{{$a->address}}</textarea>
                                            <script>
                                                CKEDITOR.replace('address');
                                            </script>
                                            @if($errors->has('address'))
                                                <span class="help-block text-danger">{{$errors->first('address')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Education</label>
                                        <div class="col-md-9">
                                            <textarea
                                                class="form-control form-control-success {{$errors->has('education') ? 'is-invalid' : ''}}"
                                                name="education" id="" cols="30" rows="4" required>{{$a->education}}</textarea>
                                            <script>
                                                CKEDITOR.replace('education');
                                            </script>
                                            @if($errors->has('education'))
                                                <span class="help-block text-danger">{{$errors->first('education')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Employment</label>
                                        <div class="col-md-9">
                                            <textarea
                                                class="form-control form-control-success {{$errors->has('employment') ? 'is-invalid' : ''}}"
                                                name="employment" id="" cols="30" rows="4" required>{{$a->employment}}</textarea>
                                            <script>
                                                CKEDITOR.replace('employment');
                                            </script>
                                            @if($errors->has('employment'))
                                                <span class="help-block text-danger">{{$errors->first('employment')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Skills</label>
                                        <div class="col-md-9">
                                            <input type="text" name="skills" value="{{$a->skills}}"
                                                   class="form-control form-control-success {{$errors->has('skills') ? 'is-invalid' : ''}}"
                                                   required>
                                            @if($errors->has('skills'))
                                                <span class="help-block text-danger">{{$errors->first('skills')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Languages</label>
                                        <div class="col-md-9">
                                            <input type="text" name="languagess" value="{{$a->languages}}"
                                                   class="form-control form-control-success {{$errors->has('languagess') ? 'is-invalid' : ''}}"
                                                   required>
                                            @if($errors->has('languagess'))
                                                <span class="help-block text-danger">{{$errors->first('languagess')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Reference</label>
                                        <div class="col-md-9">
                                            <textarea
                                                class="form-control form-control-success {{$errors->has('reference') ? 'is-invalid' : ''}}"
                                                name="reference" id="" cols="30" rows="4" required>{{$a->reference}}</textarea>
                                            <script>
                                                CKEDITOR.replace('reference');
                                            </script>
                                            @if($errors->has('reference'))
                                                <span class="help-block text-danger">{{$errors->first('reference')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label>Upload Photo</label>
                                        <input type="file" class="form-control-file" name="image" required>
                                        @if($errors->has('image'))
                                            <span class="help-block text-danger">{{$errors->first('image')}}</span>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <label>Upload Resume</label>
                                        <input type="file" class="form-control-file" name="cv">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
                                        </div>
                                    </div>
                                </form>
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