@extends('layouts.joli')
@section('title', 'Transfer Release')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[17]->display_name}}</li>
        <li>{{$menu[23]->display_name}}</li>
        <li class="active">{{$menu[24]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Transfer Release')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{session('success')}}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @endif
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">EMPLOYEE Release to transfer</h3>
                    </div>
                    {{--     Form Start              --}}
                    <form action="{{route('transfer.release.submit')}}" class="form-horizontal" method="post">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Select Employee</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="employee" required id="employee">
                                        <option selected disabled hidden value="">Choose...</option>
                                        @foreach($es as $e)
                                            <option value="{{$e->id}}" {{(old('employee')== $e->id)?'selected':'' }}>{{$e->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block text-danger">{{$errors->first('employee')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Select Branch</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="branch" required id="designation">
                                        <option selected disabled hidden value="">Choose...</option>
                                        @foreach($bs as $b)
                                            <option value="{{$b->id}}" {{(old('branch')== $b->id)?'selected':'' }}>{{$b->title}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('branch'))
                                        <span class="help-block text-danger">{{$errors->first('branch')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                        class="fa fa-refresh"></span></a>
                            <button class="btn btn-primary pull-right" id="mltp_btn" disabled>Release</button>
                        </div>
                    </form>
                    {{--     Form end               --}}
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
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('success')}}--}}
{{--            </div>--}}
{{--        @elseif(session('error'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('error')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-6 offset-lg-3 pb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Select Employee</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('transfer.release.submit')}}" method="post">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="form-control-label col-md-3">Select Employee</label>--}}
{{--                                <div class=" col-md-9">--}}
{{--                                    <select class="form-control" name="employee" required>--}}
{{--                                        @if($errors->has('employee'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('employee')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <option selected disabled hidden value="">Choose...</option>--}}
{{--                                        @foreach($es as $e)--}}
{{--                                            <option value="{{$e->id}}">{{$e->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="form-control-label col-md-3">Select Branch</label>--}}
{{--                                <div class=" col-md-9">--}}
{{--                                    <select class="form-control" name="branch" required>--}}
{{--                                        @if($errors->has('branch'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('branch')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <option selected disabled hidden value="">Choose...</option>--}}
{{--                                        @foreach($bs as $b)--}}
{{--                                            <option value="{{$b->id}}">{{$b->title}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>--}}
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