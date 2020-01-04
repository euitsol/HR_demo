@extends('layouts.joli')
@section('title', 'Applicant List')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li><a href="{{route('circular')}}">{{$menu[16]->display_name}}</a></li>
        <li><a href="{{route('back')}}">Applicant List</a></li>
        <li class="active">{{$jobtitle}}</li>
    </ul>
@endsection
@section('pageTitle', 'Applicant List')
@section('content')
    <section >
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{$jobtitle}}</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applicants as $i => $a)
                                <tr>
                                    <th scope="row">{{$i + 1}}</th>
                                    <td>{{$a->name}}</td>
                                    <td>{{$a->email}}</td>
                                    <td>
                                        <a href="{{route('applicant.view', ['aid' => $a->id])}}"
                                           class="btn btn-sm btn-primary" target="_blank">View</a>
                                        @if(($a->is_shortlisted * 1) == 0)
                                            {{--Not Selected--}}
                                            <a href="{{route('select.applicant', ['aid' => $a->id])}}"
                                               class="btn btn-sm btn-success">Shortlisted</a>
                                            <a href="#" class="btn btn-sm btn-danger disabled">Unselect</a>
                                        @else
                                            {{--Selected--}}
                                            <a href="#" class="btn btn-sm btn-success disabled">Shortlisted</a>
                                            <a href="{{route('unselect.applicant', ['aid' => $a->id])}}"
                                               class="btn btn-sm btn-danger">Unselect</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Only Shortlisted Applicants</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applicants as $i => $a)
                                @if(($a->is_shortlisted * 1) == 1)
                                    <tr>
                                        <th scope="row">{{$i + 1}}</th>
                                        <td>{{$a->name}}</td>
                                        <td>{{$a->email}}</td>
                                        <td>
                                            <a href="{{route('applicant.employee', ['aid' => $a->id, 'nid' => $nid])}}" class="btn btn-sm btn-success"
                                               onclick="return confirm('Are you Sure ?')">Select</a>
                                            <a href="{{route('unselect.applicant', ['aid' => $a->id])}}"
                                               class="btn btn-sm btn-danger" onclick="return confirm('Are you Sure ?')">Unselect</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    {{--    <script type='text/javascript' src='{{asset('joli/js/plugins/icheck/icheck.min.js')}}'></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/demo_tables.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>--}}
    {{--        <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>--}}
    <!-- END THIS PAGE PLUGINS-->
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-6 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">{{$jobtitle}}</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Name</th>--}}
{{--                                <th>Email</th>--}}
{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($applicants as $i => $a)--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">{{$i + 1}}</th>--}}
{{--                                    <td>{{$a->name}}</td>--}}
{{--                                    <td>{{$a->email}}</td>--}}
{{--                                    <td class="text-right">--}}
{{--                                        <a href="{{route('applicant.view', ['aid' => $a->id])}}"--}}
{{--                                           class="btn btn-sm btn-outline-info" target="_blank">View</a>--}}
{{--                                        @if(($a->is_shortlisted * 1) == 0)--}}
{{--                                            Not Selected--}}
{{--                                            <a href="{{route('select.applicant', ['aid' => $a->id])}}"--}}
{{--                                               class="btn btn-sm btn-success">Shortlisted</a>--}}
{{--                                            <a href="#" class="btn btn-sm btn-danger disabled">Unselect</a>--}}
{{--                                        @else--}}
{{--                                            Selected--}}
{{--                                            <a href="#" class="btn btn-sm btn-success disabled">Shortlisted</a>--}}
{{--                                            <a href="{{route('unselect.applicant', ['aid' => $a->id])}}"--}}
{{--                                               class="btn btn-sm btn-danger">Unselect</a>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">{{$jobtitle}}</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Name</th>--}}
{{--                                <th>Email</th>--}}
{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($applicants as $i => $a)--}}
{{--                                @if(($a->is_shortlisted * 1) == 1)--}}
{{--                                    <tr>--}}
{{--                                        <th scope="row">{{$i + 1}}</th>--}}
{{--                                        <td>{{$a->name}}</td>--}}
{{--                                        <td>{{$a->email}}</td>--}}
{{--                                        <td class="text-right">--}}
{{--                                            <a href="{{route('applicant.employee', ['aid' => $a->id, 'nid' => $nid])}}" class="btn btn-sm btn-success"--}}
{{--                                               onclick="return confirm('Are you Sure ?')">Select</a>--}}
{{--                                            <a href="{{route('unselect.applicant', ['aid' => $a->id])}}"--}}
{{--                                               class="btn btn-sm btn-danger" onclick="return confirm('Are you Sure ?')">Unselect</a>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}