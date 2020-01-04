@extends('layouts.joli')
@section('title', 'Hearing Type')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[42]->display_name}}</li>
        <li><a href="{{route('warning.showHR')}}">{{$menu[46]->display_name}}</a></li>
        <li class="active">Hearing</li>
    </ul>
@endsection
@section('pageTitle', 'Hearing Type')
@section('content')
    <div class="row mb-5">
        <div class="col-lg-10 offset-lg-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Appeal Reject Hearing</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>No Action</td>
                            <td>
                                <a href="{{ route('warning.appeal.accept', $wid) }}" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Verbal Warning</td>
                            <td>
                                <a href="{{ route('verbalHearing.create', $wid) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-check"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Written Warning</td>
                            <td>
                                <a href="{{ route('writtenHearing.create', $wid) }}" class="btn btn-danger btn-sm">
                                    <i class="fa fa-check"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
{{--                        <h3 class="h6 text-uppercase mb-0">Appeal Reject Hearing</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table text-center">--}}
{{--                                <tr>--}}
{{--                                    <th>SL</th>--}}
{{--                                    <th>Type</th>--}}
{{--                                    <th>Action</th>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td># 1</td>--}}
{{--                                    <td>No Action</td>--}}
{{--                                    <td>--}}
{{--                                        <a href="{{ route('warning.appeal.accept', $wid) }}" class="btn btn-success btn-sm">--}}
{{--                                            <i class="fas fa-check"></i>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td># 2</td>--}}
{{--                                    <td>Verbal Warning</td>--}}
{{--                                    <td>--}}
{{--                                        <a href="{{ route('verbalHearing.create', $wid) }}" class="btn btn-warning btn-sm">--}}
{{--                                            <i class="fas fa-check"></i>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td># 3</td>--}}
{{--                                    <td>Written Warning</td>--}}
{{--                                    <td>--}}
{{--                                        <a href="{{ route('writtenHearing.create', $wid) }}" class="btn btn-danger btn-sm">--}}
{{--                                            <i class="fas fa-check"></i>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            </table>--}}
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