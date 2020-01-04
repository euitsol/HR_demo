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
                    <a href="#" class="list-group-item active"><span class="fa fa-circle text-secondary"></span> Project
                        #1</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-success"></span> Personal</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-warning"></span> Project #2</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-danger"></span> Meetings</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-info"></span> Work</a>
                </div>
            </div>
            <div class="form-group">
                <h4>Departments:</h4>
                <div class="list-group border-bottom">
                    <div class="project-inner-area">
                        <a href="#" class="list-group-item">
                            <span class="fa fa-circle text-secondary"></span> Department #1
                        </a>
                        <div class="pull-right">
                            <a href="#"><span class="fa fa-comments"></span></a>
                        </div>
                    </div>
                    <div class="project-inner-area">
                        <a href="#" class="list-group-item">
                            <span class="fa fa-circle text-success"></span> Personal
                        </a>
                        <div class="pull-right">
                            <a href="#"><span class="fa fa-comments"></span></a>
                        </div>
                    </div>
                    <div class="project-inner-area">
                        <a href="#" class="list-group-item active"><span class="fa fa-circle text-warning"></span>
                            Department #2</a>
                        <div class="pull-right">
                            <a href="#"><span class="fa fa-comments"></span></a>
                        </div>
                    </div>
                    <div class="project-inner-area">
                        <a href="#" class="list-group-item"><span class="fa fa-circle text-danger"></span> Meetings</a>
                        <div class="pull-right">
                            <a href="#"><span class="fa fa-comments"></span></a>
                        </div>
                    </div>
                    <div class="project-inner-area">
                        <a href="#" class="list-group-item"><span class="fa fa-circle text-info"></span> Work</a>
                        <div class="pull-right">
                            <a href="#"><span class="fa fa-comments"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT FRAME TOP -->
        <!-- START CONTENT FRAME BODY -->
        <div class="content-frame-body">
            <div class="row push-up-10">
                <div class="col-md-4">
                    <h3>To-do List</h3>
                    <div class="tasks" id="tasks">
                        <div class="task-item task-primary">
                            <div class="task-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris
                                rutrum velit vel erat fermentum, a dignissim dolor malesuada.
                            </div>
                            <div class="task-footer">
                                <div class="pull-left"><span class="fa fa-clock-o"></span> 1h 30min</div>
                            </div>
                        </div>
                        <div class="task-item task-success">
                            <div class="task-text">Suspendisse a tempor eros. Curabitur fringilla maximus lorem, eget
                                congue lacus ultrices eu. Nunc et molestie elit. Curabitur consectetur mollis ipsum, id
                                hendrerit nunc molestie id.
                            </div>
                            <div class="task-footer">
                                <div class="pull-left"><span class="fa fa-clock-o"></span> 1h 45min</div>
                                <div class="pull-right"><a href="#"><span class="fa fa-chain"></span></a> <a
                                            href="#"><span class="fa fa-comments"></span></a></div>
                            </div>
                        </div>
                        <div class="task-item task-warning">
                            <div class="task-text">Donec lacus lacus, iaculis nec pharetra id, congue ut tortor. Donec
                                tincidunt luctus metus eget rhoncus.
                            </div>
                            <div class="task-footer">
                                <div class="pull-left"><span class="fa fa-clock-o"></span> 1day ago</div>
                            </div>
                        </div>
                        <div class="task-item task-danger">
                            <div class="task-text">Pellentesque faucibus molestie lectus non efficitur. Vestibulum
                                mattis dignissim diam, eget dapibus urna rutrum vitae.
                            </div>
                            <div class="task-footer">
                                <div class="pull-left"><span class="fa fa-clock-o"></span> 2days ago</div>
                                <div class="pull-right"><a href="#"><span class="fa fa-chain"></span></a> <a
                                            href="#"><span class="fa fa-comments"></span></a></div>
                            </div>
                        </div>
                        <div class="task-item task-info">
                            <div class="task-text">Quisque quis ipsum quis magna bibendum laoreet.</div>
                            <div class="task-footer">
                                <div class="pull-left"><span class="fa fa-clock-o"></span> 3days ago</div>
                                <div class="pull-right"><a href="#"><span class="fa fa-chain"></span></a> <a
                                            href="#"><span class="fa fa-comments"></span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3>In Progress</h3>
                    <div class="tasks" id="tasks_progreess">
                        <div class="task-item task-warning">
                            <div class="task-text">In mauris nunc, blandit a turpis in, vehicula viverra metus. Quisque
                                dictum purus lorem, in rhoncus justo dapibus eget. Aenean pretium non mauris et
                                porttitor.
                            </div>
                            <div class="task-footer">
                                <div class="pull-left"><span class="fa fa-clock-o"></span> 2h 55min</div>
                                <div class="pull-right"><span class="fa fa-pause"></span> 4:51</div>
                            </div>
                        </div>
                        {{--                        <div class="task-drop push-down-10">--}}
                        {{--                            <span class="fa fa-cloud"></span>--}}
                        {{--                            Drag your task here to start it tracking time--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <div class="col-md-4">
                    <h3>Completed</h3>
                    <div class="tasks" id="tasks_completed">
                        <div class="task-item task-danger task-complete">
                            <div class="task-text">Donec maximus sodales feugiat.</div>
                            <div class="task-footer">
                                <div class="pull-left"><span class="fa fa-clock-o"></span> 15min</div>
                            </div>
                        </div>
                        <div class="task-item task-info task-complete">
                            <div class="task-text">Aliquam eget est a dui tincidunt commodo in nec ante.</div>
                            <div class="task-footer">
                                <div class="pull-left"><span class="fa fa-clock-o"></span> 35min</div>
                            </div>
                        </div>
                        {{--                        <div class="task-drop">--}}
                        {{--                            <span class="fa fa-cloud"></span>--}}
                        {{--                            Drag your task here to finish it--}}
                        {{--                        </div>--}}
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
        $("#tasks,#tasks_progreess,#tasks_completed").sortable({
            items: "> .task-item",
            connectWith: "#tasks_progreess,#tasks_completed",
            handle: ".task-text",
            receive: function (event, ui) {
                if (this.id == "tasks_completed") {
                    ui.item.addClass("task-complete").find(".task-footer > .pull-right").remove();
                    // call ajax here
                }
                if (this.id == "tasks_progreess") {
                    ui.item.find(".task-footer").append('<div class="pull-right"><span class="fa fa-play"></span> 00:00</div>');
                    // call ajax here
                }
                page_content_onresize();
            }
        }).disableSelection();
    </script>
    <!-- END THIS PAGE PLUGINS-->
@endsection