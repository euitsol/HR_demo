@extends('layouts.joli')
@section('title', 'Leave Setup')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[6]->display_name}}</li>
        <li class="active">{{$menu[15]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Leave Setup')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('mlptUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('mlptUpdateSuccess')}}
                </div>
            @elseif(session('LTStoreSuccess'))
                <div class="alert alert-success text-center">
                    {{session('LTStoreSuccess')}}
                </div>
            @elseif(session('LTUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('LTUpdateSuccess')}}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @elseif(session('success'))
                <div class="alert alert-success text-center">
                    {{session('success')}}
                </div>
            @endif
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Max Leave Per Type</h3>
                    </div>
                    {{--     Form Start              --}}
                    <form action="{{route('leave.mlpt.update')}}" class="form-horizontal" method="post">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Max Leave Per Type</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="number" value="{{$maxLeavePerType}}" name="maxLeavePerType"
                                               required id="mlpt" min="0"
                                               class="form-control {{$errors->has('maxLeavePerType') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('maxLeavePerType'))
                                        <span class="help-block text-danger">{{$errors->first('maxLeavePerType')}}</span>
                                    @endif
                                </div>
                                {{--                                <div class="col-md-3">--}}
                                {{--                                    <button class="btn btn-primary" id="mltp_btn" disabled>Update</button>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                        class="fa fa-refresh"></span></a>
                            <button class="btn btn-primary pull-right" id="mltp_btn" disabled>Update</button>
                        </div>
                    </form>
                    {{--     Form end               --}}
                </div>
            </div>
        </div>
    </section>
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Leave Type</h3>
                    </div>
                    {{--     Form Start              --}}
                    <form action="{{route('leaveType.store')}}" class="form-horizontal" method="post">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Type</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" placeholder="Leave Type" name="type" required
                                               class="form-control {{$errors->has('type') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('type'))
                                        <span class="help-block text-danger">{{$errors->first('type')}}</span>
                                    @endif
                                    <small class="help-block">Duplicate entry is not allowed*</small>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                        class="fa fa-refresh"></span></a>
                            <button class="btn btn-primary pull-right">Create</button>
                        </div>
                    </form>
                    {{--     Form end               --}}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Leave Types</h3>
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
                            @foreach($lts as $i => $lt)
                                <tr>
                                    <th scope="row">{{$i + 1}}</th>
                                    <td>{{$lt->type}}</td>
                                    <td class="text-right">
                                        @if (($lt->id * 1) != 1)
                                            <a href="{{route('leaveType.edit', ['ltid' => $lt->id])}}"
                                               class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                                            <a href="{{route('leaveType.delete', ['ltid' => $lt->id])}}"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i></a>
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
    </section>

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
            $("#mlpt").on("keyup change", e => {
                document.getElementById('mltp_btn').disabled = false;
            })
        });
    </script>
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        --}}{{--        @if(session('mlptUpdateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('mlptUpdateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('LTStoreSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('LTStoreSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('LTUpdateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('LTUpdateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('error'))--}}
{{--        --}}{{--            <div class="alert alert-danger text-center">--}}
{{--        --}}{{--                {{session('error')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('success'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('success')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header"--}}
{{--                         style="border-radius: calc(1rem - 1px) calc(1rem - 1px) calc(1rem - 1px) calc(1rem - 1px);">--}}
{{--                        <form action="{{route('leave.mlpt.update')}}" method="post">--}}
{{--                            @csrf--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label text-center"><b>Max Leave Per Type</b></label>--}}
{{--                            --}}{{--                                <div class="col-md-6">--}}
{{--                            --}}{{--                                    <input type="number" name="maxLeavePerType" min="0" value="{{$maxLeavePerType}}"--}}
{{--                            --}}{{--                                           id="mlpt"--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('maxLeavePerType') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                           required>--}}
{{--                            --}}{{--                                    @if($errors->has('maxLeavePerType'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('maxLeavePerType')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                                <div class="col-md-3">--}}
{{--                            --}}{{--                                    <button id="mltp_btn" type="submit" class="btn btn-block btn-outline-primary"--}}
{{--                            --}}{{--                                            disabled>Update--}}
{{--                            --}}{{--                                    </button>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section class="pb-5">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-6 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Leave Type</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('leaveType.store')}}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Type</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    @if($errors->has('type'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('type')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                    <input type="text" placeholder="Leave Type" name="type"--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('type') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                           required>--}}
{{--                            --}}{{--                                    <small class="form-text text-muted ml-3">Duplicate entry is not allowed*.--}}
{{--                            --}}{{--                                    </small>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Create</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h6 class="text-uppercase mb-0">Leave Types</h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                --}}{{--                                <th>#</th>--}}
{{--                                --}}{{--                                <th>Type</th>--}}
{{--                                --}}{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            --}}{{--                            @foreach($lts as $i => $lt)--}}
{{--                            --}}{{--                                <tr>--}}
{{--                            --}}{{--                                    <th scope="row">{{$i + 1}}</th>--}}
{{--                            --}}{{--                                    <td>{{$lt->type}}</td>--}}
{{--                            --}}{{--                                    <td class="text-right">--}}
{{--                            --}}{{--                                        @if (($lt->id * 1) != 1)--}}
{{--                            --}}{{--                                            <a href="{{route('leaveType.edit', ['ltid' => $lt->id])}}"--}}
{{--                            --}}{{--                                               class="btn btn-sm btn-success">Edit</a>--}}
{{--                            --}}{{--                                            <a href="{{route('leaveType.delete', ['ltid' => $lt->id])}}"--}}
{{--                            --}}{{--                                               class="btn btn-sm btn-danger"--}}
{{--                            --}}{{--                                               onclick="return confirm('Are you sure ?')">Delete</a>--}}
{{--                            --}}{{--                                        @endif--}}
{{--                            --}}{{--                                    </td>--}}
{{--                            --}}{{--                                </tr>--}}
{{--                            --}}{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--<script>--}}
{{--    $(function () {--}}
{{--        $("#mlpt").change((e) => {--}}
{{--            document.getElementById('mltp_btn').disabled = false;--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}