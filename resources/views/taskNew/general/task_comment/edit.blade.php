@extends('layouts.joli')
@section('title', 'Task Comment Edit')
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
        <li><a href="{{route('task.comment', ['tid' => $task->id])}}">Task Comment</a></li>
        <li class="active">Edit</li>
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
            <div class="tasks">
                <div class="task-item task-info">
                    <div class="task-text">
                        <p>{{$task->title}}</p>
                        {{$task->remark}}
                        @if($task->dependencies)
                            <br>
                            @foreach($task->dependencies as $td)
                                <a href="{{route('task.comment', ['tid' => $td->id])}}" target="_blank"
                                   title="Task Comment">{{$td->title}}</a>
                            @endforeach
                        @endif
                    </div>
                    <div class="task-footer" tid="{{$task->id}}">
                        <div class="pull-left"><span class="fa fa-clock-o"></span> {{$task->deadline}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-frame-body content-frame-body-left">
                <div class="panel panel-default push-up-10">
                    <div class="panel-body panel-body-search">
                        <form action="{{route('task.comment.update', ['cid' => $cedit->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <input type="file" name="file" id="file" style="display: none;">
                                    <button type="button" class="btn btn-default" id="file-btn"><span
                                                class="fa fa-camera"></span></button>
                                </div>
                                <input type="text" class="form-control {{$errors->has('comment') ? 'is-invalid' : ''}}"
                                       name="comment" value="{{$cedit->commentt}}" required>
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Update Comment</button>
                                </div>
                            </div>
                            @if($errors->has('comment'))
                                <span class="help-block text-danger"
                                      style="margin-left: 100px;">{{$errors->first('comment')}}</span>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="messages messages-img">
                    @foreach($comments as $c)
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
                                        @if(((Auth::id()) == (($c->user_id)*1)) && (($cedit->id * 1) != ($c->id)))
                                            <a href="{{route('task.comment.edit', ['cid' => $c->id])}}"
                                               title="Edit"><i
                                                        class="fa fa-pencil" style="color: #95b75d;"></i></a>
                                            <a href="{{route('task.comment.delete', ['cid' => $c->id])}}"
                                               title="Delete"
                                               onclick="return confirm('Are you sure you want to delete the comment ?')"><i
                                                        class="fa fa-trash-o" style="color: #E04B4A;"></i></a>
                                        @endif
                                    </span>
                                </div>
                                {{$c->commentt}}
                                @if($c->file != null)
                                    <br>
                                    @if ((pathinfo($c->file, PATHINFO_EXTENSION) == 'jpeg') || (pathinfo($c->file, PATHINFO_EXTENSION) == 'jpg') || (pathinfo($c->file, PATHINFO_EXTENSION) == 'png') ||(pathinfo($c->file, PATHINFO_EXTENSION) == 'gif'))
                                        <a href="{{route('download.task.comment.file', ['cid' => $c->id])}}"
                                           onclick="return confirm('Are you sure you want to download the image ?')">
                                            <img src="{{asset($c->file)}}" alt="img" class="comment-img">
                                        </a>
                                    @else
                                        <a href="{{route('download.task.comment.file', ['cid' => $c->id])}}">
                                            <i class="glyphicon glyphicon-cloud-download"></i>
                                        </a>
                                    @endif
                                @endif
                                <a href="{{route('task.reply', ['cid' => $c->id])}}" class="float-right"
                                   target="_blank">
                                    <i class="fa fa-mail-reply"></i>
                                </a>
                                {{--     Replies        --}}
                                @include('includes.joli.task_comment.replies')
                                {{--     Replies  End      --}}
                            </div>
                        </div>
                    @endforeach
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