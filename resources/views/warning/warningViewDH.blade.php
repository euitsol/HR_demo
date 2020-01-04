@extends('layouts.joli')
@section('title', 'Complain Department Head')
@section('link')
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[42]->display_name}}</li>
        <li class="active">{{$menu[44]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Complain Department Head')
@section('content')
    <div class="row mb-5">
        @if(session('ComplainSuccess'))
            <div class="alert alert-info text-center">
                {{session('ComplainSuccess')}}
            </div>
        @endif
        <div class="col-lg-10 offset-lg-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Send Warning</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{ route('warning.dh.store') }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Accused</label>
                            <div class="col-md-6 col-xs-12">
                                <select class="form-control" name="name" required>
                                    <option selected disabled hidden value="">Choose...</option>
                                    @foreach($users as $u)
                                        <option value="{{$u->id}}" {{(old('name')== $u->id)?'selected':'' }}>{{$u->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('name'))
                                    <span class="help-block text-danger">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Description</label>
                            <div class="col-md-6 col-xs-12">
                            <textarea
                                    class="form-control {{$errors->has('warningDescription') ? 'is-invalid' : ''}}"
                                    rows="5" name="warningDescription" required></textarea>
                                <script>
                                    CKEDITOR.replace('warningDescription');
                                </script>
                                @if($errors->has('warningDescription'))
                                    <span class="help-block text-danger">{{$errors->first('warningDescription')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                    class="fa fa-refresh"></span></a>
                        <button class="btn btn-primary pull-right">Send</button>
                    </div>
                </form>
                {{--     Form end               --}}
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-10 offset-lg-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Complains</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($warnings as $i => $warning)
                            <tr>
                                <td>{{ $warning->user->name }}</td>
                                <td id="description_{{$i}}">{!! $warning->description !!}</td>
                                <td class="text-right">
                                    <a href="{{ route('warning.forward', $warning->id) }}"
                                       class="btn btn-info btn-sm pl-2 pr-2">
                                        Forward
                                    </a>
                                    <a href="{{ route('warning.delete', $warning->id) }}"
                                       class="btn btn-danger btn-sm pl-1 pr-1"
                                       onclick="return confirm('Are you sure ?')">
                                        Reject
                                    </a>
                                    <button onclick="printT('description_{{$i}}')" class="btn btn-sm btn-info">
                                        <i class="fa fa-print"></i>
                                    </button>
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
    <script>
        function printT(el) {
            var rp = document.body.innerHTML;
            // $(".dn").addClass('d-none');
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="pt-4">--}}
{{--        <div class="row">--}}
{{--            <div class="col">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        --}}{{--                        <h3 class="h6 text-uppercase mb-0">Send Warning</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        --}}{{--                        <form action="{{ route('warning.dh.store') }}" class="form-horizontal"--}}
{{--                        method="post" enctype="multipart/form-data">--}}
{{--                        @csrf--}}
{{--                        --}}{{--                            <div class="form-group">--}}
{{--                        --}}{{--                                <label class="form-control-label">Name</label>--}}
{{--                        --}}{{--                                <select name="name" id=""--}}
{{--                        --}}{{--                                        class="form-control form-control-success {{$errors->has('name') ? 'has-error' : ''}}">--}}
{{--                        --}}{{--                                    <option value="">Choose...</option>--}}
{{--                        --}}{{--                                    @foreach ($users as $user)--}}
{{--                        --}}{{--                                        <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                        --}}{{--                                    @endforeach--}}
{{--                        --}}{{--                                </select>--}}
{{--                        --}}{{--                                @if($errors->has('name'))--}}
{{--                        --}}{{--                                    <span class="help-block text-danger">{{$errors->first('name')}}</span>--}}
{{--                        --}}{{--                                @endif--}}
{{--                        --}}{{--                            </div>--}}
{{--                        --}}{{--                            <div class="form-group">--}}
{{--                        --}}{{--                                <label class="form-control-label">Description</label>--}}
{{--                        --}}{{--                                <textarea--}}
{{--                        --}}{{--                                        class="form-control form-control-success {{$errors->has('warningDescription') ? 'has-error' : ''}}"--}}
{{--                        --}}{{--                                        name="warningDescription" id="" cols="30" rows="4" required></textarea>--}}
{{--                        --}}{{--                                <script>--}}
{{--                        --}}{{--                                    CKEDITOR.replace('warningDescription');--}}
{{--                        --}}{{--                                </script>--}}
{{--                        --}}{{--                                @if($errors->has('warningDescription'))--}}
{{--                        --}}{{--                                    <span class="help-block text-danger">{{$errors->first('warningDescription')}}</span>--}}
{{--                        --}}{{--                                @endif--}}
{{--                        --}}{{--                            </div>--}}
{{--                        --}}{{--                            <div class="form-group">--}}
{{--                        --}}{{--                                <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--                        --}}{{--                            </div>--}}
{{--                        --}}{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Warnings</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table">--}}
{{--                                <tr>--}}
{{--                                    --}}{{--                                    <th>Name</th>--}}
{{--                                    --}}{{--                                    <th>Description</th>--}}
{{--                                    --}}{{--                                    <th>Action</th>--}}
{{--                                </tr>--}}
{{--                                --}}{{--                                @foreach ($warnings as $warning)--}}
{{--                                --}}{{--                                    <tr>--}}
{{--                                --}}{{--                                        <td>{{ $warning->user->name }}</td>--}}
{{--                                --}}{{--                                        <td>{!! $warning->description !!}</td>--}}
{{--                                --}}{{--                                        <td>--}}
{{--                                --}}{{--                                            <a href="{{ route('warning.forward', $warning->id) }}"--}}
{{--                                --}}{{--                                               class="btn btn-info btn-sm pl-2 pr-2">--}}
{{--                                --}}{{--                                                Forward--}}
{{--                                --}}{{--                                            </a>--}}
{{--                                --}}{{--                                            <a href="{{ route('warning.delete', $warning->id) }}"--}}
{{--                                --}}{{--                                               class="btn btn-outline-danger btn-sm pl-1 pr-1"--}}
{{--                                --}}{{--                                               onclick="return confirm('Are you sure ?')">--}}
{{--                                --}}{{--                                                <i class="far fa-trash-alt"></i>--}}
{{--                                --}}{{--                                            </a>--}}
{{--                                --}}{{--                                        </td>--}}
{{--                                --}}{{--                                    </tr>--}}
{{--                                --}}{{--                                @endforeach--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}


{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}