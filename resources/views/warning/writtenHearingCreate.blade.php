@extends('layouts.joli')
@section('title', 'Written Warning')
@section('link')
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[42]->display_name}}</li>
        <li><a href="{{route('warning.showHR')}}">{{$menu[46]->display_name}}</a></li>
        <li class="active">Written Warning</li>
    </ul>
@endsection
@section('pageTitle', 'Written Warning')
@section('content')
    <div class="row mb-5">
        <div class="col-lg-10 offset-lg-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Create Written Warning</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{ route('writtenHearing.store') }}" class="form-horizontal" method="post">
                    @csrf
                    <input type="hidden" name="warning_id" value="{{ $wid }}">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Written Warning</label>
                            <div class="col-md-6 col-xs-12">
                            <textarea
                                    class="form-control {{$errors->has('hearing_message') ? 'is-invalid' : ''}}"
                                    rows="5" name="hearing_message" required></textarea>
                                <script>
                                    CKEDITOR.replace('hearing_message');
                                </script>
                                @if($errors->has('hearing_message'))
                                    <span class="help-block text-danger">{{$errors->first('hearing_message')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                    class="fa fa-refresh"></span></a>
                        <button class="btn btn-primary pull-right">Submit</button>
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
{{--        <div class="row">--}}
{{--            @if(session('unsuccess'))--}}
{{--                <div class="alert alert-danger text-center">--}}
{{--                    {{session('unsuccess')}}--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            <div class="col-lg-1 col-md-1"></div>--}}
{{--            <div class="col-lg-10 col-md-10 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Create Written Warning</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{ route('writtenHearing.store') }}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            <input type="hidden" name="warning_id" value="{{ $wid }}">--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Warning</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <textarea--}}
{{--                                            class="form-control form-control-success {{$errors->has('hearing_message') ? 'has-error' : ''}}"--}}
{{--                                            name="hearing_message" id="" cols="30" rows="4" required></textarea>--}}
{{--                                    <script>--}}
{{--                                        CKEDITOR.replace('hearing_message');--}}
{{--                                    </script>--}}
{{--                                    @if($errors->has('hearing_message'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('hearing_message')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-1 col-md-1"></div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}