@extends('layouts.joli')
@section('title', 'Task Details')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[51]->display_name}}</li>
        <li><a href="{{route('task.project.manager')}}">{{$menu[52]->display_name}}</a></li>
        <li class="active">Task Details</li>
    </ul>
@endsection
@section('pageTitle', 'Task Details')
@section('content')
    <div class="row mb-5">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        @elseif(session('unsuccess'))
            <div class="alert alert-danger text-center">
                {{session('unsuccess')}}
            </div>
        @endif
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Task Detail</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('task.detail.update', ['tid' => $task->id])}}" class="form-horizontal"
                      method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" value="{{$task->title}}" name="title" required
                                           class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('title'))
                                    <span class="help-block text-danger">{{$errors->first('title')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Deadline</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input type="date" value="{{$task->deadline}}" name="deadline" required
                                           class="form-control {{$errors->has('deadline') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('deadline'))
                                    <span class="help-block text-danger">{{$errors->first('deadline')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Remark</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    {{--                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>--}}
                                    <textarea class="form-control {{$errors->has('remark') ? 'is-invalid' : ''}}"
                                              rows="5" name="remark" required>{{$task->remark}}</textarea>
                                </div>
                                @if($errors->has('remark'))
                                    <span class="help-block text-danger">{{$errors->first('remark')}}</span>
                                @endif
                            </div>
                        </div>
                        {{--      Assigned User  --}}
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Assigned To</label>
                            <div class="col-md-6 col-xs-12">
                                <select multiple="" name="assign[]" id="assign" class="form-control select"
                                        style="display: none !important;" required>
                                    @foreach($users as $u)
                                        <option value="{{$u->id}}" {{(($u->assign * 1) == 1) ? "selected" : ""}}>{{$u->title}}</option>
                                    @endforeach
                                    <div class="btn-group bootstrap-select show-tick form-control select"
                                         style="display: none !important;">
                                        <button type="button" class="btn dropdown-toggle selectpicker btn-default"
                                                data-toggle="dropdown" title="Nothing selected"
                                                aria-expanded="false">
                                            <span class="filter-option pull-left btn-color">Nothing selected</span>&nbsp;
                                            <span class="caret"></span>
                                        </button>
                                        <div class="dropdown-menu open"
                                             style="max-height: 390px; overflow: hidden; min-height: 121px;">
                                            <ul class="dropdown-menu inner selectpicker" role="menu"
                                                style="max-height: 388px; overflow-y: auto; min-height: 119px;">
                                                @foreach($users as $i => $u)
                                                    <li rel="{{$i}}" class="">
                                                        <a tabindex="0" class="" style="">
                                                            <span class="text">{{$u->title}}</span>
                                                            <i class="glyphicon glyphicon-ok icon-ok check-mark"></i>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </select>
                            </div>
                        </div>
                        {{--      Task Priority          --}}
                        {{--                        @if(count($tasks) > 1)--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label class="col-md-3 col-xs-12 control-label">More Important Task</label>--}}
                        {{--                                <div class="col-md-6 col-xs-12">--}}
                        {{--                                    <div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 5px;">--}}
                        {{--                                        @foreach($tasks as $t)--}}
                        {{--                                            @if($t->id != $task->id)--}}
                        {{--                                                <input type="checkbox" class="custom-control-input" id="{{$t->title}}">--}}
                        {{--                                                <label class="custom-control-label"--}}
                        {{--                                                       for="{{$t->title}}">{{$t->title}}</label>--}}
                        {{--                                                <br>--}}
                        {{--                                            @endif--}}
                        {{--                                        @endforeach--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        @endif--}}
                    </div>
                    <div class="panel-footer">
                        <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                    class="fa fa-refresh"></span></a>
                        @if($task->submit_accept == 0)
                            <button class="btn btn-primary pull-right">Update</button>
                        @else
                            <button class="btn btn-primary pull-right disabled">Already accepted task</button>
                        @endif
                    </div>
                </form>
                {{--     Form end               --}}
            </div>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Task Status</h3>
                </div>
                <div class="panel-body">
                    @if($task->progress == 0)
                        The Task has not been started yet.
                    @elseif(($task->progress == 1) && ($task->submit == 0))
                        The Task is in progress
                    @elseif(($task->submit == 1) && ($task->submit_accept == 0))
                        The Task is submitted.
                        @if($task->submit_report)
                            Here is the Submit Report:
                            {!! $task->submit_report !!}
                        @endif
                        @if($task->submit_file)
                            <a href="{{route('downloadTaskFile', ['tid' => $task->id])}}"
                               title="Download" style="color: inherit;">
                                <i class="glyphicon glyphicon-download-alt" style="font-size: 35px;"></i>
                            </a>
                        @endif
                        <div class="float-right">
                            <a href="{{route('task.accept2', ['tid' => $task->id])}}" class="btn btn-sm btn-success"
                               onclick="return confirm('Are you sure ?')">Accept</a>
                            <a href="{{route('task.reopen2', ['tid' => $task->id])}}" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure ?')">Reopen</a>
                        </div>
                    @elseif($task->submit_accept == 1)
                        Already Accepted Task.
                        @if($task->submit_report)
                            Here is the Submit Report:
                            {!! $task->submit_report !!}
                        @endif
                        @if($task->submit_file)
                            <a href="{{route('downloadTaskFile', ['tid' => $task->id])}}"
                               title="Download" style="color: inherit;">
                                <i class="glyphicon glyphicon-download-alt" style="font-size: 35px;"></i>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>

@endsection