@extends('layouts.joli')
@section('title', 'Religion Edit')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[6]->display_name}}</li>
        <li><a href="{{route('religion')}}">{{$menu[14]->display_name}}</a></li>
        <li class="active">Edit</li>
    </ul>
@endsection
@section('pageTitle', 'Religion Edit')
@section('content')
    <div class="row mb-5">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Religion Name Edit</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('religion.update', ['rid' => $redit->id])}}" class="form-horizontal" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Name</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" value="{{$redit->name}}" name="name" required
                                           class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('name'))
                                    <span class="help-block text-danger">{{$errors->first('name')}}</span>
                                @endif
                                <small class="help-block">Duplicate entry is not allowed*</small>
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
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ALL job</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rs as $i => $r)
                            <tr>
                                <th scope="row">{{$i + 1}}</th>
                                <td>{{$r->name}}</td>
                                <td>
                                    @if(($r->id * 1) != ($redit->id * 1))
                                        <a href="{{route('religion.edit', ['rid' => $r->id])}}"
                                           class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('religion.delete', ['rid' => $r->id]) }}"
                                           class="btn btn-sm btn-danger" onclick="return confirm('Are you sure ?')"><i
                                                    class="fa fa-trash-o"></i></a>
                                    @else
                                        <a href="{{route('religion.edit', ['rid' => $r->id])}}"
                                           class="btn btn-sm btn-success disabled"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void (0)" class="btn btn-sm btn-danger disabled"><i
                                                    class="fa fa-trash-o"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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
{{--            <div class="col-lg-6 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Religion Name Edit</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('religion.update', ['rid' => $redit->id])}}" class="form-horizontal"--}}
{{--                              method="post">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Name</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    @if($errors->has('name'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('name')}}</span>--}}
{{--                                    @endif--}}
{{--                                    <input type="text" value="{{$redit->name}}" name="name"--}}
{{--                                           class="form-control form-control-success {{$errors->has('name') ? 'is-invalid' : ''}}"--}}
{{--                                           required>--}}
{{--                                    <small class="form-text text-muted ml-3">Duplicate entry is not allowed*.--}}
{{--                                    </small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Update</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h6 class="text-uppercase mb-0">Religions</h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Name</th>--}}
{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($rs as $i => $r)--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">{{$i + 1}}</th>--}}
{{--                                    <td>{{$r->name}}</td>--}}
{{--                                    <td class="text-right">--}}
{{--                                        @if(($r->id * 1) != ($redit->id * 1))--}}
{{--                                            <a href="{{route('religion.edit', ['rid' => $r->id])}}"--}}
{{--                                               class="btn btn-sm btn-success">Edit</a>--}}
{{--                                        @else--}}
{{--                                            <a href="{{route('religion.edit', ['rid' => $r->id])}}"--}}
{{--                                               class="btn btn-sm btn-success disabled">Edit</a>--}}
{{--                                        @endif--}}
{{--                                        <a href="{{ route('religion.delete', ['rid' => $r->id]) }}"--}}
{{--                                           class="btn btn-sm btn-danger" onclick="return confirm('Are you sure ?')">Delete</a>--}}
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