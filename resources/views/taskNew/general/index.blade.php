@extends('layouts.joli')
@section('title', 'Task Management')
@section('link')

@endsection
@section('style')
    <style>
        .project-inner-area {
            position: relative;
        }

        .project-inner-area .pull-right {
            position: absolute;
            right: 10px;
            z-index: 9;
            bottom: 12px;
        }

        .project-inner-area .pull-right a {
            color: #aaa;
        }

        .project-inner-area .pull-right a:hover {
            color: #29B2E1;
        }


        .duplicate-task-text {
            margin-bottom: 10px;
            float: left;
            width: 100%;
            font-size: 12px;
            font-weight: 400;
            padding: 10px;
        }

        .cursor:hover {
            cursor: not-allowed !important;
        }

        .cursor2:hover {
            cursor: move !important;
        }

    </style>
@endsection
@section('breadcrumb')
    {{--    @php--}}
    {{--        $menuU = Storage::disk('local')->get('menu');--}}
    {{--        $menu = json_decode($menuU);--}}
    {{--    @endphp--}}
    <ul class="breadcrumb">
        <li class="active">Task Management</li>
    </ul>
@endsection
@section('pageTitle', 'Task Management')
@section('content')
    <div class="content-frame">
        <!-- START CONTENT FRAME TOP -->
        <div class="content-frame-top">
            <div class="page-title">
                <h2><span class="fa fa-arrow-circle-o-left"></span> Tasks</h2>
            </div>
            <div class="pull-right">
                <button class="btn btn-default content-frame-left-toggle"><span class="fa fa-bars"></span></button>
            </div>
        </div>
        <div class="content-frame-left">
            <div class="form-group">
                <h4>Projects:</h4>
                <div class="list-group border-bottom">
                    @foreach($projects as $i => $p)
                        <a href="javascript:void(0)" class="list-group-item projects {{ ($i == 0) ? "active" : "" }}"
                           pid="{{$p->id}}">
                            <span class="fa fa-circle text-secondary"></span> {{$p->title}}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                {{--                <div id="is_Gross"> </div>--}}
                <h4>Departments:</h4>
                <div class="list-group border-bottom">
                    <div class="all-departments" id="main-departments">
                        @if($departments != null)
                            @foreach($departments as $i => $d)
                                <div class="project-inner-area">
                                    <a href="javascript:void(0)"
                                       class="list-group-item departments {{ ($i == 0) ? "active" : "" }}"
                                       did="{{$d->id}}">
                                        <span class="fa fa-circle text-success"></span> {{$d->title}}
                                    </a>
                                    <div class="pull-right">
                                        <a href="{{route('department.comment', ['did' => $d->id])}}" target="_blank"
                                           title="Department Comment"><span
                                                    class="fa fa-comments"></span></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT FRAME TOP -->
        <!-- START CONTENT FRAME BODY -->
        <div class="content-frame-body">
            <div class="row push-up-10" id="main-body">
                <div class="col-md-4">
                    <h3>To-do List</h3>
                    <div class="tasks" id="tasks">
                        @foreach($tasks as $t)
                            @if(($t->progress * 1) == 0)
                                <div class="task-item task-info cursor2">
                                    <div class="task-text">
                                        <p>{{$t->title}}</p>
                                        {{$t->remark}}
                                        @if($t->dependencies)
                                            <br>
                                            @foreach($t->dependencies as $td)
                                                <a href="{{route('task.comment', ['tid' => $td->id])}}" target="_blank"
                                                   title="Task Comment">{{$td->title}}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="task-footer" tid="{{$t->id}}">
                                        <div class="pull-left"><span class="fa fa-clock-o"></span> {{$t->deadline}}
                                        </div>
                                        <div class="pull-right"><a href="{{route('task.comment', ['tid' => $t->id])}}"
                                                                   target="_blank" title="Task Comment"><span
                                                        class="fa fa-comments"></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <h3>In Progress</h3>
                    <div class="tasks" id="tasks_progreess">
                        @foreach($tasks as $t)
                            @if((($t->progress * 1) == 1) && (($t->submit * 1) == 0))
                                <div class="task-item task-info cursor2">
                                    <div class="task-text">
                                        <p>{{$t->title}}</p>
                                        {{$t->remark}}
                                        @if($t->dependencies)
                                            <br>
                                            @foreach($t->dependencies as $td)
                                                <a href="{{route('task.comment', ['tid' => $td->id])}}" target="_blank"
                                                   title="Task Comment">{{$td->title}}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="task-footer" tid="{{$t->id}}">
                                        <div class="pull-left"><span class="fa fa-clock-o"></span> {{$t->deadline}}
                                        </div>
                                        <div class="pull-right"><a href="{{route('task.comment', ['tid' => $t->id])}}"
                                                                   target="_blank" title="Task Comment"><span
                                                        class="fa fa-comments"></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="task-drop push-down-10">
                            <span class="fa fa-cloud"></span>
                            Drag your task here to start working on it
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3>Completed</h3>
                    <div class="tasks" id="tasks_completed">
                        @foreach($tasks as $t)
                            @if((($t->submit * 1) == 1) && (($t->submit_accept * 1) == 0))
                                <div class="task-item task-warning task-complete cursor2">
                                    <div class="task-text">
                                        <p>{{$t->title}}</p>
                                        {{$t->remark}}
                                        @if($t->dependencies)
                                            <br>
                                            @foreach($t->dependencies as $td)
                                                <a href="{{route('task.comment', ['tid' => $td->id])}}" target="_blank"
                                                   title="Task Comment">{{$td->title}}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="task-footer" tid="{{$t->id}}">
                                        <div class="pull-left"><span
                                                    class="fa fa-clock-o"></span> {{$t->updated_at}}
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{route('submit.report', ['tid' => $t->id])}}" target="_blank"
                                               title="Submit Report"><i class="glyphicon glyphicon-envelope"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @elseif(($t->submit_accept * 1) == 1)
                                <div class="task-item task-primary task-complete cursor">
                                    <div class="duplicate-task-text">
                                        <p>{{$t->title}}</p>
                                        {{$t->remark}}
                                        @if($t->dependencies)
                                            <br>
                                            @foreach($t->dependencies as $td)
                                                <a href="{{route('task.comment', ['tid' => $td->id])}}" target="_blank"
                                                   title="Task Comment">{{$td->title}}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="task-footer">
                                        <div class="pull-left">
                                            <span class="text-primary"><b>Accepted</b></span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="task-drop">
                            <span class="fa fa-cloud"></span>
                            Drag your task here to finish it
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT FRAME BODY -->
    </div>
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/moment.min.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/demo_tasks.js')}}"></script>--}}
    <script>
        $("body").on("mouseenter", "#tasks,#tasks_progreess,#tasks_completed", function () {
            $("#tasks,#tasks_progreess,#tasks_completed").sortable({
                items: "> .task-item",
                connectWith: "#tasks_progreess,#tasks_completed",
                handle: ".task-text",
                receive: function (event, ui) {
                    if (this.id == "tasks_completed") {
                        ui.item.find(".pull-right > a").remove();
                        var tid = ui.item.find(".task-footer").attr('tid');
                        var route = "{{route('submit.report', ['tid' => 'xxx'])}}";
                        var replace = route.replace('xxx', tid);
                        ui.item.find(".pull-right").append('<a href="' + replace + '" target="_blank" title="Submit Report"><i class="glyphicon glyphicon-envelope"></i></a>');
                        // call ajax here (task completed)
                        $.ajax({
                            url: '/ajax/task-status-change',
                            method: "GET",
                            data: {tid: tid, is_completed: 1},
                            success: function (r) {
                                return r;
                            }
                        });
                    }
                    if (this.id == "tasks_progreess") {
                        ui.item.find(".pull-right > a").remove();
                        var tid = ui.item.find(".task-footer").attr('tid');
                        var route = "{{route('task.comment', ['tid' => 'xxx'])}}";
                        var replace = route.replace('xxx', tid);
                        ui.item.find(".pull-right").append('<a href="' + replace + '" target="_blank" title="Task Comment"><span class="fa fa-comments"></span></a>');
                        // call ajax here (task in progress)
                        $.ajax({
                            url: '/ajax/task-status-change',
                            method: "GET",
                            data: {tid: tid, is_completed: 0},
                            success: function (r) {
                                return r;
                            }
                        });
                    }
                    page_content_onresize();
                }
            }).disableSelection();
        });
    </script>
    <script>
        $(function () {
            $("body").on("click", ".departments", function () {
                $('.departments').removeClass('active');
                $(this).addClass('active');
                var did = $(this).attr('did');
                $.ajax({
                    url: '/ajax/get-tasks-of-project',
                    method: "GET",
                    data: {did: did, is_pid: 0},
                    success: function (r) {
                        // $("#main-body").html(r);
                        $("#main-body").slideUp(1, e => {
                            $("#main-body").html(r).slideDown('slow');
                        });
                    }
                });
            });
            $('.projects').on('click', function () {
                $('.projects').removeClass('active');
                $(this).addClass('active');
                var pid = $(this).attr('pid');
                // ajax call to change departments
                $.ajax({
                    url: '/ajax/get-department-of-project',
                    method: "GET",
                    data: {pid: pid},
                    success: function (r) {
                        // $("#is_Gross").html(r);
                        $("#main-departments").slideUp(1, e => {
                            $("#main-departments").html(r).slideDown('slow');
                        });
                    }
                });
                // ajax call to change tasks
                $.ajax({
                    url: '/ajax/get-tasks-of-project',
                    method: "GET",
                    data: {pid: pid, is_pid: 1},
                    success: function (r) {
                        // $("#main-body").html(r);
                        $("#main-body").slideUp(1, e => {
                            $("#main-body").html(r).slideDown('slow');
                        });
                    }
                });

            });

        })
    </script>
    <!-- END THIS PAGE PLUGINS-->
@endsection