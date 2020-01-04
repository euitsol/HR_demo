@extends('layouts.joli')
@section('title', 'KPI Vote')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li class="active">{{$menu[47]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'KPI Vote')
@section('content')
    <div class="row mb-5">
        @if(session('unsuccess'))
            <div class="alert alert-danger text-center">
                {{session('unsuccess')}}
            </div>
        @endif
        <div class="col-lg-10 offset-lg-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">KPI Vote</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('kpi.vote.store')}}" class="form-horizontal" method="post">
                    @csrf
                    <div class="panel-body">
                        <h5>Value Others</h5>
                        <hr>
                        @foreach($users as $u)
                            <div class="form-group user-value">
                                <label class="col-md-3 col-xs-12 control-label">{{$u->name}}</label>
                                <div class="col-md-6 col-xs-12">
                                    <input type="range" class="custom-range" min="1" max="10"
                                           name="allu[{{$u->id}}]" required value="9" style="margin-top: 14px;">
                                </div>
                                <span class="input-group-prepend badge badge-default" style="margin-top: 7px;">9</span>
                            </div>
                        @endforeach
                        <br>
                        <h5>Junior's Performance</h5>
                        <hr>
                        @foreach($juniorUsers as $u)
                            <div class="form-group user-value">
                                <label class="col-md-3 col-xs-12 control-label">{{$u->name}}</label>
                                <div class="col-md-6 col-xs-12">
                                    <input type="range" class="custom-range" min="1" max="10"
                                           name="jus[{{$u->id}}]" required value="9" style="margin-top: 14px;">
                                </div>
                                <span class="input-group-prepend badge badge-default" style="margin-top: 7px;">9</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="panel-footer">
                        <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                    class="fa fa-refresh"></span></a>
                        <button class="btn btn-primary pull-right">Vote</button>
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
    <script>
        $(function () {
            $('.user-value').each((i, e) => {
                $(e).find("input[type='range']").change((f) => {
                    // $(f.target).closest('.user-value').find("input[type='text']").val($(f.target).closest('.user-value').find("input[type='range']").val());
                    $(f.target).closest('.user-value').find("span").text($(f.target).closest('.user-value').find("input[type='range']").val());
                });
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
{{--            <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">KPI Vote</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('kpi.vote.store')}}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            <h5>Value Others</h5>--}}
{{--                            <hr>--}}
{{--                            @foreach($users as $u)--}}
{{--                                <div class="form-group row user-value">--}}
{{--                                    <label class="col-md-2 form-control-label">{{$u->name}}</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <input type="range" class="custom-range" min="1" max="10"--}}
{{--                                               name="allu[{{$u->id}}]" required value="9">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-1">--}}
{{--                                        <input type="text" class="form-control form-control-success" value="9" readonly>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                            <br>--}}
{{--                            <h5>Junior's Performance</h5>--}}
{{--                            <hr>--}}
{{--                            @foreach($juniorUsers as $u)--}}
{{--                                <div class="form-group row user-value">--}}
{{--                                    <label class="col-md-2 form-control-label">{{$u->name}}</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <input type="range" class="custom-range" min="1" max="10"--}}
{{--                                               name="jus[{{$u->id}}]" required value="9">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-1">--}}
{{--                                        <input type="text" class="form-control form-control-success" value="9" readonly>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Vote</button>--}}
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
{{--    $(function () {--}}
{{--        $('.user-value').each((i, e) => {--}}
{{--            $(e).find("input[type='range']").change((f) => {--}}
{{--                $(f.target).closest('.user-value').find("input[type='text']").val($(f.target).closest('.user-value').find("input[type='range']").val());--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}