@extends('layouts.joli')
@section('title', 'Provident Fund')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[33]->display_name}}</li>
        <li class="active">{{$menu[36]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Provident Fund')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('ProvidentUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('ProvidentUpdateSuccess')}}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Provident Fund Setup</h3>
                    </div>
                    {{--     Form Start              --}}
                    <form action="{{route('provident.update')}}" class="form-horizontal" method="post">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">User's Share</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="number" value="{{$p->from_user}}" name="usersShare"
                                               required min="0" max="100" step="0.01"
                                               class="form-control {{$errors->has('usersShare') ? 'is-invalid' : ''}}">
                                        <span class="input-group-addon add-on">%</span>
                                    </div>
                                    @if($errors->has('usersShare'))
                                        <span class="help-block text-danger">{{$errors->first('usersShare')}}</span>
                                    @endif
                                    <small class="help-block">max is 100%</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Company's Share</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="number" value="{{$p->from_employer}}" name="companysShare"
                                               required min="0" max="100" step="0.01"
                                               class="form-control {{$errors->has('companysShare') ? 'is-invalid' : ''}}">
                                        <span class="input-group-addon add-on">%</span>
                                    </div>
                                    @if($errors->has('companysShare'))
                                        <span class="help-block text-danger">{{$errors->first('companysShare')}}</span>
                                    @endif
                                    <small class="help-block">max is 100%</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Only Gross Salary</label>
                                <div class="col-md-6 col-xs-12" style="margin-top: 7px;">
                                    <input type="checkbox" name="is_gross" style="transform: scale(1.5);"
                                            {{ (($p->is_gross * 1) == 1 ) ? "checked" : "" }}>
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
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('ProvidentUpdateSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('ProvidentUpdateSuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-10 offset-lg-1 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Provident Fund Setup</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('provident.update')}}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">User's Share</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    @if($errors->has('usersShare'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('usersShare')}}</span>--}}
{{--                                    @endif--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <input type="number" name="usersShare" min="0" max="100"--}}
{{--                                               value="{{$p->from_user}}"--}}
{{--                                               class="form-control form-control-success {{$errors->has('usersShare') ? 'is-invalid' : ''}}"--}}
{{--                                               required step="0.01">--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <small class="form-text text-muted ml-3" style="margin-top: -10px;">max is 100%*--}}
{{--                                    </small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Company's Share</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    @if($errors->has('companysShare'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('companysShare')}}</span>--}}
{{--                                    @endif--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <input type="number" name="companysShare" min="0" max="100"--}}
{{--                                               value="{{$p->from_employer}}"--}}
{{--                                               class="form-control form-control-success {{$errors->has('companysShare') ? 'is-invalid' : ''}}"--}}
{{--                                               required step="0.01">--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <small class="form-text text-muted ml-3" style="margin-top: -10px;">max is 100%*--}}
{{--                                    </small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Only Gross Salary</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input id="is_gross" type="checkbox" name="is_gross" style="transform: scale(2);margin-left: 15px;"--}}
{{--                                            {{ (($p->is_gross * 1) == 1 ) ? "checked" : "" }}>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Update Provident Fund</button>--}}
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