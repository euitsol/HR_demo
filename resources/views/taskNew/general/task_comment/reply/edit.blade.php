@extends('layouts.joli')
@section('title', 'Task Comment Reply Edit')
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
        <li>Reply</li>
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
                        <form action="{{route('task.reply.update', ['rid' => $redit->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <input type="file" name="file" id="file" style="display: none;">
                                    <button type="button" class="btn btn-default" id="file-btn"><span
                                                class="fa fa-camera"></span></button>
                                </div>
                                <input type="text" class="form-control {{$errors->has('reply') ? 'is-invalid' : ''}}"
                                       name="reply" value="{{$redit->replyt}}" required>
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Update Reply</button>
                                </div>
                            </div>
                            @if($errors->has('reply'))
                                <span class="help-block text-danger"
                                      style="margin-left: 100px;">{{$errors->first('reply')}}</span>
                            @endif
                        </form>
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