@extends('layouts.joli')
@section('title', 'Office Setup')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[6]->display_name}}</li>
        <li class="active">{{$menu[7]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Office Setup')
@section('content')
    <section class="pb-5">
        <div class="row">
            @if(session('OfficeUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('OfficeUpdateSuccess')}}
                </div>
            @elseif(session('unsuccess'))
                <div class="alert alert-danger text-center">
                    {{session('unsuccess')}}
                </div>
            @endif
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">OFFICE SETUP</h3>
                    </div>
                    <form action="{{route('office.setup.update')}}" class="form-horizontal"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Footer Text</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" value="{{ $office ? $office->footer : "" }}"
                                               name="footerText" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Logo</label>
                                <div class="col-md-6 col-xs-12">
                                    @if($office && $office->logo)
                                        <img src="{{asset($office->logo)}}" alt="logo"
                                             style="max-width: 250px; max-height: 200px;">
                                        <br>
                                    @endif
                                    <input type="file" name="logo"
                                           @if($office && $office->logo) style="margin-top: 20px;" @endif >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Logo Background</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-dashboard"></span></span>
                                        <input type="color"
                                               value="{{ ($office && $office->logo_bg) ? $office->logo_bg : '#1caf9a' }}"
                                               name="logoBG" class="form-control">
                                    </div>
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
{{--        --}}{{--        @if(session('OfficeUpdateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('OfficeUpdateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('unsuccess'))--}}
{{--        --}}{{--            <div class="alert alert-danger text-center">--}}
{{--        --}}{{--                {{session('unsuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-10 offset-lg-1 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Office Setup</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('office.setup.update')}}" class="form-horizontal" method="post"--}}
{{--                              enctype="multipart/form-data">--}}
{{--                            @csrf--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-2 form-control-label">Footer Text</label>--}}
{{--                            --}}{{--                                <div class="col-md-10">--}}
{{--                            --}}{{--                                    <input type="text" name="footerText" value="{{ $office ? $office->footer : "" }}"--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('footerText') ? 'is-invalid' : ''}}">--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-2 form-control-label">Logo</label>--}}
{{--                            --}}{{--                                <div class="col-md-10">--}}
{{--                            --}}{{--                                    @if($office && $office->logo)--}}
{{--                            --}}{{--                                        <img src="{{asset($office->logo)}}" alt="logo"--}}
{{--                            --}}{{--                                             style="max-width: 250px; max-height: 200px;">--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                    <br>--}}
{{--                            --}}{{--                                    <input type="file" name="logo" class="{{$errors->has('logo') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                           @if($office && $office->logo) style="margin-top: 20px;" @endif >--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-2 form-control-label">Logo Background</label>--}}
{{--                                <div class="col-md-10">--}}
{{--                                    <input type="color" name="logoBG"--}}
{{--                                           value="{{ ($office && $office->logo_bg) ? $office->logo_bg : '#1caf9a' }}"--}}
{{--                                           class="form-control form-control-success {{$errors->has('logoBG') ? 'is-invalid' : ''}}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <hr>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
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