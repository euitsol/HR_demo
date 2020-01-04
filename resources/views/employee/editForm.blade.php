@extends('layouts.joli')
@section('title', 'Employee Edit')
@section('link')
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[17]->display_name}}</li>
        <li class="active"><a href="{{route('employee.edit')}}">{{$menu[19]->display_name}}</a></li>
    </ul>
@endsection
@section('pageTitle', 'Employee Edit')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('unsuccess'))
                <div class="alert alert-danger text-center">
                    {{session('unsuccess')}}
                </div>
            @elseif(session('EmployeeUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('EmployeeUpdateSuccess')}}
                </div>
            @endif
            <div class="col-lg-6 offset-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Select Employee</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{route('employee.edit.1')}}" class="form-horizontal" method="post"
                              id="userSelected">
                            @csrf
                            <div class="form-group row">
                                {{--                                <label class="col-md-3 col-xs-12 control-label">Select User</label>--}}
                                <div class="col-md-12 col-xs-12">
                                    <select class="form-control" name="employee_id" id="selectUser" required>
                                        <option selected disabled hidden value="">Select Employee to Edit</option>
                                        @foreach($es as $ee)
                                            <option value="{{$ee->id}}">{{$ee->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Employee</h3>
                    </div>
                    {{--     Form Start              --}}
                    <form action="{{route('employee.update', ['eid' => $e->id])}}" class="form-horizontal" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Email</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="email" value="{{$e->email}}" name="email" required
                                               class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('email'))
                                        <span class="help-block text-danger">Someone has already taken this email address !</span>
                                    @endif
                                    <small class="help-block">Duplicate entry is not allowed*</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Role</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="role" required>
                                        <option selected hidden value="{{$e->role->id}}">
                                            {{$e->role->display_name}}
                                        </option>
                                        @foreach($rs as $i => $r)
                                            @if($i > 3)
                                                <option value="{{$r->id}}">{{$r->display_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if($errors->has('role'))
                                        <span class="help-block text-danger">{{$errors->first('role')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Employee Type</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="employeeType" required>
                                        <option selected hidden
                                                value="{{$e->employeeType_id}}">{{$e->employeeType}}</option>
                                        @foreach($ets as $eee)
                                            <option value="{{$eee->id}}">{{$eee->type}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employeeType'))
                                        <span class="help-block text-danger">{{$errors->first('employeeType')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Full Name</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" value="{{$e->name}}" name="name" required
                                               class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('name'))
                                        <span class="help-block text-danger">{{$errors->first('name')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Father's Name</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" placeholder="Father's Name" name="fathersName" required
                                               value="{{$e->FathersName}}"
                                               class="form-control {{$errors->has('fathersName') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('fathersName'))
                                        <span class="help-block text-danger">{{$errors->first('fathersName')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Mother's Name</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" placeholder="Mother's Name" name="mothersName" required
                                               value="{{$e->MothersName}}"
                                               class="form-control {{$errors->has('mothersName') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('mothersName'))
                                        <span class="help-block text-danger">{{$errors->first('mothersName')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Date Of Birth</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="date" name="dateOfBirth" required
                                               value="{{$e->dob}}"
                                               class="form-control {{$errors->has('dateOfBirth') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('dateOfBirth'))
                                        <span class="help-block text-danger">{{$errors->first('dateOfBirth')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Religion</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="religion" required>
                                        <option selected hidden value="{{$e->religion_id}}">{{$e->religion}}</option>
                                        @foreach($rss as $r)
                                            <option value="{{$r->id}}" {{(old('religion')== $r->id)?'selected':'' }}>{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('religion'))
                                        <span class="help-block text-danger">{{$errors->first('religion')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Mobile</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-phone"
                                                                              style="font-size: 15px;"></span></span>
                                        <input type="text" name="mobile" required value="{{$e->mobile}}"
                                               class="form-control {{$errors->has('mobile') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('mobile'))
                                        <span class="help-block text-danger">{{$errors->first('mobile')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Nationality</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" placeholder="Nationality" name="nationality" required
                                               value="{{$e->nationality}}"
                                               class="form-control {{$errors->has('nationality') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('nationality'))
                                        <span class="help-block text-danger">{{$errors->first('nationality')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">About Me</label>
                                <div class="col-md-6 col-xs-12">
                                    <textarea
                                            class="form-control {{$errors->has('aboutMe') ? 'is-invalid' : ''}}"
                                            rows="5" name="aboutMe" required>
                                        {!! $e->about_me  !!}
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('aboutMe');
                                    </script>
                                    @if($errors->has('aboutMe'))
                                        <span class="help-block text-danger">{{$errors->first('aboutMe')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Address</label>
                                <div class="col-md-6 col-xs-12">
                                    <textarea
                                            class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}"
                                            rows="5" name="address" required>
                                        {!! $e->address !!}
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('address');
                                    </script>
                                    @if($errors->has('address'))
                                        <span class="help-block text-danger">{{$errors->first('address')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Education</label>
                                <div class="col-md-6 col-xs-12">
                                    <textarea
                                            class="form-control {{$errors->has('education') ? 'is-invalid' : ''}}"
                                            rows="5" name="education" required>
                                        {!! $e->education !!}
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('education');
                                    </script>
                                    @if($errors->has('education'))
                                        <span class="help-block text-danger">{{$errors->first('education')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Employment</label>
                                <div class="col-md-6 col-xs-12">
                                    <textarea
                                            class="form-control {{$errors->has('employment') ? 'is-invalid' : ''}}"
                                            rows="5" name="employment" required>
                                        {!! $e->employment !!}
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('employment');
                                    </script>
                                    @if($errors->has('employment'))
                                        <span class="help-block text-danger">{{$errors->first('employment')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Skills</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" placeholder="Skills" name="skills" required
                                               value="{{$e->skills}}"
                                               class="form-control {{$errors->has('skills') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('skills'))
                                        <span class="help-block text-danger">{{$errors->first('skills')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Languages</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" placeholder="Languages" name="languagess" required
                                               value="{{$e->languages}}"
                                               class="form-control {{$errors->has('languagess') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('languagess'))
                                        <span class="help-block text-danger">{{$errors->first('languagess')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Reference</label>
                                <div class="col-md-6 col-xs-12">
                                    <textarea
                                            class="form-control {{$errors->has('reference') ? 'is-invalid' : ''}}"
                                            rows="5" name="reference" required>
                                        {!! $e->reference !!}
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('reference');
                                    </script>
                                    @if($errors->has('reference'))
                                        <span class="help-block text-danger">{{$errors->first('reference')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    @if($eu->image != null)
                                        <img src="{{asset($eu->image)}}" alt="Image"
                                             style="max-height: 150px; max-width: 150px" class="col-md-9">
                                    @else
                                        <img src="{{asset('joli/avatar.png')}}" alt="Image"
                                             style="max-height: 150px; max-width: 150px" class="col-md-9">
                                    @endif
                                </div>
                                <label class="col-md-3 col-xs-12 control-label">Upload Photo</label>
                                <div class="col-md-6 col-xs-12">
                                    <input type="file" name="image">
                                    @if($errors->has('image'))
                                        <span class="help-block text-danger">{{$errors->first('image')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Upload Resume</label>
                                <div class="col-md-6 col-xs-12">
                                    <input type="file" name="cv">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                        class="fa fa-refresh"></span></a>
                            <button class="btn btn-primary pull-right">Update</button>
                        </div>
                    </form>
                    {{--     Form end               --}}
                </div>
            </div>
        </div>
    </section>


@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    {{--    <script type='text/javascript' src='{{asset('joli/js/plugins/icheck/icheck.min.js')}}'></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/demo_tables.js')}}"></script>--}}
    {{--    <script type='text/javascript' src='{{asset('joli/js/plugins/icheck/icheck.min.js')}}'></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>--}}
    <!-- END THIS PAGE PLUGINS-->
    <script>
        $(document).ready(function () {
            $("#selectUser").change((e) => {
                $('#userSelected').submit();
            });
        });
    </script>
@endsection


{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('unsuccess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('unsuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-6 offset-lg-3 pb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Select Employee</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('employee.edit.1')}}" method="post" id="userSelected">--}}
{{--                            @csrf--}}
{{--                            <select class="form-control" name="employee_id" id="selectUser">--}}
{{--                                <option selected disabled hidden value="">Choose...</option>--}}
{{--                                @foreach($es as $ee)--}}
{{--                                    <option value="{{$ee->id}}">{{$ee->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Edit Employee</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('employee.update', ['eid' => $e->id])}}"--}}
{{--                              class="form-horizontal" method="post" enctype="multipart/form-data">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">email</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="email" name="email" value="{{$e->email}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('email') ? 'is-invalid' : ''}}">--}}
{{--                                    <small class="form-text text-muted ml-3">Email has to be unique*--}}
{{--                                    </small>--}}
{{--                                    @if($errors->has('email'))--}}
{{--                                        <span class="help-block text-danger">Someone has already taken this email address !</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="form-control-label col-md-3">Role</label>--}}
{{--                                <div class=" col-md-9">--}}
{{--                                    <select class="form-control" name="role" required>--}}
{{--                                        @if($errors->has('role'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('role')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <option selected hidden value="{{$e->role->id}}">{{$e->role->display_name}}</option>--}}
{{--                                        @foreach($rs as $i => $r)--}}
{{--                                            @if($i > 3)--}}
{{--                                                <option value="{{$r->id}}">{{$r->display_name}}</option>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="form-control-label col-md-3">Employee Type</label>--}}
{{--                                <div class=" col-md-9">--}}
{{--                                    <select class="form-control" name="employeeType" required>--}}
{{--                                        @if($errors->has('employeeType'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('employeeType')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <option selected hidden value="{{$e->employeeType_id}}">{{$e->employeeType}}</option>--}}
{{--                                        @foreach($ets as $et)--}}
{{--                                            <option value="{{$et->id}}">{{$et->type}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Name</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="text" name="name" value="{{$e->name}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('name') ? 'is-invalid' : ''}}">--}}
{{--                                    @if($errors->has('name'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('name')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Father's Name</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="text" name="fathersName" value="{{$e->FathersName}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('fathersName') ? 'is-invalid' : ''}}">--}}
{{--                                    @if($errors->has('fathersName'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('fathersName')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Mother's Name</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="text" name="mothersName" value="{{$e->MothersName}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('mothersName') ? 'is-invalid' : ''}}">--}}
{{--                                    @if($errors->has('mothersName'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('mothersName')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Date Of Birth</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="date" name="dateOfBirth" value="{{$e->dob}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('dateOfBirth') ? 'is-invalid' : ''}}">--}}
{{--                                    @if($errors->has('dateOfBirth'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('dateOfBirth')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="form-control-label col-md-3">Religion</label>--}}
{{--                                <div class=" col-md-9">--}}
{{--                                    <select class="form-control" name="religion" required>--}}
{{--                                        @if($errors->has('religion'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('religion')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <option selected hidden value="{{$e->religion_id}}">{{$e->religion}}</option>--}}
{{--                                        @foreach($rss as $r)--}}
{{--                                            <option value="{{$r->id}}">{{$r->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Mobile</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="text" name="mobile" value="{{$e->mobile}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('mobile') ? 'is-invalid' : ''}}">--}}
{{--                                    @if($errors->has('mobile'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('mobile')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Nationality</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="text" name="nationality" value="{{$e->nationality}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('nationality') ? 'is-invalid' : ''}}">--}}
{{--                                    @if($errors->has('nationality'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('nationality')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">About Me</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                            <textarea--}}
{{--                                                    class="form-control form-control-success {{$errors->has('aboutMe') ? 'is-invalid' : ''}}"--}}
{{--                                                    name="aboutMe" id="" cols="30" rows="4"--}}
{{--                                                    required>{{$e->about_me}}</textarea>--}}
{{--                                    <script>--}}
{{--                                        CKEDITOR.replace('aboutMe');--}}
{{--                                    </script>--}}
{{--                                    @if($errors->has('aboutMe'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('aboutMe')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Address</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                            <textarea--}}
{{--                                                    class="form-control form-control-success {{$errors->has('address') ? 'is-invalid' : ''}}"--}}
{{--                                                    name="address" id="" cols="30" rows="4"--}}
{{--                                                    required>{{$e->address}}</textarea>--}}
{{--                                    <script>--}}
{{--                                        CKEDITOR.replace('address');--}}
{{--                                    </script>--}}
{{--                                    @if($errors->has('address'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('address')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Education</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                            <textarea--}}
{{--                                                    class="form-control form-control-success {{$errors->has('education') ? 'is-invalid' : ''}}"--}}
{{--                                                    name="education" id="" cols="30" rows="4"--}}
{{--                                                    required>{{$e->education}}</textarea>--}}
{{--                                    <script>--}}
{{--                                        CKEDITOR.replace('education');--}}
{{--                                    </script>--}}
{{--                                    @if($errors->has('education'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('education')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Employment</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                            <textarea--}}
{{--                                                    class="form-control form-control-success {{$errors->has('employment') ? 'is-invalid' : ''}}"--}}
{{--                                                    name="employment" id="" cols="30" rows="4"--}}
{{--                                                    required>{{$e->employment}}</textarea>--}}
{{--                                    <script>--}}
{{--                                        CKEDITOR.replace('employment');--}}
{{--                                    </script>--}}
{{--                                    @if($errors->has('employment'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('employment')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Skills</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="text" name="skills" value="{{$e->skills}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('skills') ? 'is-invalid' : ''}}">--}}
{{--                                    @if($errors->has('skills'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('skills')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Languages</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="text" name="languagess" value="{{$e->languages}}" required--}}
{{--                                           class="form-control form-control-success {{$errors->has('languagess') ? 'is-invalid' : ''}}">--}}
{{--                                    @if($errors->has('languagess'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('languagess')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Reference</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                            <textarea--}}
{{--                                                    class="form-control form-control-success {{$errors->has('reference') ? 'is-invalid' : ''}}"--}}
{{--                                                    name="reference" id="" cols="30" rows="4"--}}
{{--                                                    required>{{$e->reference}}</textarea>--}}
{{--                                    <script>--}}
{{--                                        CKEDITOR.replace('reference');--}}
{{--                                    </script>--}}
{{--                                    @if($errors->has('reference'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('reference')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label>Upload Photo</label>--}}
{{--                                <input type="file" class="form-control-file" name="image">--}}
{{--                                @if($errors->has('image'))--}}
{{--                                    <span class="help-block text-danger">{{$errors->first('image')}}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label>Upload Resume</label>--}}
{{--                                <input type="file" class="form-control-file" name="cv">--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary btn-block">Update</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $("#selectUser").change((e) => {--}}
{{--            $('#userSelected').submit();--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}