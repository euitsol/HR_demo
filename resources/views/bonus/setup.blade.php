@extends('layouts.joli')
@section('title', 'Bonus Setup')
@section('style')
    <style>
        @media (min-width: 767px) {
            .gt {
                margin-left: -3vw !important;
            }
        }
    </style>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[33]->display_name}}</li>
        <li class="active">{{$menu[35]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Bonus Setup')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('BonusUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('BonusUpdateSuccess')}}
                </div>
            @elseif(session('BonusResetSuccess'))
                <div class="alert alert-info text-center">
                    {{session('BonusResetSuccess')}}
                </div>
            @elseif(session('unsuccess'))
                <div class="alert alert-danger text-center">
                    {{session('unsuccess')}}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Bonus Setup</h3>
                    </div>
                    {{--     Form Start              --}}
                    <form action="{{route('bonus.update')}}" class="form-horizontal" method="post">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Salary Percentage</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="number" placeholder="Salary Percentage" name="salaryPercentage"
                                               required
                                               min="1" max="100"
                                               class="form-control {{$errors->has('salaryPercentage') ? 'is-invalid' : ''}}">
                                        <span class="input-group-addon add-on">%</span>
                                    </div>
                                    @if($errors->has('salaryPercentage'))
                                        <span class="help-block text-danger">{{$errors->first('salaryPercentage')}}</span>
                                    @endif
                                    <small class="help-block">max is 100%</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Only Gross Salary</label>
                                <div class="col-md-1 col-xs-12" style="margin-top: 7px;">
                                    <input type="checkbox" name="isGross" style="transform: scale(1.5);"
                                            {{ (($bonus->is_gross * 1) == 1 ) ? "checked" : "" }}>
                                </div>
                                <div class="col-md-8">
                                    <small class="help-block gt">Gross salary unchecked represents to total salary.</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">User With Religion</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="religion" required>
                                        <option selected disabled hidden value="">Choose...</option>
                                        <option value="all">All</option>
                                        @foreach($religions as $r)
                                            <option value="{{$r->id}}" {{(old('religion')== $r->id)?'selected':'' }}>{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('religion'))
                                        <span class="help-block text-danger">{{$errors->first('religion')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                        class="fa fa-refresh"></span></a>
                            <button class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </form>
                    {{--     Form end               --}}
                </div>
            </div>
        </div>
    </section>
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Employees selected to get
                            @if(count($users) > 0)
                                {{ ($bonus) ? "$bonus->percentage%  " : "" }}
                            @endif
                            bonus this month</h3>
                        @if(count($users) > 0)
                            <a href="{{route('bonus.reset')}}" class="btn btn-sm btn-danger float-right"
                               onclick="return confirm('Are you sure you want to reset all employees ?')">
                                Reset
                            </a>
                        @endif
                    </div>
                    <div class="panel-body">
                        @if(count($users) > 0)



                            @foreach($users as $u)
                                <p>{{$u->name}}</p>
                            @endforeach



                        @else
                            No Employee will get bonus this month.
                        @endif
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
    {{--    <script type='text/javascript' src='{{asset('joli/js/plugins/icheck/icheck.min.js')}}'></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>--}}
    <!-- END THIS PAGE PLUGINS-->
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        --}}{{--        @if(session('BonusUpdateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('BonusUpdateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('BonusResetSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-info text-center">--}}
{{--        --}}{{--                {{session('BonusResetSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('unsuccess'))--}}
{{--        --}}{{--            <div class="alert alert-danger text-center">--}}
{{--        --}}{{--                {{session('unsuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Bonus Setup</h3>--}}
{{--                        --}}{{--                        <p class="text-secondary">Please Update Before Generating Salary !</p>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('bonus.update')}}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Salary Percentage</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    @if($errors->has('salaryPercentage'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('salaryPercentage')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                    <div class="input-group mb-3">--}}
{{--                            --}}{{--                                        <input type="number" value="{{$bonus->percentage}}" name="salaryPercentage"--}}
{{--                            --}}{{--                                               min="1" max="100" required--}}
{{--                            --}}{{--                                               class="form-control form-control-success {{$errors->has('salaryPercentage') ? 'is-invalid' : ''}}">--}}
{{--                            --}}{{--                                        <div class="input-group-append">--}}
{{--                            --}}{{--                                            <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                            --}}{{--                                        </div>--}}
{{--                            --}}{{--                                    </div>--}}
{{--                            --}}{{--                                    <small class="form-text text-muted ml-3" style="margin-top: -10px;">max is 100%*--}}
{{--                            --}}{{--                                    </small>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Only Gross Salary</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <input type="checkbox" name="isGross" style="transform: scale(2);"--}}
{{--                            --}}{{--                                            {{ (($bonus->is_gross * 1) == 1 ) ? "checked" : "" }}>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">User With Religion</label>--}}
{{--                            --}}{{--                                <div class=" col-md-9">--}}
{{--                            --}}{{--                                    <select class="form-control" name="religion" required>--}}
{{--                            --}}{{--                                        @if($errors->has('religion'))--}}
{{--                            --}}{{--                                            <span class="help-block text-danger">{{$errors->first('religion')}}</span>--}}
{{--                            --}}{{--                                        @endif--}}
{{--                            --}}{{--                                        <option selected disabled hidden value="">Choose...</option>--}}
{{--                            --}}{{--                                        <option value="all">All</option>--}}
{{--                            --}}{{--                                        @foreach($religions as $r)--}}
{{--                            --}}{{--                                            <option value="{{$r->id}}">{{$r->name}}</option>--}}
{{--                            --}}{{--                                        @endforeach--}}
{{--                            --}}{{--                                    </select>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <div class="col-md-9 ml-auto">--}}
{{--                            --}}{{--                                    <button type="submit" class="btn btn-primary">Update</button>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Employees selected to get bonus this month</h3>--}}
{{--                        @if(count($users) > 0)--}}
{{--                            <a href="{{route('bonus.reset')}}" class="btn btn-sm btn-danger float-right"--}}
{{--                               onclick="return confirm('Are you sure you want to reset all employees ?')"><i--}}
{{--                                        class="fas fa-undo"></i></a>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        @if(count($users) > 0)--}}
{{--                            @foreach($users as $u)--}}
{{--                                <p>{{$u->name}}</p>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            No Employee will get bonus this month.--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}