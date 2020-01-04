@extends('layouts.joli')
@section('title', 'Task Management')
@section('link')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
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

        .selectpicker .filter-option {
            font-size: 12px !important;
            color: #999999;
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
    <div class="row">
        {{--  Session notification is coming from toaster      --}}
        <div class="col">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Project Manager</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <h4>Add new Project:</h4>
                                <form action="{{route('project.store')}}" method="post">
                                    @csrf
                                    <textarea class="form-control push-down-10" rows="1" name="projectName"
                                              placeholder="Project Name" required></textarea>
                                    @if($errors->has('projectName'))
                                        <span class="help-block text-danger">{{$errors->first('projectName')}}</span>
                                    @endif

                                    <button class="btn btn-success">Add Project</button>
                                </form>
                            </div>
                            <div class="form-group">
                                <h4>Projects:</h4>
                                <div class="list-group border-bottom">
                                    @forelse($projects as $i => $p)
                                        <a href="javascript:void(0)"
                                           class="list-group-item projects {{ ($i == 0) ? "active" : "" }}"
                                           pid="{{$p->id}}">
                                            <span class="fa fa-circle text-secondary"></span> {{$p->title}}
                                        </a>
                                    @empty
                                        No Project to show
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            @if(count($projects)  > 0)
                                <div class="form-group">
                                    <h4>Add new Department:</h4>
                                    {{--                                <form action="{{route('department.store', ['pid' => $projects[0]->id])}}" method="post" id="department_form">--}}
                                    {{--                                    @csrf--}}
                                    {{--     Data is saved using ajax         --}}
                                    <textarea class="form-control push-down-10" rows="1"
                                              placeholder="Department Name" id="department_title"
                                              pid="{{$projects[0]->id}}"></textarea>
                                    <button class="btn btn-success" id="add_department_btn">Add Department</button>
                                    {{--                                </form>--}}
                                </div>
                            @endif
                            <div class="form-group">
                                <h4>Departments:</h4>
                                <div class="list-group border-bottom" id="departments">
                                    @if($departments && (count($departments) > 0))
                                        @foreach($departments as $i => $d)
                                            <a href="javascript:void(0)"
                                               class="list-group-item departments {{ ($i == 0) ? "active" : "" }}"
                                               did="{{$d->id}}">
                                                <span class="fa fa-circle text-secondary"></span> {{$d->title}}
                                            </a>
                                        @endforeach
                                    @else
                                        No Department to show
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h4>Tasks:</h4>
                                <div class="list-group border-bottom" id="tasks">
                                    @if($tasks && (count($tasks) > 0))
                                        @foreach($tasks as $i => $t)
                                            <div class="project-inner-area">
                                                <a href="{{route('task.detail', ['tid' => $t->id])}}"
                                                   class="list-group-item"
                                                   tid="{{$t->id}}" target="_blank">
                                                    <span class="fa fa-circle
                                                    @if(($t->submit_accept * 1) == 1)
                                                            text-success
                                                    @elseif(($t->submit * 1) == 1)
                                                            text-info
                                                    @else
                                                            text-secondary
                                                    @endif
                                                            "></span> {{$t->title}}
                                                </a>
                                            </div>
                                        @endforeach
                                        <small class="m-1 text-secondary">Click on task for details</small>
                                    @else
                                        No Task to show
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" id="create-task">
                            @if((count($projects)  > 0) && $departments  && (count($departments) > 0))
                                <div class="form-group">
                                    <h4>Add new task:</h4>
                                    {{--                                <form action="{{route('test')}}" method="post">--}}
                                    {{--                                    @csrf--}}
                                    {{--     Data is saved using ajax         --}}
                                    <input type="text" id="task_title" class="form-control mb-1"
                                           placeholder="Task Title">
                                    <input type="text" id="task_deadline" class="form-control datepicker mb-1"
                                           placeholder="Deadline" autocomplete="off">
                                    <select multiple="" name="assign[]" id="assign" class="form-control select"
                                            style="display: none !important;" required>
                                        @foreach($users as $u)
                                            <option value="{{$u->id}}">{{$u->title}}</option>
                                        @endforeach
                                        <div class="btn-group bootstrap-select show-tick form-control select"
                                             style="display: none !important;">
                                            <button type="button" class="btn dropdown-toggle selectpicker btn-default"
                                                    data-toggle="dropdown" title="Nothing selected"
                                                    aria-expanded="false">
                                                <span class="filter-option pull-left btn-color">Nothing selected</span>&nbsp;<span
                                                        class="caret"></span>
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
                                    <textarea id="task_details" class="form-control push-down-10 mt-1" rows="4"
                                              placeholder="Task Details"></textarea>
                                    <button class="btn btn-success" id="add_task_btn" pid="{{$projects[0]->id}}"
                                            did="{{$departments[0]->id}}">Add Task
                                    </button>
                                    {{--                                </form>--}}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(function () {
            $("body").on("click", ".departments", function () {
                $('.departments').removeClass('active');
                $(this).addClass('active');
                var did = $(this).attr('did');
                $.ajax({
                    url: '/ajax/manager/get-tasks-of-project',
                    method: "GET",
                    data: {did: did, is_pid: 0},
                    success: function (r) {
                        $("#tasks").slideUp(1, e => {
                            $("#tasks").html(r).slideDown('slow');
                        });
                    }
                });
                $("#add_task_btn").attr('did', did);
            });

            $('.projects').on('click', function () {
                $('.projects').removeClass('active');
                $(this).addClass('active');
                var pid = $(this).attr('pid');
                // ajax call to change departments
                $.ajax({
                    url: '/ajax/manager/get-department-of-project',
                    method: "GET",
                    data: {pid: pid},
                    success: function (r) {
                        $("#departments").slideUp(1, e => {
                            $("#departments").html(r).slideDown('slow');
                        });
                        if (r != 'No Department to show') {
                            $("#create-task").css("display", "block");
                        } else {
                            $("#create-task").css("display", "none");
                        }
                    }
                });
                // ajax call to change tasks
                $.ajax({
                    url: '/ajax/manager/get-tasks-of-project',
                    method: "GET",
                    data: {pid: pid, is_pid: 1},
                    success: function (r) {
                        $("#tasks").slideUp(1, e => {
                            $("#tasks").html(r).slideDown('slow');
                        });
                    }
                });
                $("#department_title").attr('pid', pid);
                $("#add_task_btn").attr('pid', pid);
            });

            $("#add_department_btn").on('click', e => {
                var pid = $("#department_title").attr('pid');
                var dTitle = $("#department_title").val();
                // console.log(dTitle);
                if (dTitle !== '') {
                    $.ajax({
                        url: '/ajax/manager/department_store',
                        method: "GET",
                        data: {pid: pid, title: dTitle},
                        success: function (r) {
                            if (r == '2') {
                                location.reload();
                            } else if (r == '1') {
                                $.ajax({
                                    url: '/ajax/manager/get-department-of-project',
                                    method: "GET",
                                    data: {pid: pid},
                                    success: function (r) {
                                        $("#departments").slideUp(1, e => {
                                            $("#departments").html(r).slideDown('slow');
                                        });
                                    }
                                });
                                $("#department_title").val('');
                            }
                        }
                    });
                    $("#create-task").css("display", "block");
                }
            });

            $("#add_task_btn").on('click', e => {
                var pid = $("#add_task_btn").attr('pid');
                var did = $("#add_task_btn").attr('did');
                var title = $('#task_title').val();
                var deadline = $('#task_deadline').val();
                var assign = $('#assign').val();
                var details = $('#task_details').val();
                if ((title !== '') && (deadline !== '') && (assign !== '') && (details !== '')) {
                    $.ajax({
                        url: "{{route('task.store')}}",
                        method: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            task_title: title,
                            task_deadline: deadline,
                            assign: assign,
                            task_details: details,
                            pid: pid,
                            did: did,
                        },
                        success: function (r) {
                            if (r == '1') {
                                $.ajax({
                                    url: '/ajax/manager/get-tasks-of-project',
                                    method: "GET",
                                    data: {did: did, is_pid: 0},
                                    success: function (r) {
                                        $("#tasks").slideUp(1, e => {
                                            $("#tasks").html(r).slideDown('slow');
                                        });
                                    }
                                });
                                $("#task_title").val('');
                                $("#task_details").val('');
                                $("#task_deadline").val('');
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script>
        @if(session('success'))
        toastr.info('{{session('success')}}');
        @elseif(session('unsuccess'))
        toastr.warning('{{session('success')}}');
        @endif
    </script>

    <!-- END THIS PAGE PLUGINS-->
@endsection