@extends('layouts.joli')
@section('title', 'Private Communication')
@section('link')
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
@endsection
@section('style')
    <style>
        .left-left {
            height: calc(100vh - 265px) !important;
        }

        .fa-flagD:hover {
            color: #F9F9F9;
        }
    </style>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[39]->display_name}}</li>
        <li>{{$menu[41]->display_name}}</li>
        <li><a href="{{route('message.create')}}">Compose</a></li>
    </ul>
@endsection
@section('pageTitle', 'Private Messaging')
@section('content')
    <div class="row">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
    @endif
    <!-- START CONTENT FRAME -->
        <div class="content-frame">
            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">
                <div class="page-title">
                    <h2><span class="fa fa-edit"></span> Compose</h2>
                </div>
            </div>
            <!-- END CONTENT FRAME TOP -->
            <!-- START CONTENT FRAME LEFT -->
            <div class="content-frame-left left-left">
                <div class="block">
                    <div class="list-group border-bottom">
                        <a href="{{route('message.inbox')}}" class="list-group-item"><span class="fa fa-inbox"></span>
                            Inbox
                            @if(Auth::user()->new_message_count > 0)
                                <span class="badge badge-success">{{Auth::user()->new_message_count}}</span>
                            @endif
                        </a>
                        <a href="{{route('message.sent')}}" class="list-group-item"><span class="fa fa-rocket"></span>
                            Sent</a>
                    </div>
                </div>
            </div>
            <!-- END CONTENT FRAME LEFT -->
            <!-- START CONTENT FRAME BODY -->
            <div class="content-frame-body left-left">
                <div class="block">
                    <form action="{{ route('message.send') }}" role="form" class="form-horizontal"
                          enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                                class="fa fa-refresh"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">To:</label>
                            <div class="col-md-8">
                                <select class="form-control" name="receiver" required>
                                    <option selected disabled hidden value="">Choose...</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" {{(old('receiver')== $user->id)?'selected':'' }}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('receiver'))
                                    <span class="help-block text-danger">{{$errors->first('receiver')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Attachments:</label>
                            <div class="col-md-10">
                                <input type="file" class="file" data-filename-placement="inside" name="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea name="message"></textarea>
                                @if($errors->has('message'))
                                    <span class="help-block text-danger">{{$errors->first('message')}}</span>
                                @endif
                            </div>
                            <script>CKEDITOR.replace('message');</script>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-success"><span class="fa fa-envelope"></span>
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>            <!-- END CONTENT FRAME BODY -->
        </div>
        <!-- END CONTENT FRAME -->
    </div>
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->

    <!-- END THIS PAGE PLUGINS-->
@endsection










{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}

{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-10 offset-lg-1 col-md-10 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">New Message</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}

{{--                        --}}{{--                        @if(session('success'))--}}
{{--                        --}}{{--                            <div class="alert alert-success text-center">--}}
{{--                        --}}{{--                                {{session('success')}}--}}
{{--                        --}}{{--                            </div>--}}
{{--                        --}}{{--                        @endif--}}

{{--                        --}}{{--                        <form action="{{ route('message.send') }}" method="post" enctype="multipart/form-data">--}}
{{--                        --}}{{--                            @csrf--}}

{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Receiver</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                --}}{{--                                    <select name="receiver" class="form-control">--}}
{{--                                --}}{{--                                        <option value="">Choose</option>--}}
{{--                                --}}{{--                                        @foreach ($users as $user)--}}
{{--                                --}}{{--                                            <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                                --}}{{--                                        @endforeach--}}
{{--                                --}}{{--                                    </select>--}}
{{--                                --}}{{--                                    @if($errors->has('receiver'))--}}
{{--                                --}}{{--                                        <span class="help-block text-danger">{{$errors->first('receiver')}}</span>--}}
{{--                                --}}{{--                                    @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Message</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <textarea name="message"></textarea>--}}
{{--                                @if($errors->has('message'))--}}
{{--                                    <span class="help-block text-danger">{{$errors->first('message')}}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <script>CKEDITOR.replace('message');</script>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Upload</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="file" name="file">--}}
{{--                                @if($errors->has('file'))--}}
{{--                                    <span class="help-block text-danger">{{$errors->first('file')}}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-9 ml-auto">--}}
{{--                                <input type="submit" value="Send" class="btn btn-primary">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        </form>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </section>--}}
{{--</div>--}}

{{--@include('includes.bubbly.footer')--}}