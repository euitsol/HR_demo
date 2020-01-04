@extends('layouts.joli')
@section('title', 'Leave Department Head')
@section('style')
    <style>
        .list-group .list-group-item:last-child {
            border-bottom: 1px solid #ddd !important;
        }
    </style>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[26]->display_name}}</li>
        <li class="active">
            <a href="{{route('leave.application.view.DH', ['uid' => 0])}}">{{$menu[29]->display_name}}</a>
        </li>
    </ul>
@endsection
@section('pageTitle', 'Leave > Department Head')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('ApproveSuccess'))
                <div class="alert alert-success text-center">
                    {{session('ApproveSuccess')}}
                </div>
            @elseif(session('success'))
                <div class="alert alert-success text-center">
                    {{session('success')}}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @elseif(session('unsuccess'))
                <div class="alert alert-danger text-center">
                    {{session('unsuccess')}}
                </div>
            @endif
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Leave Entry</h3>
                    </div>
                    <form action="{{ route('leave.entry.dh') }}" method="post">
                        @csrf
                        <div class="panel-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">User :</label>
                                        <select name="name" id="" class="form-control">
                                            <option value="">Choose...</option>
                                            @foreach ($_users as $_user)
                                                <option value="{{ $_user->id }}">{{ $_user->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('name'))
                                            <span class="help-block text-danger">{{$errors->first('name')}}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        From Date : <input type="date" name="fromDate" id="fromDate"
                                                           class="form-control">
                                        @if($errors->has('fromDate'))
                                            <span class="help-block text-danger">{{$errors->first('fromDate')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <fieldset style="margin-top: 18px;">
                                        {{--                                    <legend>Leave type</legend>--}}
                                        <table>
                                            @foreach ($leaveTypes as $LT)
                                                <tr>
                                                    <td width="33%">{{ $LT->type }}</td>
                                                    <td width="10%">:</td>
                                                    <td width="57%"><input type="number" name="days[{{ $LT->id }}]"
                                                                           id=""></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </fieldset>
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                        class="fa fa-refresh"></span></a>
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Applied Users</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($users as $u)
                                <li class="list-group-item">
                                    <a href="{{route('leave.application.view.DH', ['uid' => $u[0]->id])}}">{{$u[0]->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(count($userLeavedays) > 0)
        <section class="mb-5">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{$user->name}}</h3>
                        </div>
                        <form action="{{route('leave.application.approve')}}" method="post">
                            @csrf
                            <div class="panel-body">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Type</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">
                                            <input type="checkbox" name="" id="selectAll"> Approve
                                        </th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($userLeavedays as $ul)
                                        <tr>
                                            <td>{{ optional($ul->leavetype)->type}}</td>
                                            <td>{{date('jS F, Y', strtotime($ul->date))}}</td>
                                            <td><input type="checkbox" name="leaveDates[]" value="{{ $ul->id }}"></td>
                                            <td>
                                                <a href="{{ route('leave.application.reject.dh', $ul->id) }}"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Are you sure ?')">
                                                    Reject
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($errors->has('leaveDates'))
                                <span class="help-block text-danger">Please approve at least one date.</span>
                                <br>
                            @endif
                            <div class="panel-footer">
                                <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                            class="fa fa-refresh"></span></a>
                                <button type="submit" class="btn btn-primary pull-right">Approve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@section('script')
    <script>
        $("#selectAll").click(function () {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('ApproveSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('ApproveSuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('success'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('success')}}--}}
{{--            </div>--}}
{{--        @elseif(session('error'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('error')}}--}}
{{--            </div>--}}
{{--        @elseif(session('unsuccess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('unsuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="mb-5">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <form action="{{ route('leave.entry.dh') }}" method="post">--}}
{{--                        @csrf--}}
{{--                        <div class="row">--}}
{{--                            <div class="col">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">User :</label>--}}
{{--                                    <select name="name" id="" class="form-control">--}}
{{--                                        <option value="">Choose...</option>--}}
{{--                                        @foreach ($_users as $_user)--}}
{{--                                            <option value="{{ $_user->id }}">{{ $_user->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    @if($errors->has('name'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('name')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    From Date : <input type="date" name="fromDate" id="fromDate" class="form-control">--}}
{{--                                    @if($errors->has('fromDate'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('fromDate')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <input type="submit" value="Submit" class="btn btn-primary">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <fieldset>--}}
{{--                                    <legend>Leave type</legend>--}}
{{--                                    <table>--}}
{{--                                        @foreach ($leaveTypes as $LT)--}}
{{--                                            <tr>--}}
{{--                                                <td width="33%">{{ $LT->type }}</td>--}}
{{--                                                <td width="10%">:</td>--}}
{{--                                                <td width="57%"><input type="number" name="days[{{ $LT->id }}]" id=""></td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                    </table>--}}
{{--                                </fieldset>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div class="col">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Applied Users</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <ul class="list-group">--}}
{{--                            @foreach($users as $u)--}}
{{--                                <li class="list-group-item">--}}
{{--                                    <a href="{{route('leave.application.view.DH', ['uid' => $u[0]->id])}}">{{$u[0]->name}}</a>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    @if(count($userLeavedays) > 0)--}}
{{--        <section class="py-5">--}}
{{--            <div class="row">--}}
{{--                <!-- Basic Form-->--}}
{{--                <div class="col mb-5">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            <h3 class="h6 text-uppercase mb-0">{{$user->name}}</h3>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <form action="{{route('leave.application.approve')}}" method="post">--}}
{{--                                @csrf--}}
{{--                                <table class="table table-sm">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th scope="col">Type</th>--}}
{{--                                        <th scope="col">Date</th>--}}
{{--                                        <th scope="col">--}}
{{--                                            <input type="checkbox" name="" id="selectAll"> Approve--}}
{{--                                        </th>--}}
{{--                                        <th scope="col">Delete</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    @foreach($userLeavedays as $ul)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{ optional($ul->leavetype)->type}}</td>--}}
{{--                                            <td>{{date('jS F, Y', strtotime($ul->date))}}</td>--}}
{{--                                            <td><input type="checkbox" name="leaveDates[]" value="{{ $ul->id }}"></td>--}}
{{--                                            <td>--}}
{{--                                                <a href="{{ route('leave.application.reject.dh', $ul->id) }}" class="btn btn-outline-danger btn-sm"--}}
{{--                                                   onclick="return confirm('Are you sure ?')">--}}
{{--                                                    Reject--}}
{{--                                                </a>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                                @if($errors->has('leaveDates'))--}}
{{--                                    <span class="help-block text-danger">Please approve at least one date.</span>--}}
{{--                                    <br>--}}
{{--                                @endif--}}
{{--                                <button type="submit" class="btn btn-primary"--}}
{{--                                        onclick="return confirm('Are you sure ?')">Approve--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--    @endif--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}

{{--<script>--}}
{{--    // $("#selectAll").click(function(){--}}
{{--    //     $("input[type=checkbox]").prop('checked', $(this).prop('checked'));--}}
{{--    // });--}}
{{--</script>--}}

{{--</body>--}}
{{--</html>--}}