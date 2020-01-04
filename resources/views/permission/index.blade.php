@extends('layouts.joli')
@section('title', 'Permissions')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[1]->display_name}}</li>
        <li class="active">{{$menu[2]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Permissions')
@section('content')
    <div class="row">
        @if(session('permissionUpdateSuccess'))
            <div class="alert alert-success text-center">
                {{session('permissionUpdateSuccess')}}
            </div>
        @endif
        <div class="col-md-10 col-md-offset-1">
            <!-- START TABLE HOVER ROWS -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">SPECIAL PERMISSIONS</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ps as $p)
                            <tr>
                                <td>{{$p->display_name}}</td>
                                <td>{{$p->description }}</td>
                                <td>
                                    <a href="{{route('permission.edit', ['pid' => $p->id])}}"
                                       class="btn btn-sm btn-success"><span class="fa fa-pencil"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END TABLE HOVER ROWS -->
        </div>
    </div>
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    {{--    <script type='text/javascript' src='{{asset('joli/js/plugins/icheck/icheck.min.js')}}'></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/demo_tables.js')}}"></script>--}}
    <!-- END THIS PAGE PLUGINS-->
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('permissionUpdateSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('permissionUpdateSuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-10 offset-lg-1 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h6 class="text-uppercase mb-0">Special Permissions</h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>Display Name</th>--}}
{{--                                <th>Description</th>--}}
{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($ps as $p)--}}
{{--                                <tr>--}}
{{--                                    <td>{{$p->display_name}}</td>--}}
{{--                                    <td>{{$p->description }}</td>--}}
{{--                                    <td class="text-right">--}}
{{--                                        <a href="{{route('permission.edit', ['pid' => $p->id])}}"--}}
{{--                                           class="btn btn-sm btn-success">Edit</a>--}}
{{--                                    </td>--}}
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