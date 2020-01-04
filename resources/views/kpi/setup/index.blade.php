@extends('layouts.joli')
@section('title', 'KPI Setup')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[48]->display_name}}</li>
        <li class="active">{{$menu[49]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'KPI Setup')
@section('content')
    <div class="row mb-5">
        @if(session('updateSuccess'))
            <div class="alert alert-success text-center">
                {{session('updateSuccess')}}
            </div>
        @elseif(session('kpiVotingOn'))
            <div class="alert alert-success text-center">
                {{session('kpiVotingOn')}}
            </div>
        @elseif(session('unsuccess'))
            <div class="alert alert-danger text-center">
                {{session('unsuccess')}}
            </div>
        @endif
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{--                    <h3 class="panel-title">KPI Setup</h3>--}}
                    <a href="{{route('kpi.voting.on')}}" class="btn btn-block btn-info"
                       onclick="return confirm('Are You Sure ?')">
                        Turn Onn Voting System
                    </a>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('kpi.setup.update')}}" class="form-horizontal" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Attendance</label>
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$setup->attendance}}" name="attendanceTotal"
                                           required min="0"
                                           class="form-control {{$errors->has('attendanceTotal') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">Total</span>
                                </div>
                                @if($errors->has('attendanceTotal'))
                                    <span class="help-block text-danger">{{$errors->first('attendanceTotal')}}</span>
                                @endif
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$setup->attendanceTarget}}" name="attendanceTarget"
                                           required min="0"
                                           class="form-control {{$errors->has('attendanceTarget') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">Target</span>
                                </div>
                                @if($errors->has('attendanceTarget'))
                                    <span class="help-block text-danger">{{$errors->first('attendanceTarget')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Attitude</label>
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$setup->attitude}}" name="attitudeTotal"
                                           required min="0"
                                           class="form-control {{$errors->has('attitudeTotal') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">Total</span>
                                </div>
                                @if($errors->has('attitudeTotal'))
                                    <span class="help-block text-danger">{{$errors->first('attitudeTotal')}}</span>
                                @endif
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$setup->attitudeTarget}}" name="attitudeTarget"
                                           required min="0"
                                           class="form-control {{$errors->has('attitudeTarget') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">Target</span>
                                </div>
                                @if($errors->has('attitudeTarget'))
                                    <span class="help-block text-danger">{{$errors->first('attitudeTarget')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Performance</label>
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$setup->performance}}" name="projectTotal"
                                           required min="0"
                                           class="form-control {{$errors->has('projectTotal') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">Total</span>
                                </div>
                                @if($errors->has('projectTotal'))
                                    <span class="help-block text-danger">{{$errors->first('projectTotal')}}</span>
                                @endif
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$setup->performanceTarget}}" name="projectTarget"
                                           required min="0"
                                           class="form-control {{$errors->has('projectTarget') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">Target</span>
                                </div>
                                @if($errors->has('projectTarget'))
                                    <span class="help-block text-danger">{{$errors->first('projectTarget')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Promotion</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$setup->promotion}}" min="1" max="100"
                                           name="promotion" required
                                           class="form-control {{$errors->has('promotion') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">%</span>
                                </div>
                                @if($errors->has('promotion'))
                                    <span class="help-block text-danger">{{$errors->first('promotion')}}</span>
                                @endif
                                <small class="help-block">Hierarchy percentage. Max value is 100*.</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Performance Chain</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$setup->chain}}" min="0" max="100"
                                           name="chain" required
                                           class="form-control {{$errors->has('chain') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">%</span>
                                </div>
                                @if($errors->has('chain'))
                                    <span class="help-block text-danger">{{$errors->first('chain')}}</span>
                                @endif
                                <small class="help-block">Performance Hierarchy effect percentage. Max value is 100*.
                                </small>
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
{{--        @if(session('updateSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('updateSuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('kpiVotingOn'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('kpiVotingOn')}}--}}
{{--            </div>--}}
{{--        @elseif(session('unsuccess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('unsuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <a href="{{route('kpi.voting.on')}}" class="btn btn-block btn-primary"--}}
{{--                   onclick="return confirm('Are You Sure ?')">Turn Onn Voting System</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        --}}{{--                                                <h3 class="h6 text-uppercase mb-0">KPI Setup</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        --}}{{--                                                <form action="{{route('kpi.setup.update')}}" class="form-horizontal" method="post">--}}
{{--                        @csrf--}}
{{--                        <div class="form-group row">--}}
{{--                            --}}{{--                                                            <label class="col-md-2 form-control-label"><b>Attendance</b></label>--}}
{{--                            --}}{{--                                                            <div class="col-md-5">--}}
{{--                            --}}{{--                                                                <label class="form-control-label">Total</label>--}}
{{--                            --}}{{--                                                                <input type="number" value="{{$setup->attendance}}" name="attendanceTotal" min="0"--}}
{{--                            --}}{{--                                                                       class="form-control form-control-success {{$errors->has('attendanceTotal') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                                                       required>--}}
{{--                            --}}{{--                                                                @if($errors->has('attendanceTotal'))--}}
{{--                            --}}{{--                                                                    <span class="help-block text-danger">{{$errors->first('attendanceTotal')}}</span>--}}
{{--                            --}}{{--                                                                @endif--}}
{{--                            --}}{{--                                                            </div>--}}
{{--                            --}}{{--                            <div class="col-md-5">--}}
{{--                            --}}{{--                                <label class="form-control-label">Target</label>--}}
{{--                            --}}{{--                                <input type="number" value="{{$setup->attendanceTarget}}" name="attendanceTarget"--}}
{{--                            --}}{{--                                       min="0"--}}
{{--                            --}}{{--                                       class="form-control form-control-success {{$errors->has('attendanceTarget') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                       required>--}}
{{--                            --}}{{--                                @if($errors->has('attendanceTarget'))--}}
{{--                            --}}{{--                                    <span class="help-block text-danger">{{$errors->first('attendanceTarget')}}</span>--}}
{{--                            --}}{{--                                @endif--}}
{{--                            --}}{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            --}}{{--                            <label class="col-md-2 form-control-label"><b>Attitude</b></label>--}}
{{--                            --}}{{--                            <div class="col-md-5">--}}
{{--                            --}}{{--                                <label class="form-control-label">Total</label>--}}
{{--                            --}}{{--                                <input type="number" value="{{$setup->attitude}}" name="attitudeTotal" min="0"--}}
{{--                            --}}{{--                                       class="form-control form-control-success {{$errors->has('attitudeTotal') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                       required>--}}
{{--                            --}}{{--                                @if($errors->has('attitudeTotal'))--}}
{{--                            --}}{{--                                    <span class="help-block text-danger">{{$errors->first('attitudeTotal')}}</span>--}}
{{--                            --}}{{--                                @endif--}}
{{--                            --}}{{--                            </div>--}}
{{--                            <div class="col-md-5">--}}
{{--                                --}}{{--                                <label class="form-control-label">Target</label>--}}
{{--                                --}}{{--                                <input type="number" value="{{$setup->attitudeTarget}}" name="attitudeTarget"--}}
{{--                                --}}{{--                                       min="0"--}}
{{--                                --}}{{--                                       class="form-control form-control-success {{$errors->has('attitudeTarget') ? 'is-invalid' : ''}}"--}}
{{--                                --}}{{--                                       required>--}}
{{--                                --}}{{--                                @if($errors->has('attitudeTarget'))--}}
{{--                                --}}{{--                                    <span class="help-block text-danger">{{$errors->first('attitudeTarget')}}</span>--}}
{{--                                --}}{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            --}}{{--                            <label class="col-md-2 form-control-label"><b>Performance</b></label>--}}
{{--                            --}}{{--                            <div class="col-md-5">--}}
{{--                            --}}{{--                                <label class="form-control-label">Total</label>--}}
{{--                            --}}{{--                                <input type="number" value="{{$setup->performance}}" name="projectTotal" min="0"--}}
{{--                            --}}{{--                                       class="form-control form-control-success {{$errors->has('projectTotal') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                       required>--}}
{{--                            --}}{{--                                @if($errors->has('projectTotal'))--}}
{{--                            --}}{{--                                    <span class="help-block text-danger">{{$errors->first('projectTotal')}}</span>--}}
{{--                            --}}{{--                                @endif--}}
{{--                            --}}{{--                            </div>--}}
{{--                            <div class="col-md-5">--}}
{{--                                --}}{{--                                <label class="form-control-label">Target</label>--}}
{{--                                --}}{{--                                <input type="number" value="{{$setup->performanceTarget}}" name="projectTarget" min="0"--}}
{{--                                --}}{{--                                       class="form-control form-control-success {{$errors->has('projectTarget') ? 'is-invalid' : ''}}"--}}
{{--                                --}}{{--                                       required>--}}
{{--                                --}}{{--                                @if($errors->has('projectTarget'))--}}
{{--                                --}}{{--                                    <span class="help-block text-danger">{{$errors->first('projectTarget')}}</span>--}}
{{--                                --}}{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}{{--                                                    <div class="form-group row">--}}
{{--                        --}}{{--                                                        <label class="col-md-2 form-control-label"><b>Judgement</b></label>--}}
{{--                        --}}{{--                                                        <div class="col-md-5">--}}
{{--                        --}}{{--                                                            <label class="form-control-label">Total</label>--}}
{{--                        --}}{{--                                                            <input type="number" value="{{$setup->judgement}}" name="judgementTotal" min="0"--}}
{{--                        --}}{{--                                                                   class="form-control form-control-success {{$errors->has('judgementTotal') ? 'is-invalid' : ''}}"--}}
{{--                        --}}{{--                                                                   required>--}}
{{--                        --}}{{--                                                            @if($errors->has('judgementTotal'))--}}
{{--                        --}}{{--                                                                <span class="help-block text-danger">{{$errors->first('judgementTotal')}}</span>--}}
{{--                        --}}{{--                                                            @endif--}}
{{--                        --}}{{--                                                        </div>--}}
{{--                        --}}{{--                                                        <div class="col-md-5">--}}
{{--                        --}}{{--                                                            <label class="form-control-label">Target</label>--}}
{{--                        --}}{{--                                                            <input type="number" value="{{$setup->judgementTarget}}" name="judgementTarget"--}}
{{--                        --}}{{--                                                                   min="0"--}}
{{--                        --}}{{--                                                                   class="form-control form-control-success {{$errors->has('judgementTarget') ? 'is-invalid' : ''}}"--}}
{{--                        --}}{{--                                                                   required>--}}
{{--                        --}}{{--                                                            @if($errors->has('judgementTarget'))--}}
{{--                        --}}{{--                                                                <span class="help-block text-danger">{{$errors->first('judgementTarget')}}</span>--}}
{{--                        --}}{{--                                                            @endif--}}
{{--                        --}}{{--                                                        </div>--}}
{{--                        --}}{{--                                                    </div>--}}
{{--                        --}}{{--                        <div class="form-group row">--}}
{{--                        --}}{{--                            <label class="col-md-2 form-control-label"><b>Promotion</b></label>--}}
{{--                        --}}{{--                            <div class="col-md-10">--}}
{{--                        --}}{{--                                @if($errors->has('promotion'))--}}
{{--                        --}}{{--                                    <span class="help-block text-danger">{{$errors->first('promotion')}}</span>--}}
{{--                        --}}{{--                                @endif--}}
{{--                        --}}{{--                                <div class="input-group mb-3">--}}
{{--                        --}}{{--                                    <input type="number" name="promotion"--}}
{{--                        --}}{{--                                           class="form-control form-control-success {{$errors->has('promotion') ? 'is-invalid' : ''}}"--}}
{{--                        --}}{{--                                           value="{{$setup->promotion}}" min="1" max="100" required>--}}
{{--                        --}}{{--                                    <div class="input-group-append">--}}
{{--                        --}}{{--                                        <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                        --}}{{--                                    </div>--}}
{{--                        --}}{{--                                </div>--}}
{{--                        --}}{{--                                <small class="form-text text-muted ml-3" style="margin-top: -10px;">--}}
{{--                        --}}{{--                                    Hierarchy percentage. Max value is 100*.--}}
{{--                        --}}{{--                                </small>--}}
{{--                        --}}{{--                            </div>--}}
{{--                        --}}{{--                        </div>--}}
{{--                        --}}{{--                        <div class="form-group row">--}}
{{--                        --}}{{--                            <label class="col-md-2 form-control-label"><b>Performance Chain</b></label>--}}
{{--                        --}}{{--                            <div class="col-md-10">--}}
{{--                        --}}{{--                                @if($errors->has('chain'))--}}
{{--                        --}}{{--                                    <span class="help-block text-danger">{{$errors->first('chain')}}</span>--}}
{{--                        --}}{{--                                @endif--}}
{{--                        --}}{{--                                <div class="input-group mb-3">--}}
{{--                        --}}{{--                                    <input type="number" name="chain"--}}
{{--                        --}}{{--                                           class="form-control form-control-success {{$errors->has('chain') ? 'is-invalid' : ''}}"--}}
{{--                        --}}{{--                                           value="{{$setup->chain}}" min="0" max="100" required>--}}
{{--                        --}}{{--                                    <div class="input-group-append">--}}
{{--                        --}}{{--                                        <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                        --}}{{--                                    </div>--}}
{{--                        --}}{{--                                </div>--}}
{{--                        --}}{{--                                <small class="form-text text-muted ml-3" style="margin-top: -10px;">--}}
{{--                        --}}{{--                                    Performance Hierarchy effect percentage. Max value is 100*.--}}
{{--                        --}}{{--                                </small>--}}
{{--                        --}}{{--                            </div>--}}
{{--                        --}}{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-9 ml-auto">--}}
{{--                                <button type="submit" class="btn btn-primary">Update</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
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