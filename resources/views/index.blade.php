@extends('layouts.joli')
@section('title', 'Dashboard')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li class="active">
            {{$menu[0]->display_name}}
        </li>
    </ul>
@endsection
@section('pageTitle', 'Dashboard')
{{--    <span class="fa fa-arrow-circle-o-left"></span> Dashboard--}}
{{--@endsection--}}
@section('content')
    <!-- START WIDGETS -->
    <div class="row">
        <div class="col-md-3">
            <!-- START WIDGET SLIDER -->
            <div class="widget widget-default widget-carousel">
                <div class="owl-carousel" id="owl-example">
                    <div>
                        <div class="widget-title">Total Visitors</div>
                        <div class="widget-subtitle">27/08/2014 15:23</div>
                        <div class="widget-int">3,548</div>
                    </div>
                    <div>
                        <div class="widget-title">Returned</div>
                        <div class="widget-subtitle">Visitors</div>
                        <div class="widget-int">1,695</div>
                    </div>
                    <div>
                        <div class="widget-title">New</div>
                        <div class="widget-subtitle">Visitors</div>
                        <div class="widget-int">1,977</div>
                    </div>
                </div>
                <div class="widget-controls">
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top"
                       title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
            </div>
            <!-- END WIDGET SLIDER -->
        </div>
        <div class="col-md-3">
            <!-- START WIDGET MESSAGES -->
            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-messages.html';">
                <div class="widget-item-left">
                    <span class="fa fa-envelope"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int num-count">48</div>
                    <div class="widget-title">New messages</div>
                    <div class="widget-subtitle">In your mailbox</div>
                </div>
                <div class="widget-controls">
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top"
                       title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
            </div>
            <!-- END WIDGET MESSAGES -->
        </div>
        <div class="col-md-3">
            <!-- START WIDGET REGISTRED -->
            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-address-book.html';">
                <div class="widget-item-left">
                    <span class="fa fa-user"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int num-count">375</div>
                    <div class="widget-title">Registred users</div>
                    <div class="widget-subtitle">On your website</div>
                </div>
                <div class="widget-controls">
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top"
                       title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
            </div>
            <!-- END WIDGET REGISTRED -->
        </div>
        <div class="col-md-3">
            <!-- START WIDGET CLOCK -->
            <div class="widget widget-info widget-padding-sm">
                <div class="widget-big-int plugin-clock">00:00</div>
                <div class="widget-subtitle plugin-date">Loading...</div>
                <div class="widget-controls">
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left"
                       title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
                <div class="widget-buttons widget-c3">
                    <div class="col">
                        <a href="#"><span class="fa fa-clock-o"></span></a>
                    </div>
                    <div class="col">
                        <a href="#"><span class="fa fa-bell"></span></a>
                    </div>
                    <div class="col">
                        <a href="#"><span class="fa fa-calendar"></span></a>
                    </div>
                </div>
            </div>
            <!-- END WIDGET CLOCK -->
        </div>
    </div>
    <!-- END WIDGETS -->
    <div class="row">
        <div class="col-md-4">
            <!-- START USERS ACTIVITY BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Users Activity</h3>
                        <span>Users vs returning</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span>
                                        Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div class="chart-holder" id="dashboard-bar-1" style="height: 200px;"></div>
                </div>
            </div>
            <!-- END USERS ACTIVITY BLOCK -->
        </div>
        <div class="col-md-4">
            <!-- START VISITORS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Visitors</h3>
                        <span>Visitors (last month)</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span>
                                        Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div class="chart-holder" id="dashboard-donut-1" style="height: 200px;"></div>
                </div>
            </div>
            <!-- END VISITORS BLOCK -->
        </div>

        <div class="col-md-4">
            <!-- START PROJECTS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Projects</h3>
                        <span>Projects activity</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span>
                                        Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body panel-body-table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="50%">Project</th>
                                <th width="20%">Status</th>
                                <th width="30%">Activity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><strong>Joli Admin</strong></td>
                                <td><span class="label label-danger">Developing</span></td>
                                <td>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 85%;">85%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Gemini</strong></td>
                                <td><span class="label label-warning">Updating</span></td>
                                <td>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 40%;">40%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Taurus</strong></td>
                                <td><span class="label label-warning">Updating</span></td>
                                <td>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 72%;">72%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Leo</strong></td>
                                <td><span class="label label-success">Support</span></td>
                                <td>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 100%;">100%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Virgo</strong></td>
                                <td><span class="label label-success">Support</span></td>
                                <td>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 100%;">100%
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- END PROJECTS BLOCK -->

        </div>
    </div>

    <div class="row">
        <div class="col-md-8">

            <!-- START SALES BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Sales</h3>
                        <span>Sales activity by period you selected</span>
                    </div>
                    <ul class="panel-controls panel-controls-title">
                        <li>
                            <div id="reportrange" class="dtrange">
                                <span></span><b class="caret"></b>
                            </div>
                        </li>
                        <li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="row stacked">
                        <div class="col-md-4">
                            <div class="progress-list">
                                <div class="pull-left"><strong>In Queue</strong></div>
                                <div class="pull-right">75%</div>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 75%;">75%
                                    </div>
                                </div>
                            </div>
                            <div class="progress-list">
                                <div class="pull-left"><strong>Shipped Products</strong></div>
                                <div class="pull-right">450/500</div>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 90%;">90%
                                    </div>
                                </div>
                            </div>
                            <div class="progress-list">
                                <div class="pull-left"><strong class="text-danger">Returned Products</strong></div>
                                <div class="pull-right">25/500</div>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 5%;">5%
                                    </div>
                                </div>
                            </div>
                            <div class="progress-list">
                                <div class="pull-left"><strong class="text-warning">Progress Today</strong></div>
                                <div class="pull-right">75/150</div>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%
                                    </div>
                                </div>
                            </div>
                            <p><span class="fa fa-warning"></span> Data update in end of each hour. You can update it
                                manual by pressign update button</p>
                        </div>
                        <div class="col-md-8">
                            <div id="dashboard-map-seles" style="width: 100%; height: 200px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SALES BLOCK -->
        </div>
        <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-content">
                <ul class="list-inline item-details">
                    <li>
                        <a href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin
                            templates</a></li>
                    <li><a href="http://themescloud.org">Bootstrap themes</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <!-- START SALES & EVENTS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Sales & Event</h3>
                        <span>Event "Purchase Button"</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span>
                                        Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div class="chart-holder" id="dashboard-line-1" style="height: 200px;"></div>
                </div>
            </div>
            <!-- END SALES & EVENTS BLOCK -->
        </div>
    </div>
    <!-- START DASHBOARD CHART -->
    <div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
    <div class="block-full-width"></div>
    <!-- END DASHBOARD CHART -->
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    <script type="text/javascript" src="{{asset('joli/js/demo_dashboard.js')}}"></script>
    <script type='text/javascript' src="{{asset('joli/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/morris/raphael-min.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/morris/morris.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/rickshaw/d3.v3.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/rickshaw/rickshaw.min.js')}}"></script>
    <script type='text/javascript'
            src="{{asset('joli/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script type='text/javascript'
            src="{{asset('joli/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script type='text/javascript' src="{{asset('joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/owl/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('joli/js/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- END THIS PAGE PLUGINS-->
@endsection


{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}

{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-4">--}}
{{--        @if(session('KpiVoteSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('KpiVoteSuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">--}}
{{--                <div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">--}}
{{--                    <div class="flex-grow-1 d-flex align-items-center">--}}
{{--                        <div class="dot mr-3 bg-violet"></div>--}}
{{--                        <div class="text">--}}
{{--                            <h6 class="mb-0">Job Circular</h6><span class="text-gray">{{$totalNotice}}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="icon text-white bg-violet"><i class="fas fa-server"></i></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">--}}
{{--                <div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">--}}
{{--                    <div class="flex-grow-1 d-flex align-items-center">--}}
{{--                        <div class="dot mr-3 bg-green"></div>--}}
{{--                        <div class="text">--}}
{{--                            <h6 class="mb-0">Total Applicant</h6><span class="text-gray">{{$totalApplicants}}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="icon text-white bg-green"><i class="far fa-clipboard"></i></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">--}}
{{--                <div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">--}}
{{--                    <div class="flex-grow-1 d-flex align-items-center">--}}
{{--                        <div class="dot mr-3 bg-blue"></div>--}}
{{--                        <div class="text">--}}
{{--                            <h6 class="mb-0">Ongoing Projects</h6><span class="text-gray">{{$onGoingProject}}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="icon text-white bg-blue"><i class="fa fa-dolly-flatbed"></i></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">--}}
{{--                <div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">--}}
{{--                    <div class="flex-grow-1 d-flex align-items-center">--}}
{{--                        <div class="dot mr-3 bg-red"></div>--}}
{{--                        <div class="text">--}}
{{--                            <h6 class="mb-0">Total Employee</h6><span class="text-gray">{{$totalEmployee}}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="icon text-white bg-red"><i class="fas fa-users"></i></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section>--}}
{{--        <div class="row mb-4">--}}
{{--            <div class="col-lg-7 mb-4 mb-lg-0">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h2 class="h6 text-uppercase mb-0">User From All Branches</h2>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="chart-holder">--}}
{{--                            <div id="userFomAllBranches" style="width:100%;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-5 mb-4 mb-lg-0">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h2 class="h6 text-uppercase mb-0">Branch Wise Projects</h2>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="chart-holder">--}}
{{--                            <div id="projectBranchwise" style="width:100%;"></div>--}}
{{--                            <div id="projectBranchwise2" style="width:100%; margin-top: 45px;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row mb-4">--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-4 mb-lg-0">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h2 class="h6 text-uppercase mb-0">User Hierarchy</h2>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="chart-holder">--}}
{{--                            <div id="usersHierarchy"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row mb-4">--}}
{{--            <div class="col mb-4 mb-lg-0">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h2 class="h6 text-uppercase mb-0">Users Info</h2>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="chart-holder">--}}
{{--                            <div id="users2"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--<script src="https://code.highcharts.com/highcharts.js"></script>--}}
{{--<script src="https://code.highcharts.com/highcharts-more.js"></script>--}}
{{--<script src="https://code.highcharts.com/highcharts-3d.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/exporting.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/export-data.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/cylinder.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/funnel3d.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/sankey.js"></script>--}}
{{--<script src="https://code.highcharts.com/modules/organization.js"></script>--}}


{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function () {--}}
{{--        var userFomAllBranches = Highcharts.chart('userFomAllBranches', {--}}
{{--            chart: {--}}
{{--                type: 'packedbubble',--}}
{{--                height: '100%'--}}
{{--            },--}}
{{--            title: {--}}
{{--                text: 'Designation Wise User Distribution Chart.'--}}
{{--            },--}}
{{--            tooltip: {--}}
{{--                useHTML: true,--}}
{{--                pointFormat: '<b>{point.name}:</b> {point.value}'--}}
{{--            },--}}
{{--            plotOptions: {--}}
{{--                packedbubble: {--}}
{{--                    minSize: '20%',--}}
{{--                    maxSize: '100%',--}}
{{--                    zMin: 0,--}}
{{--                    zMax: 1000,--}}
{{--                    layoutAlgorithm: {--}}
{{--                        gravitationalConstant: 0.05,--}}
{{--                        splitSeries: true,--}}
{{--                        seriesInteraction: false,--}}
{{--                        dragBetweenSeries: true,--}}
{{--                        parentNodeLimit: true--}}
{{--                    },--}}
{{--                    dataLabels: {--}}
{{--                        enabled: true,--}}
{{--                        format: '{point.name}',--}}
{{--                        filter: {--}}
{{--                            property: 'y',--}}
{{--                            operator: '>',--}}
{{--                            value: 250--}}
{{--                        },--}}
{{--                        style: {--}}
{{--                            color: 'black',--}}
{{--                            textOutline: 'none',--}}
{{--                            fontWeight: 'normal'--}}
{{--                        }--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--            series: [--}}
{{--                    @forEach($branches as $b)--}}
{{--                {--}}
{{--                    name: '{{$b->title}}, total employee: {{$b->count}}',--}}
{{--                    data: [--}}
{{--                            @forEach($b->second as $s)--}}
{{--                            @if(($s['users'] * 1) > 0)--}}
{{--                        {--}}
{{--                            name: '{{$s['designation']}}',--}}
{{--                            value: {{$s['users'] * 1}}--}}
{{--                        },--}}
{{--                        @endif--}}
{{--                        @endforeach--}}
{{--                    ]--}}
{{--                },--}}
{{--                @endforeach--}}
{{--            ]--}}
{{--        });--}}

{{--        var projectBranchwise = Highcharts.chart('projectBranchwise', {--}}
{{--            chart: {--}}
{{--                type: 'pie',--}}
{{--                options3d: {--}}
{{--                    enabled: true,--}}
{{--                    alpha: 45,--}}
{{--                    beta: 0--}}
{{--                }--}}
{{--            },--}}
{{--            title: {--}}
{{--                text: 'Projects distribution branch wise (pie chart).'--}}
{{--            },--}}
{{--            tooltip: {--}}
{{--                pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'--}}
{{--            },--}}
{{--            plotOptions: {--}}
{{--                pie: {--}}
{{--                    allowPointSelect: true,--}}
{{--                    cursor: 'pointer',--}}
{{--                    depth: 35,--}}
{{--                    dataLabels: {--}}
{{--                        enabled: true,--}}
{{--                        format: '{point.name}'--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--            series: [{--}}
{{--                type: 'pie',--}}
{{--                name: 'Project share',--}}
{{--                data: [--}}
{{--                        @foreach($projects as $i => $p)--}}
{{--                    ['{{$p[0]->branch_title}}', {{count($p)}}],--}}
{{--                    @endforeach--}}
{{--                ]--}}
{{--            }]--}}
{{--        });--}}
{{--        var projectBranchwise2 = Highcharts.chart('projectBranchwise2', {--}}
{{--            chart: {--}}
{{--                type: 'funnel3d',--}}
{{--                options3d: {--}}
{{--                    enabled: true,--}}
{{--                    alpha: 10,--}}
{{--                    depth: 50,--}}
{{--                    viewDistance: 50--}}
{{--                }--}}
{{--            },--}}
{{--            title: {--}}
{{--                text: 'Projects distribution branch wise (funnel chart).'--}}
{{--            },--}}
{{--            plotOptions: {--}}
{{--                series: {--}}
{{--                    dataLabels: {--}}
{{--                        enabled: true,--}}
{{--                        format: '<b>{point.name}</b> ({point.y:,.0f})',--}}
{{--                        allowOverlap: true,--}}
{{--                        y: 10--}}
{{--                    },--}}
{{--                    neckWidth: '30%',--}}
{{--                    neckHeight: '25%',--}}
{{--                    width: '80%',--}}
{{--                    height: '80%'--}}
{{--                }--}}
{{--            },--}}
{{--            series: [{--}}
{{--                name: 'Number of projects',--}}
{{--                data: [--}}
{{--                        @foreach($projects as $i => $p)--}}
{{--                    ['{{$p[0]->branch_title}}', {{count($p)}}],--}}
{{--                    @endforeach--}}
{{--                ]--}}
{{--            }]--}}
{{--        });--}}


{{--        var users2 = Highcharts.chart('users2', {--}}
{{--            chart: {--}}
{{--                type: 'column'--}}
{{--            },--}}
{{--            title: {--}}
{{--                text: 'User\'s info by Branch'--}}
{{--            },--}}
{{--            xAxis: {--}}
{{--                categories: [--}}
{{--                    @foreach($branches as $b)--}}
{{--                        '{{$b->title}}',--}}
{{--                    @endforeach--}}
{{--                ]--}}
{{--            },--}}
{{--            yAxis: [{--}}
{{--                min: 0,--}}
{{--                title: {--}}
{{--                    text: 'Amount'--}}
{{--                }--}}
{{--            }, {--}}
{{--                title: {--}}
{{--                    text: 'Number'--}}
{{--                },--}}
{{--                opposite: true--}}
{{--            }],--}}
{{--            legend: {--}}
{{--                shadow: false--}}
{{--            },--}}
{{--            tooltip: {--}}
{{--                shared: true--}}
{{--            },--}}
{{--            plotOptions: {--}}
{{--                column: {--}}
{{--                    grouping: false,--}}
{{--                    shadow: false,--}}
{{--                    borderWidth: 0--}}
{{--                }--}}
{{--            },--}}
{{--            series: [{--}}
{{--                name: 'Loan',--}}
{{--                color: 'rgba(165,170,217,1)',--}}
{{--                data: [--}}
{{--                    @foreach($branches as $b)--}}
{{--                        1 * {{$b->totalLoan}},--}}
{{--                    @endforeach--}}
{{--                ],--}}
{{--                tooltip: {--}}
{{--                    valuePrefix: 'Tk.',--}}
{{--                },--}}
{{--                pointPadding: 0.3,--}}
{{--                pointPlacement: -0.2--}}
{{--            }, {--}}
{{--                name: 'Pension + Provident Fund',--}}
{{--                color: 'rgba(126,86,134,.9)',--}}
{{--                data: [--}}
{{--                    @foreach($branches as $b)--}}
{{--                        1 * {{$b->tppf}},--}}
{{--                    @endforeach--}}
{{--                ],--}}
{{--                tooltip: {--}}
{{--                    valuePrefix: 'Tk.',--}}
{{--                },--}}
{{--                pointPadding: 0.4,--}}
{{--                pointPlacement: -0.2--}}
{{--            }, {--}}
{{--                name: 'Warning',--}}
{{--                color: 'rgba(248,161,63,1)',--}}
{{--                data: [--}}
{{--                    @foreach($branches as $b)--}}
{{--                        1 * {{$b->totalWarning}},--}}
{{--                    @endforeach--}}
{{--                ],--}}
{{--                pointPadding: 0.3,--}}
{{--                pointPlacement: 0.2,--}}
{{--                yAxis: 1--}}
{{--            }, {--}}
{{--                name: 'Leave',--}}
{{--                color: 'rgba(186,60,61,.9)',--}}
{{--                data: [--}}
{{--                    @foreach($branches as $b)--}}
{{--                        1 * {{$b->totalLeave}},--}}
{{--                    @endforeach--}}
{{--                ],--}}
{{--                pointPadding: 0.4,--}}
{{--                pointPlacement: 0.2,--}}
{{--                yAxis: 1--}}
{{--            }]--}}
{{--        });--}}


{{--        var usersHierarchy = Highcharts.chart('usersHierarchy', {--}}
{{--            chart: {--}}
{{--                height: 600,--}}
{{--                inverted: true--}}
{{--            },--}}
{{--            title: {--}}
{{--                text: 'Chain Of Command'--}}
{{--            },--}}
{{--            series: [{--}}
{{--                type: 'organization',--}}
{{--                name: 'European IT',--}}
{{--                keys: ['from', 'to'],--}}
{{--                data: [--}}
{{--                    // Hierarchy data //////////////////////////////////////--}}
{{--                    ['Shareholders', 'Board'],--}}
{{--                    ['Board', 'CEO'],--}}
{{--                    ['CEO', 'CTO'],--}}
{{--                    ['CEO', 'CPO'],--}}
{{--                    ['CEO', 'CSO'],--}}
{{--                    ['CEO', 'CMO'],--}}
{{--                    ['CEO', 'HR'],--}}
{{--                    ['CTO', 'Product'],--}}
{{--                    ['CTO', 'Web'],--}}
{{--                    ['CSO', 'Sales'],--}}
{{--                    ['CMO', 'Market']--}}
{{--                ],--}}
{{--                levels: [{--}}
{{--                    level: 0,--}}
{{--                    color: 'silver',--}}
{{--                    dataLabels: {--}}
{{--                        color: 'black'--}}
{{--                    },--}}
{{--                    height: 25--}}
{{--                }, {--}}
{{--                    level: 1,--}}
{{--                    color: 'silver',--}}
{{--                    dataLabels: {--}}
{{--                        color: 'black'--}}
{{--                    },--}}
{{--                    height: 25--}}
{{--                }, {--}}
{{--                    level: 2,--}}
{{--                    color: '#980104'--}}
{{--                }, {--}}
{{--                    level: 4,--}}
{{--                    color: '#359154'--}}
{{--                }],--}}
{{--                nodes: [{--}}
{{--                    id: 'Shareholders'--}}
{{--                }, {--}}
{{--                    id: 'Board'--}}
{{--                }, {--}}
{{--                    id: 'CEO',--}}
{{--                    title: 'CEO',--}}
{{--                    name: 'Grethe Hjetland',--}}
{{--                    image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132317/Grethe.jpg'--}}
{{--                }, {--}}
{{--                    id: 'HR',--}}
{{--                    title: 'HR/CFO',--}}
{{--                    name: 'Anne Jorunn Fjærestad',--}}
{{--                    color: '#007ad0',--}}
{{--                    image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132314/AnneJorunn.jpg',--}}
{{--                    column: 3,--}}
{{--                    offset: '75%'--}}
{{--                }, {--}}
{{--                    id: 'CTO',--}}
{{--                    title: 'CTO',--}}
{{--                    name: 'Christer Vasseng',--}}
{{--                    column: 4,--}}
{{--                    image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12140620/Christer.jpg',--}}
{{--                    layout: 'hanging'--}}
{{--                }, {--}}
{{--                    id: 'CPO',--}}
{{--                    title: 'CPO',--}}
{{--                    name: 'Torstein Hønsi',--}}
{{--                    column: 4,--}}
{{--                    image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12131849/Torstein1.jpg'--}}
{{--                }, {--}}
{{--                    id: 'CSO',--}}
{{--                    title: 'CSO',--}}
{{--                    name: 'Anita Nesse',--}}
{{--                    column: 4,--}}
{{--                    image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132313/Anita.jpg',--}}
{{--                    layout: 'hanging'--}}
{{--                }, {--}}
{{--                    id: 'CMO',--}}
{{--                    title: 'CMO',--}}
{{--                    name: 'Vidar Brekke',--}}
{{--                    column: 4,--}}
{{--                    image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/13105551/Vidar.jpg',--}}
{{--                    layout: 'hanging'--}}
{{--                }, {--}}
{{--                    id: 'Product',--}}
{{--                    name: 'Product developers'--}}
{{--                }, {--}}
{{--                    id: 'Web',--}}
{{--                    name: 'General tech',--}}
{{--                    description: 'Web developers, sys admin'--}}
{{--                }, {--}}
{{--                    id: 'Sales',--}}
{{--                    name: 'Sales team'--}}
{{--                }, {--}}
{{--                    id: 'Market',--}}
{{--                    name: 'Marketing team'--}}
{{--                }],--}}
{{--                colorByPoint: false,--}}
{{--                color: '#007ad0',--}}
{{--                dataLabels: {--}}
{{--                    color: 'white'--}}
{{--                },--}}
{{--                borderColor: 'white',--}}
{{--                nodeWidth: 65--}}
{{--            }],--}}
{{--            tooltip: {--}}
{{--                outside: true--}}
{{--            },--}}
{{--            exporting: {--}}
{{--                allowHTML: true,--}}
{{--                sourceWidth: 800,--}}
{{--                sourceHeight: 600--}}
{{--            }--}}

{{--        });--}}

{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}