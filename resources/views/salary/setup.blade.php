@extends('layouts.joli')
@section('title', 'General Setup')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[6]->display_name}}</li>
        <li class="active">{{$menu[13]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'General Setup')
@section('content')
    <section class="pb-5">
        <div class="row">
            @if(session('SalaryUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('SalaryUpdateSuccess')}}
                </div>
            @endif
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">General Information</h3>
                    </div>
                    <form action="{{route('general.setup.update')}}" class="form-horizontal"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Per Day Working Hour</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="number" value="{{$p->pdwh}}" name="hour" step="0.01" max="16"
                                               min="1"
                                               class="form-control {{$errors->has('hour') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('hour'))
                                        <span class="help-block text-danger">{{$errors->first('hour')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Weekly Holiday</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="weeklyHoliday" required>
                                        <option selected hidden value="{{$p->wh}}">{{$p->wh}}</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                    @if($errors->has('weeklyHoliday'))
                                        <span class="help-block text-danger">{{$errors->first('weeklyHoliday')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Salary Calculation type</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="salaryType" required>
                                        <option selected hidden
                                                value="{{$p->st_is_over}}">{{ (($p->st_is_over * 1) == 1) ? "With Overtime" : "Without Overtime" }}</option>
                                        <option value="1">With Overtime</option>
                                        <option value="0">Without Overtime</option>
                                    </select>
                                    @if($errors->has('salaryType'))
                                        <span class="help-block text-danger">{{$errors->first('salaryType')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                        class="fa fa-refresh"></span></a>
                            <button class="btn btn-primary pull-right">Update</button>
                        </div>
                    </form>
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
@endsection


{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        --}}{{--        @if(session('SalaryUpdateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('SalaryUpdateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">General Information</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('general.setup.update')}}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-2 form-control-label">Per Day Working Hour</label>--}}
{{--                            --}}{{--                                <div class="col-md-10">--}}
{{--                            --}}{{--                                    <input type="number" step="0.01" min="1" max="16" name="hour" value="{{$p->pdwh}}"--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('hour') ? 'has-error' : ''}}"--}}
{{--                            --}}{{--                                           required>--}}
{{--                            --}}{{--                                    @if($errors->has('hour'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('hour')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-2 form-control-label">Weekly Holiday</label>--}}
{{--                            --}}{{--                                <div class="col-md-10">--}}
{{--                            --}}{{--                                    <select class="form-control" name="weeklyHoliday" required>--}}
{{--                            --}}{{--                                        @if($errors->has('weeklyHoliday'))--}}
{{--                            --}}{{--                                            <span class="help-block text-danger">{{$errors->first('weeklyHoliday')}}</span>--}}
{{--                            --}}{{--                                        @endif--}}
{{--                            --}}{{--                                        <option selected hidden value="{{$p->wh}}">{{$p->wh}}</option>--}}
{{--                            --}}{{--                                        <option value="1">1</option>--}}
{{--                            --}}{{--                                        <option value="2">2</option>--}}
{{--                            --}}{{--                                    </select>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-2 form-control-label">Salary Calculation type</label>--}}
{{--                            --}}{{--                                <div class="col-md-10">--}}
{{--                            --}}{{--                                    <select class="form-control" name="salaryType" required>--}}
{{--                            --}}{{--                                        @if($errors->has('salaryType'))--}}
{{--                            --}}{{--                                            <span class="help-block text-danger">{{$errors->first('salaryType')}}</span>--}}
{{--                            --}}{{--                                        @endif--}}
{{--                            --}}{{--                                        <option selected hidden--}}
{{--                            --}}{{--                                                value="{{$p->st_is_over}}">{{ (($p->st_is_over * 1) == 1) ? "With Overtime" : "Without Overtime" }}</option>--}}
{{--                            --}}{{--                                        <option value="1">With Overtime</option>--}}
{{--                            --}}{{--                                        <option value="0">Without Overtime</option>--}}
{{--                            --}}{{--                                    </select>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-10 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Update</button>--}}
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
{{--</body>--}}
{{--</html>--}}