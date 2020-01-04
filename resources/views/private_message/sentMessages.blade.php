@extends('layouts.joli')
@section('title', 'Private Communication')
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
        <li class="active"><a href="{{route('message.sent')}}">Sent</a></li>
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
                    <h2><span class="fa fa-rocket"></span> Outbox</h2>
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
                        <a href="javascript:void(0);" class="list-group-item active"><span class="fa fa-rocket"></span>
                            Sent</a>
                    </div>
                </div>
            </div>
            <!-- END CONTENT FRAME LEFT -->

            <!-- START CONTENT FRAME BODY -->
            <div class="content-frame-body left-left">
                <div class="panel panel-default">
                    <div class="panel-body mail">
                        @foreach ($sentItems as $item)
                            <div class="mail-item {{ ($item->status != 'seen') ? "mail-unread mail-info" : "" }}">
                                <div class="mail-user">{{ $item->receiver }}</div>
                                <a href="{{ route('message.sent.show', $item->id) }}"
                                   class="mail-text">{!! Str::limit($item->message_body, 40) !!}</a>
                                <div class="mail-date">
                                    {{ date('d M, Y h:i:s A', strtotime($item->created_at)) }}
                                    <a href="{{ route('message.sent.delete', $item->id) }}"
                                       class="btn btn-outline-danger btn-sm fa-flagD"
                                       onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                                @if($item->file != null)
                                    <div class="mail-attachments">
                                        <span class="fa fa-paperclip" style="margin-top: 6px;"></span>
                                    </div>
                                @endif
                                @if ($item->status == 'seen')
                                    <span class="text-muted" style="float: right; margin-right: 40px; margin-top: 3px;">
                                        {{ ucfirst($item->status) }} at {{ date('d M, Y h:i:s A', strtotime($item->updated_at)) }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="panel-footer">
                        {{ $sentItems->links() }}
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
{{--            <div class="col-lg-10 offset-lg-1 col-md-10 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Sent Messages</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}

{{--                        @foreach ($sentMessages as $item)--}}
{{--                            <div class="row border-bottom mt-3">--}}
{{--                                <div class="col">--}}
{{--                                    <h3 class="h6 text-uppercase mb-0">{{ $item['receiver'] }}</h3>--}}
{{--                                    <p class="text-muted">--}}
{{--                                        <i class="fa fa-calendar"></i> {{ date('d M, Y h:i:s A', strtotime($item['date'])) }}--}}
{{--                                    </p>--}}
{{--                                    <div>--}}
{{--                                        <a href="{{ route('message.sent.show', $item['id']) }}" style="text-decoration:none">--}}
{{--                                            {!! Str::limit($item['msg'], 40) !!}--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    @if ($item['status'] == 'seen')--}}
{{--                                        <span class="text-muted">--}}
{{--                                        {{ ucfirst($item['status']) }} at {{ date('d M, Y h:i:s A', strtotime($item['seenTime'])) }}--}}
{{--                                    </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="col">--}}
{{--                                    <a href="{{ route('message.sent.delete', $item['id']) }}" class="btn btn-danger btn-sm float-right" onclick="return confirm('Are you sure?')">--}}
{{--                                        <i class="fa fa-trash"></i>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </section>--}}
{{--</div>--}}

{{--@include('includes.bubbly.footer')--}}