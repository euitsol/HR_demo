@extends('layouts.joli')
@section('title', 'Attendance Edit')
@section('link')
    {{--    <link rel="stylesheet" href="{{ asset('bubbly/vendor/dt-picker/bootstrap-datetimepicker.css') }}">--}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('bubbly/vendor/dt-picker/bootstrap-datetimepicker.css') }}">

    <style>
        .font-30px {
            font-size: 30px;
        }

        .date-edit {
            padding: 2px 7px;
            border: 1px solid #c3c2c2;
        }
    </style>@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[30]->display_name}}</li>
        <li><a href="{{route('attendance.show')}}">{{$menu[32]->display_name}}</a></li>
    </ul>
@endsection
@section('pageTitle', 'Attendance Edit')
@section('content')
    <div class="row mb-5">
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{session('error')}}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        @endif
        <div class="col-lg-10 offset-lg-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">BRANCH EDIT</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{ route('attendance.update') }}" class="form-horizontal" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $attendance->id }}">
                    <div class="panel-body">
                        @if($errors->has('id'))
                            <span class="help-block text-danger">Please Do Not Mess With The Original Code !!!</span>
                        @endif
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Name</label>
                            <div class="col-md-6 col-xs-12 py-2">
                                {{ optional($attendance->user)->name }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Date</label>
                            <div class="col-md-6 col-xs-12 py-2">
                                {{ $attendance->date }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Date</label>
                            <div class="col-md-6 col-xs-12 py-2">
                                {{ $attendance->date }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">IN
                                <small>Time</small>
                            </label>
                            <div class="col-md-6 col-xs-12 py-1">
                                <span class="mr-2">{{ date('m/d/Y h:i A', strtotime($attendance->time_in)) }}</span>
                                <input type="text" name="time_in" id="dt1" placeholder="Edit" class="date-edit"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">OUT
                                <small>Time</small>
                            </label>
                            <div class="col-md-6 col-xs-12 py-1">
                                <span class="mr-2">{{ date('m/d/Y h:i A', strtotime($attendance->time_out)) }}</span>
                                <input type="text" name="time_out" id="dt2" placeholder="Edit" class="date-edit"
                                       autocomplete="off">
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
    <script src="{{ asset('bubbly/vendor/dt-picker/bootstrap-datetimepicker.js') }}"></script>
    <script>
        $(function () {
            $('#dt1, #dt2').datetimepicker({
                format: "yyyy-mm-dd HH:ii",
                showMeridian: true,
                autoclose: true,
                todayBtn: true
            });
            $('.prev i').removeClass('glyphicon icon-arrow-left').addClass('fa fa-arrow-left');
            $('.next i').removeClass('glyphicon icon-arrow-right').addClass('fa fa-arrow-right');
        });
    </script>
@endsection