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
        <li><a href="{{route('message.inbox')}}">Inbox</a></li>
        <li class="active">Single Message</li>
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
                    <h2><span class="fa fa-file-text"></span> Message</h2>
                </div>
            </div>
            <!-- END CONTENT FRAME TOP -->
            <!-- START CONTENT FRAME LEFT -->
            <div class="content-frame-left left-left">
                <div class="block">
                    <a href="{{route('message.create')}}" class="btn btn-danger btn-block btn-lg"><span
                                class="fa fa-edit"></span> COMPOSE</a>
                </div>
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
                <div class="panel panel-default">
                    <div class="panel-heading ui-draggable-handle">
                        <div class="pull-left">
                            <img class="panel-title-image" alt="John Doe"
                                 @if($sender->image)
                                 src="{{asset($sender->image)}}"
                                 @else
                                 src="{{asset('joli/avatar.png')}}"
                                 @endif
                            >
                            <h3 class="panel-title">{{ $sender->name }}</h3>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('message.inbox.show.delete', $mid) }}" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure ?')"><i
                                        class="fa fa-trash-o"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <h3>
                            <small class="pull-right text-muted"><span class="fa fa-clock-o"></span>
                                {{ date('d M, Y h:i:s A', strtotime($created_at)) }}
                            </small>
                        </h3>
                        {!! $msg !!}
                        @if ($file)
                            @php($ext = ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'])
                            @if (in_array(pathinfo($file, PATHINFO_EXTENSION), $ext))
                                <a href="{{ route('message.file.download', $mid) }}">
                                    <img src="{{ asset($file) }}" alt="Image" style="max-height:200px">
                                </a>
                            @else
                                <a href="{{ route('message.file.download', $mid) }}">
                                    <i class="fas fa-file-download" style="font-size: 50px; color: #2ecc71;"></i>
                                </a>
                            @endif
                        @endif
                        <div class="form-group push-up-20">
                            <label>Quick Reply</label>
                            <form action="{{ route('message.reply') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="receiver" value="{{ $sender_id }}">
                                <textarea name="message"></textarea>
                                @if($errors->has('message'))
                                    <span class="help-block text-danger">{{$errors->first('message')}}</span>
                                @endif
                                <script>CKEDITOR.replace('message');</script>
                                <input type="file" name="file">
                                <button type="submit" class="btn btn-success pull-right"><span
                                            class="fa fa-mail-reply"></span> Reply
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT FRAME BODY -->
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
{{--            <div class="col-lg-10 offset-lg-1 col-md-10 offset-md-1 mb-3">--}}
{{--                <div class="card mb-2">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Message Body</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row border-bottom mt-3">--}}
{{--                            <div class="col">--}}
{{--                                --}}{{--                                <h3 class="h6 text-uppercase mb-0">{{ $sender }}</h3>--}}
{{--                                <p class="text-muted">--}}
{{--                                    --}}{{--                                    <i class="fa fa-calendar"></i> {{ date('d M, Y h:i:s A', strtotime($created_at)) }}--}}
{{--                                </p>--}}
{{--                                --}}{{--                                {!! $msg !!}--}}
{{--                                --}}{{-- file --}}
{{--                                --}}{{--                                @if ($file)--}}

{{--                                --}}{{--                                    @php($ext = ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'])--}}

{{--                                --}}{{--                                    @if (in_array(pathinfo($file, PATHINFO_EXTENSION), $ext))--}}
{{--                                --}}{{--                                        <a href="{{ route('message.file.download', $mid) }}">--}}
{{--                                --}}{{--                                            <img src="{{ asset($file) }}" alt="Image" style="max-height:200px">--}}
{{--                                --}}{{--                                        </a>--}}
{{--                                --}}{{--                                    @else--}}
{{--                                --}}{{--                                        <a href="{{ route('message.file.download', $mid) }}">--}}
{{--                                --}}{{--                                            <i class="fas fa-file-download" style="font-size: 50px; color: #2ecc71;"></i>--}}
{{--                                --}}{{--                                        </a>--}}
{{--                                --}}{{--                                    @endif--}}

{{--                                --}}{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                --}}{{--                                <a href="{{ route('message.inbox.show.delete', $mid) }}" class="btn btn-danger btn-sm float-right" onclick="return confirm('Are you sure?')">--}}
{{--                                --}}{{--                                    <i class="fa fa-trash"></i>--}}
{{--                                --}}{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="col-lg-10 offset-lg-1 col-md-10 offset-md-1">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Message To {{ $sender }}</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}

{{--                        --}}{{--                        @if(session('success'))--}}
{{--                        --}}{{--                            <div class="alert alert-success text-center">--}}
{{--                        --}}{{--                                {{session('success')}}--}}
{{--                        --}}{{--                            </div>--}}
{{--                        --}}{{--                        @endif--}}

{{--                        --}}{{--                        <form action="{{ route('message.reply') }}" method="post" enctype="multipart/form-data">--}}
{{--                        --}}{{--                            @csrf--}}

{{--                        --}}{{--                            <input type="hidden" name="receiver" value="{{ $sender_id }}">--}}

{{--                        --}}{{--                            <div class="form-group row">--}}
{{--                        --}}{{--                                <label class="col-md-3 form-control-label">Message</label>--}}
{{--                        --}}{{--                                <div class="col-md-9">--}}
{{--                        --}}{{--                                    <textarea name="message"></textarea>--}}
{{--                        --}}{{--                                    @if($errors->has('message'))--}}
{{--                        --}}{{--                                        <span class="help-block text-danger">{{$errors->first('message')}}</span>--}}
{{--                        --}}{{--                                    @endif--}}
{{--                        --}}{{--                                </div>--}}
{{--                        --}}{{--                                <script>CKEDITOR.replace('message');</script>--}}
{{--                        --}}{{--                            </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 form-control-label">Upload</label>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <input type="file" name="file">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-9 ml-auto">--}}
{{--                                <input type="submit" value="Send" class="btn btn-primary">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}

{{--@include('includes.bubbly.footer')--}}