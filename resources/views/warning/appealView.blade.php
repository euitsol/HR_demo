@extends('layouts.joli')
@section('title', 'Appeal View')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[42]->display_name}}</li>
        <li><a href="{{route('warning.showHR')}}">{{$menu[46]->display_name}}</a></li>
        <li class="active">Appeal View</li>
    </ul>
@endsection
@section('pageTitle', 'Appeal View')
@section('content')
    <div class="row mb-5">
        <div class="col-lg-10 offset-lg-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Appeal From {{ $appeal->user->name }}</h3>
                </div>
                <div class="panel-body">
                    <div class="text-justify">
                        {!! $appeal->appeal !!}
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="{{ route('warning.appeal.accept', $appeal->id) }}" class="btn btn-success back">
                        Accept Appeal
                    </a>
                    <a href="{{ route('warning.appeal.reject.hearing', $appeal->id) }}" class="btn btn-primary pull-right">
                        Reject Appeal
                    </a>
                </div>
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
{{--            <div class="col-lg-1 col-md-1"></div>--}}
{{--            <div class="col-lg-10 col-md-10 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        --}}{{--                        <h3 class="h6 text-uppercase mb-0">Appeal From {{ $appeal->user->name }}</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="text-justify">--}}
{{--                            {{ $appeal->appeal }}--}}
{{--                        </div>--}}
{{--                        <div class="mt-4">--}}
{{--                            <a href="{{ route('warning.appeal.accept', $appeal->id) }}" class="btn btn-success btn-sm">Accept--}}
{{--                                Appeal</a>--}}
{{--                            <span class="float-right">--}}
{{--                                <a href="{{ route('warning.appeal.reject.hearing', $appeal->id) }}"--}}
{{--                                   class="btn btn-danger btn-sm">Reject Appeal</a>--}}
{{--                            </span>--}}
{{--                        </div>--}}
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