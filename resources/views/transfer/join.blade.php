@extends('layouts.joli')
@section('title', 'Transfer Join')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[17]->display_name}}</li>
        <li>{{$menu[23]->display_name}}</li>
        <li class="active">{{$menu[25]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Transfer Join')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{session('success')}}
                </div>
            @elseif(session('unsuccess'))
                <div class="alert alert-danger text-center">
                    {{session('unsuccess')}}
                </div>
            @endif
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">EMPLOYEE lists</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Job</th>
                                <th>Role</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($errors->has('role'))
                                <span class="help-block text-danger">Please select the role first.</span>
                            @endif
                            @foreach($es as $i => $e)
                                <tr>
                                    <th scope="row">{{$i + 1}}</th>
                                    <td>{{$e->name}}</td>
                                    <td>{{$e->branch}}</td>
                                    <td>{{$e->job}}</td>
                                    <form action="{{route('transfer.join.submit', ['eid' => $e->id])}}" method="post">
                                        @csrf
                                        <td>
                                            <select class="form-control" name="role" required>
                                                <option selected disabled hidden value="">Choose...</option>
                                                @foreach($rs as $i => $r)
                                                    @if($i > 3)
                                                        <option value="{{$r->id}}">{{$r->display_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-right">
                                            <button type="submit" class="btn btn-sm btn-success">Join</button>
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

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        --}}{{--        @if(session('success'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('success')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('unsuccess'))--}}
{{--        --}}{{--            <div class="alert alert-danger text-center">--}}
{{--        --}}{{--                {{session('unsuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2 pb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Employee List</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Name</th>--}}
{{--                                <th>Branch</th>--}}
{{--                                <th>Job</th>--}}
{{--                                <th>Role</th>--}}
{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @if($errors->has('role'))--}}
{{--                                <span class="help-block text-danger">Please select the role first.</span>--}}
{{--                            @endif--}}
{{--                            @foreach($es as $i => $e)--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">{{$i + 1}}</th>--}}
{{--                                    <td>{{$e->name}}</td>--}}
{{--                                    <td>{{$e->branch}}</td>--}}
{{--                                    <td>{{$e->job}}</td>--}}
{{--                                    <form action="{{route('transfer.join.submit', ['eid' => $e->id])}}" method="post">--}}
{{--                                        @csrf--}}
{{--                                        <td>--}}
{{--                                            <select class="form-control" name="role" required>--}}
{{--                                                <option selected disabled hidden value="">Choose...</option>--}}
{{--                                                @foreach($rs as $i => $r)--}}
{{--                                                    @if($i > 3)--}}
{{--                                                        <option value="{{$r->id}}">{{$r->display_name}}</option>--}}
{{--                                                    @endif--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </td>--}}
{{--                                        <td class="text-right">--}}
{{--                                            <button type="submit" class="btn btn-sm btn-success">Join</button>--}}
{{--                                        </td>--}}
{{--                                    </form>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}