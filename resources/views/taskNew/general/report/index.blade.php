@extends('layouts.joli')
@section('title', 'Task Submit Report')
@section('link')
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
@endsection
@section('style')
    <style>
        .messages.messages-img .item .image img {
            margin-top: 3px;
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
        <li><a href="{{route('task.comment', ['tid' => $task->id])}}">Task</a></li>
        <li class="active">Submit Report</li>
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
                        <form action="{{route('submit.report.store', ['tid' => $task->id])}}" class="form-horizontal"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-2 col-xs-12 control-label">Submit Report</label>
                                    <div class="col-md-8 col-xs-12">
                                        <textarea
                                                class="form-control {{$errors->has('report') ? 'is-invalid' : ''}}"
                                                rows="5" name="report" required>
                                            @if($task->submit_report)
                                                {!! $task->submit_report !!}
                                            @endif
                                        </textarea>
                                        <script>
                                            CKEDITOR.replace('report');
                                        </script>
                                        @if($errors->has('report'))
                                            <span class="help-block text-danger">{{$errors->first('report')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-2 col-xs-12 control-label">File Upload</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="file" name="file">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                            class="fa fa-refresh"></span></a>
                                <button class="btn btn-primary pull-right">Submit</button>
                            </div>
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