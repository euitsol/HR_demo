@extends('layouts.joli')
@section('title', 'Complain')
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
        <li class="active">{{$menu[43]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Complain')
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
                    <h3 class="panel-title">Create Complain</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{ route('warning.store') }}" class="form-horizontal" method="post">
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
                        <button class="btn btn-primary pull-right">Submit</button>
                    </div>
                </form>
                {{--     Form end               --}}
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
{{--            <div class="col-lg-1 col-md-1"></div>--}}
{{--            <div class="col-lg-10 col-md-10 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        --}}{{--                        <h3 class="h6 text-uppercase mb-0">Create Warning</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{ route('warning.store') }}" class="form-horizontal"--}}
{{--                              method="post" enctype="multipart/form-data">--}}
{{--                            @csrf--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Name</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <select name="name" id="" class="form-control form-control-success {{$errors->has('name') ? 'has-error' : ''}}">--}}
{{--                            --}}{{--                                        <option value="">Choose...</option>--}}
{{--                            --}}{{--                                        @foreach ($users as $user)--}}
{{--                            --}}{{--                                            <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                            --}}{{--                                        @endforeach--}}
{{--                            --}}{{--                                    </select>--}}
{{--                            --}}{{--                                    @if($errors->has('name'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('name')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Description</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <textarea--}}
{{--                                            class="form-control form-control-success {{$errors->has('warningDescription') ? 'has-error' : ''}}"--}}
{{--                                            name="warningDescription" id="" cols="30" rows="4" required></textarea>--}}
{{--                                    <script>--}}
{{--                                        CKEDITOR.replace('warningDescription');--}}
{{--                                    </script>--}}
{{--                                    @if($errors->has('warningDescription'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('warningDescription')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
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