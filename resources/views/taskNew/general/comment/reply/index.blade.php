@extends('layouts.joli')
@section('title', 'Department Comment Reply')
@section('style')
    <style>
        .comment-img {
            max-height: 100px;
            max-width: 500px;
            margin-left: 55px;
        }

        .messages.messages-img .item .image img {
            margin-top: 3px;
        }

        .reply-item {
            margin-bottom: 1px !important;
        }

        .reply-item-first {
            margin-top: 12px;
        }
    </style>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[51]->display_name}}</li>
        <li><a href="{{route('department.comment', ['did' => $department->id])}}">Department Comment</a></li>
        <li class="active">Reply</li>
    </ul>
@endsection
@section('pageTitle')
    {{$project->title}} {{$department->title}}
@endsection
@section('content')
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
    </div>
    <div class="row mb-5">
        <div class="col-md-10 offset-md-1">
            <div class="content-frame-body content-frame-body-left">
                <div class="panel panel-default push-up-10">
                    <div class="panel-body panel-body-search">
                        <form action="{{route('department.reply.store', ['cid' => $c->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <input type="file" name="file" id="file" style="display: none;">
                                    <button type="button" class="btn btn-default" id="file-btn"><span
                                                class="fa fa-camera"></span></button>
                                </div>
                                <input type="text" class="form-control {{$errors->has('reply') ? 'is-invalid' : ''}}"
                                       name="reply" placeholder="Your message..." required>
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Reply</button>
                                </div>
                            </div>
                            @if($errors->has('reply'))
                                <span class="help-block text-danger"
                                      style="margin-left: 100px;">{{$errors->first('reply')}}</span>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="messages messages-img">
                    <div class="item {{ (($c->user_id *1) == Auth::id()) ? "in" : "" }}">
                        <div class="image">
                            <img
                                    @if($c->user_image != null)
                                    src="{{asset($c->user_image)}}"
                                    @else
                                    src="{{asset('joli/avatar.png')}}"
                                    @endif
                                    alt="John Doe">
                        </div>
                        <div class="text">
                            <div class="heading">
                                <a href="#" style="text-decoration: none;">{{$c->user_name}}</a>
                                <span class="date">
                                        {{\Carbon\Carbon::createFromTimeStamp(strtotime($c->created_at))->diffForHumans()}}
                                    @if((Auth::id()) == (($c->user_id)*1))
                                        <a href="{{route('department.comment.edit', ['did' => $department->id,'cid' => $c->id])}}"
                                           title="Edit"><i
                                                    class="fa fa-pencil" style="color: #95b75d;"></i></a>
{{--                                        <a href="{{route('department.comment.delete', ['cid' => $c->id])}}"--}}
{{--                                           title="Delete"--}}
{{--                                           onclick="return confirm('Are you sure you want to delete the comment ?')"><i--}}
{{--                                                    class="fa fa-trash-o" style="color: #E04B4A;"></i></a>--}}
                                    @endif
                                    </span>
                            </div>
                            {{$c->comment}}
                            @if($c->file != null)
                                <br>
                                @if ((pathinfo($c->file, PATHINFO_EXTENSION) == 'jpeg') || (pathinfo($c->file, PATHINFO_EXTENSION) == 'jpg') || (pathinfo($c->file, PATHINFO_EXTENSION) == 'png') ||(pathinfo($c->file, PATHINFO_EXTENSION) == 'gif'))
                                    <a href="{{route('download.department.comment.file', ['cid' => $c->id])}}"
                                       onclick="return confirm('Are you sure you want to download the image ?')">
                                        <img src="{{asset($c->file)}}" alt="img" class="comment-img">
                                    </a>
                                @else
                                    <a href="{{route('download.department.comment.file', ['cid' => $c->id])}}">
                                        <i class="glyphicon glyphicon-cloud-download"></i>
                                    </a>
                                @endif
                            @endif
{{--                            <a href="{{route('department.reply', ['cid' => $c->id])}}" class="float-right"--}}
{{--                               target="_blank">--}}
{{--                                <i class="fa fa-mail-reply"></i>--}}
{{--                            </a>--}}
                            {{--     Reply        --}}
                            @include('includes.joli.department_comment.replies')
                            {{--     Reply  End      --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    <script>
        $(function () {
            $("#file-btn").on('click', e => {
                $("#file").click();
            });
        });
    </script>
    <!-- END THIS PAGE PLUGINS-->
@endsection