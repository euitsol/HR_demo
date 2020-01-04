@extends('layouts.joli')
@section('title', 'Applicant')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li><a href="{{route('circular')}}">{{$menu[16]->display_name}}</a></li>
        <li class="active">Applicant</li>
    </ul>
@endsection
@section('pageTitle', 'Applicant')
@section('content')
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if(($a->is_shortlisted * 1) == 0)
                            {{--Not Selected--}}
                            <a href="{{route('select.applicant', ['aid' => $a->id])}}"
                               class="btn btn-sm btn-success">Shortlisted</a>
                            <a href="#" class="btn btn-sm btn-danger disabled">Unselect</a>
                        @else
                            {{--Selected--}}
                            <a href="#" class="btn btn-sm btn-success disabled">Shortlisted</a>
                            <a href="{{route('unselect.applicant', ['aid' => $a->id])}}"
                               class="btn btn-sm btn-danger">Unselect</a>
                        @endif
                        <span class="float-right text-secondary">You can not edit applicant*</span>
                    </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Name</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->name}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Email</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->email}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Father's Name</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->FathersName}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Mother's Name</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->MothersName}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Date Of Birth</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->dob}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Mobile</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->mobile}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Nationality</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->nationality}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group row">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">About Me</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group form-control">
                                        {!! $a->about_me !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Address</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group form-control">
                                        {!! $a->address !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Education</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group form-control">
                                        {!! $a->education !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Employment</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group form-control">
                                        {!! $a->employment !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Skills</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->skills}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Languages</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <p class="form-control">{{$a->languages}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group row">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Reference</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group form-control">
                                        {!! $a->reference !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @if($a->cv != null)
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label text-right pt-2">Download CV</label>
                                    <div class="col-md-6 col-xs-12">
                                        <a href="{{route('downloadApplicantCV', ['aid' => $a->id])}}"
                                           title="Download" style="color: inherit;">
                                            <i class="glyphicon glyphicon-download-alt" style="font-size: 35px;"></i>
                                        </a>
                                    </div>
                                </div>
                            <br>
                            <hr>
                            @endif
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-right pt-2">Image</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <img src="{{asset($a->image)}}" alt="image" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    {{--    <script type='text/javascript' src='{{asset('joli/js/plugins/icheck/icheck.min.js')}}'></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/demo_tables.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>--}}
    {{--        <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>--}}
    <!-- END THIS PAGE PLUGINS-->
@endsection










{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        <div class="row">--}}
{{--            <div class="col mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        --}}{{--                            <div class="col">--}}
{{--                        @if(($a->is_shortlisted * 1) == 0)--}}
{{--                            --}}{{----}}{{--Not Selected--}}
{{--                            <a href="{{route('select.applicant', ['aid' => $a->id])}}"--}}
{{--                               class="btn btn-sm btn-success">Shortlisted</a>--}}
{{--                            <a href="#" class="btn btn-sm btn-danger disabled">Unselect</a>--}}
{{--                        @else--}}
{{--                            --}}{{----}}{{--Selected--}}
{{--                            <a href="#" class="btn btn-sm btn-success disabled">Shortlisted</a>--}}
{{--                            <a href="{{route('unselect.applicant', ['aid' => $a->id])}}"--}}
{{--                               class="btn btn-sm btn-danger">Unselect</a>--}}
{{--                        @endif--}}
{{--                        --}}{{--                            </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Name</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="text" name="name" value="{{$a->name}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('name') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">email</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="email" name="email" value="{{$a->email}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('email') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Father's Name</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="text" name="fathersName" value="{{$a->FathersName}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('fathersName') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Mother's Name</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="text" name="mothersName" value="{{$a->MothersName}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('mothersName') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Date Of Birth</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="date" name="dob" value="{{$a->dob}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('dob') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Mobile</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="text" name="mobile" value="{{$a->mobile}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('mobile') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Nationality</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="text" name="nationality" value="{{$a->nationality}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('nationality') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">About Me</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div class="form-control form-control-success" style="background-color: #e9ecef;">--}}
{{--                                    {!! $a->about_me !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Address</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div class="form-control form-control-success" style="background-color: #e9ecef;">--}}
{{--                                    {!! $a->address !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Education</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div class="form-control form-control-success" style="background-color: #e9ecef;">--}}
{{--                                    {!! $a->education !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Employment</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div class="form-control form-control-success" style="background-color: #e9ecef;">--}}
{{--                                    {!! $a->employment !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Skills</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="text" name="skills" value="{{$a->skills}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('skills') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Languages</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="text" name="languagess" value="{{$a->languages}}"--}}
{{--                                       class="form-control form-control-success {{$errors->has('languagess') ? 'has-error' : ''}}"--}}
{{--                                       readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Reference</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div class="form-control form-control-success" style="background-color: #e9ecef;">--}}
{{--                                    {!! $a->reference !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @if($a->cv != null)--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Download CV</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <a href="{{route('downloadApplicantCV', ['aid' => $a->id])}}"--}}
{{--                                       title="Download" style="color: inherit;">--}}
{{--                                        <i class="far fa-file-alt mr-4" style="font-size: 50px;"></i>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Image</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div>--}}
{{--                                    <img src="{{asset($a->image)}}" alt="image" style="max-height: 150px;">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}