@extends('layouts.joli')
@section('title', 'Increment')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[17]->display_name}}</li>
        <li class="active">{{$menu[21]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Increment')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{session('success')}}
                </div>
            @elseif(session('PromoteSuccess'))
                <div class="alert alert-success text-center">
                    {{session('PromoteSuccess')}}
                </div>
            @elseif(session('CanNotPromote'))
                <div class="alert alert-success text-center">
                    {{session('CanNotPromote')}}
                </div>
            @elseif(session('mess'))
                <div class="alert alert-danger text-center">
                    {{session('mess')}}
                </div>
            @elseif(session('unsuccess'))
                <div class="alert alert-danger text-center">
                    {{session('unsuccess')}}
                </div>
            @endif
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">EMPLOYEE PROMOTION</h3>
                    </div>
                    {{--     Form Start              --}}
                    <form action="{{route('promote.employee')}}" class="form-horizontal" method="post">
                        @csrf
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-11 col-xs-12">
                                            <select class="form-control" name="employee" required id="employee">
                                                <option selected disabled hidden value="">Select Employee</option>
                                                @foreach($employees as $e)
                                                    <option value="{{$e->id}}" {{(old('employee')== $e->id)?'selected':'' }}>{{$e->name}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('employee'))
                                                <span class="help-block text-danger">{{$errors->first('employee')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-11 col-xs-12">
                                            <select class="form-control" name="designation" required id="designation">
                                                <option selected disabled hidden value="">Select Designation</option>
                                                @foreach($designations as $d)
                                                    <option value="{{$d->id}}" {{(old('designation')== $d->id)?'selected':'' }}>{{$d->title}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('designation'))
                                                <span class="help-block text-danger">{{$errors->first('designation')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                        class="fa fa-refresh"></span></a>
                            <button class="btn btn-primary pull-right" id="mltp_btn" disabled>Promote</button>
                        </div>
                    </form>
                    {{--     Form end               --}}
                </div>
            </div>
        </div>
    </section>
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Employee Increment</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Salary</th>
                                <th scope="col">Increment(%)</th>
                                <th scope="col">Max</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($errors->has('increment'))
                                <span class="help-block text-danger">{{$errors->first('increment')}}</span>
                            @endif
                            @foreach($employees as $i => $e)
                                <tr>
                                    <th scope="row">{{$i + 1}}</th>
                                    <td>{{$e->name}}</td>
                                    <td>{{$e->pay->pay}}</td>
                                    <form action="{{route('increment.employee', ['eid' => $e->id])}}" method="post"
                                          class="increment-form">
                                        @csrf
                                        <td>
                                            <input type="number" min="0" max="{{$e->max}}" class="increament"
                                                   name="increment" step="0.1"
                                                   style="border-radius: 5px;" required>%
                                        </td>
                                        <td>{{$e->max}}%</td>
                                        <td>
                                            {{--<button type="submit" class="btn btn-sm btn-outline-info" disabled>--}}
                                            <button type="submit" class="btn btn-sm btn-info">
                                                Increase
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script>
        $(function () {
            $("#employee").change((e) => {
                if ($("#designation").val() != null) {
                    document.getElementById('mltp_btn').disabled = false;
                }
            });
            $("#designation").change((e) => {
                if ($("#employee").val() != null) {
                    document.getElementById('mltp_btn').disabled = false;
                }
            });
        });
    </script>
    <script>
        $(function () {
            $('.increment-form').each((i, e) => {
                $(e).find('input:not(:hidden)').change((f) => {
                    console.log('dfsdfsdf');
                    var incrementForm = $(f.target).closest('.increment-form');
                    var validFields = [];
                    var fields = incrementForm.find('input:not(:hidden)');
                    fields.each((j, g) => {
                        validFields.push(g.value != "");
                    });
                    incrementForm.find('button').prop("disabled", validFields.includes(false));
                });
            });
        });
    </script>
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('success')}}--}}
{{--            </div>--}}
{{--        @elseif(session('PromoteSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('PromoteSuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('CanNotPromote'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('CanNotPromote')}}--}}
{{--            </div>--}}
{{--        @elseif(session('mess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('mess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('unsuccess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('unsuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Employee Promotion</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('promote.employee')}}" method="post">--}}
{{--                            @csrf--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-lg-5">--}}
{{--                                    <select class="form-control" name="employee">--}}
{{--                                        <option selected disabled hidden value="">Select Employee</option>--}}
{{--                                        @foreach($employees as $e)--}}
{{--                                            <option value="{{$e->id}}">{{$e->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-5">--}}
{{--                                    <select class="form-control" name="designation">--}}
{{--                                        <option selected disabled hidden value="">Select Designation</option>--}}
{{--                                        @foreach($designations as $d)--}}
{{--                                            <option value="{{$d->id}}">{{$d->title}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2">--}}
{{--                                    <button class="btn btn-sm btn-primary">Promote</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div><div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Employee Increment</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th scope="col">#</th>--}}
{{--                                <th scope="col">Name</th>--}}
{{--                                <th scope="col">Salary</th>--}}
{{--                                <th scope="col">Increment(%)</th>--}}
{{--                                <th scope="col">Max</th>--}}
{{--                                <th scope="col">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @if($errors->has('increment'))--}}
{{--                                <span class="help-block text-danger">{{$errors->first('increment')}}</span>--}}
{{--                            @endif--}}
{{--                            @foreach($employees as $i => $e)--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">{{$i + 1}}</th>--}}
{{--                                    <td>{{$e->name}}</td>--}}
{{--                                    <td>{{$e->pay->pay}}</td>--}}
{{--                                    <form action="{{route('increment.employee', ['eid' => $e->id])}}" method="post"--}}
{{--                                          class="increment-form">--}}
{{--                                        @csrf--}}
{{--                                        <td>--}}
{{--                                            <input type="number" min="0" max="{{$e->max}}" class="increament"--}}
{{--                                                   name="increment" step="0.1"--}}
{{--                                                   style="border-radius: 5px;" required>%--}}
{{--                                        </td>--}}
{{--                                        <td>{{$e->max}}%</td>--}}
{{--                                        <td>--}}
{{--                                            --}}{{----}}{{--<button type="submit" class="btn btn-sm btn-outline-info" disabled>--}}
{{--                                            <button type="submit" class="btn btn-sm btn-outline-info">--}}
{{--                                                Increase--}}
{{--                                            </button>--}}
{{--                                        </td>--}}
{{--                                    </form>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}


{{--                        @foreach($employees as $i => $e)--}}
{{--                            <form action="" class="increment-form">--}}
{{--                                <input type="text">--}}
{{--                                <button disabled>V</button>--}}
{{--                            </form>--}}
{{--                        @endforeach--}}


{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--<script>--}}
{{--    $(function () {--}}
{{--        $('.increment-form').each((i, e) => {--}}
{{--            $(e).find('input:not(:hidden)').change((f) => {--}}
{{--                var incrementForm = $(f.target).closest('.increment-form');--}}
{{--                var validFields = [];--}}
{{--                var fields = incrementForm.find('input:not(:hidden)');--}}
{{--                fields.each((j, g) => {--}}
{{--                    validFields.push(g.value != "");--}}
{{--                });--}}
{{--                incrementForm.find('button').prop("disabled", validFields.includes(false));--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}