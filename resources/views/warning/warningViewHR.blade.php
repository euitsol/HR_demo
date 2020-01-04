@extends('layouts.joli')
@section('title', 'Appeal HR')
{{--@section('link')--}}
{{--    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>--}}
{{--@endsection--}}
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[42]->display_name}}</li>
        <li class="active">{{$menu[46]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Appeal HR')
@section('content')
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
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($warnings as $key => $warning)
                            <tr>
                                <td>{{  $key + 1 }}</td>
                                <td>{{ $warning->user->name }}</td>
                                <td id="description_{{$key}}">{!! $warning->description !!}</td>
                                <td class="text-center">
                                    @if (!empty($warning->appeal))
                                        <a href="{{ route('warning.appeal.show', $warning->id) }}"
                                           class="btn btn-info btn-sm">
                                            View Appeal
                                        </a>
                                    @endif
                                    <a href="{{ route('warning.delete', $warning->id) }}" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure ?')">
                                        Reject Complain
                                    </a>
                                    <button onclick="printT('description_{{$key}}')" class="btn btn-sm btn-info">
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
    {{--        <script type='text/javascript' src='{{asset('joli/js/plugins/icheck/icheck.min.js')}}'></script>--}}
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
{{--    <section class="py-5">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-1 col-md-1"></div>--}}
{{--            <div class="col-lg-10 col-md-10 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Warnings</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table">--}}
{{--                                <tr>--}}
{{--                                    <th>SL</th>--}}
{{--                                    <th>Name</th>--}}
{{--                                    <th>Description</th>--}}
{{--                                    <th class="text-center">Action</th>--}}
{{--                                </tr>--}}
{{--                                @foreach ($warnings as $key => $warning)--}}
{{--                                    <tr>--}}
{{--                                        <td># {{  $key + 1 }}</td>--}}
{{--                                        <td>{{ $warning->user->name }}</td>--}}
{{--                                        <td>{!! $warning->description !!}</td>--}}
{{--                                        <td class="text-center">--}}
{{--                                            @if (!empty($warning->appeal))--}}
{{--                                                <a href="{{ route('warning.appeal.show', $warning->id) }}" class="btn btn-outline-info btn-sm">--}}
{{--                                                    View Appeal--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
{{--                                            <a href="{{ route('warning.delete', $warning->id) }}" class="btn btn-outline-danger btn-sm"--}}
{{--                                                onclick="return confirm('Are you sure ?')">--}}
{{--                                                <i class="far fa-trash-alt"></i>--}}
{{--                                            </a>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-1 col-md-1"></div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}