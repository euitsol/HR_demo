@extends('layouts.joli')
@section('title', 'Designation')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[6]->display_name}}</li>
        <li class="active">{{$menu[11]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Designation')
@section('content')
    <div class="row mb-5">
        @if(session('JobCreateSuccess'))
            <div class="alert alert-success text-center">
                {{session('JobCreateSuccess')}}
            </div>
        @elseif(session('JobUpdateSuccess'))
            <div class="alert alert-success text-center">
                {{session('JobUpdateSuccess')}}
            </div>
        @elseif(session('JobDeleteSuccess'))
            <div class="alert alert-success text-center">
                {{session('JobDeleteSuccess')}}
            </div>
        @elseif(session('JobDeleteUnSuccess'))
            <div class="alert alert-danger text-center">
                {{session('JobDeleteUnSuccess')}}
            </div>
        @endif
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">DESIGNATION CREATE</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('job.store')}}" class="form-horizontal" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" placeholder="Job Title" name="title" required
                                           class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('title'))
                                    <span class="help-block text-danger">{{$errors->first('title')}}</span>
                                @endif
                                <small class="help-block">Duplicate entry is not allowed*</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Max Loan</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" placeholder="Max Loan in percentage" name="maxLoan" required
                                           min="0" max="100"
                                           class="form-control {{$errors->has('maxLoan') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">%</span>
                                </div>
                                @if($errors->has('maxLoan'))
                                    <span class="help-block text-danger">{{$errors->first('maxLoan')}}</span>
                                @endif
                                <small class="help-block">max is 100%</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Provident Fund</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" placeholder="Provident Fund Cut Off percentage"
                                           name="provident" required
                                           min="0" max="100"
                                           class="form-control {{$errors->has('provident') ? 'is-invalid' : ''}}">
                                    <span class="input-group-addon add-on">%</span>
                                </div>
                                @if($errors->has('provident'))
                                    <span class="help-block text-danger">{{$errors->first('provident')}}</span>
                                @endif
                                <small class="help-block">max is 100%</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Supervisor</label>
                            <div class="col-md-6 col-xs-12">
                                <select class="form-control" name="supervisor" required>
                                    <option selected disabled hidden value="">Choose...</option>
                                    @foreach($jobs as $j)
                                        <option value="{{$j->id}}" {{(old('supervisor')== $j->id)?'selected':'' }}>{{$j->title}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('supervisor'))
                                    <span class="help-block text-danger">{{$errors->first('supervisor')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Pay Scale</label>
                            <div class="col-md-6 col-xs-12">
                                <select class="form-control" name="payScale" required>
                                    <option selected disabled hidden value="">Choose...</option>
                                    @foreach($ps as $p)
                                        <option value="{{$p->id}}" {{(old('payScale')== $p->id)?'selected':'' }}>{{$p->title}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('payScale'))
                                    <span class="help-block text-danger">{{$errors->first('payScale')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                    class="fa fa-refresh"></span></a>
                        <button class="btn btn-primary pull-right">Create</button>
                    </div>
                </form>
                {{--     Form end               --}}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ALL job</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Supervisor</th>
                            <th>Max Loan</th>
                            <th>Provident</th>
                            <th class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($jobs as $i => $j)
                            <tr>
                                <th scope="row">{{$i +1}}</th>
                                <td>{{$j->title}}</td>
                                <td>{{$j->supervisor}}</td>
                                <td>{{$j->maxLoanInPercentage}} %</td>
                                <td>{{$j->provident}} %</td>
                                <td class="text-right">
                                    <a href="{{route('job.edit', ['jid' => $j->id])}}"
                                       class="btn btn-sm btn-success m-1"><i class="fa fa-pencil"></i></a>
                                    @if(($j->is_supervisor * 1) == 0)
                                        <a href="{{route('job.delete', ['jid' => $j->id])}}"
                                           class="btn btn-sm btn-danger m-1"
                                           onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i></a>
                                    @else
                                        <a href="#" class="btn btn-sm btn-danger disabled m-1"
                                           onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
{{--        @if(session('JobCreateSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('JobCreateSuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('JobUpdateSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('JobUpdateSuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('JobDeleteSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('JobDeleteSuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('JobDeleteUnSuccess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('JobDeleteUnSuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('JobDeleteUnSuccessS'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('JobDeleteUnSuccessS')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-5 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Job Create</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('job.store')}}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-2 form-control-label">Title</label>--}}
{{--                                <div class="col-md-10">--}}
{{--                                    @if($errors->has('title'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('title')}}</span>--}}
{{--                                    @endif--}}
{{--                                    <input type="text" placeholder="Job Title" name="title"--}}
{{--                                           class="form-control form-control-success {{$errors->has('title') ? 'is-invalid' : ''}}"--}}
{{--                                           required>--}}
{{--                                    <small class="form-text text-muted ml-3">Duplicate entry is not allowed*</small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-2 form-control-label">Max Loan</label>--}}
{{--                                <div class="col-md-10">--}}
{{--                                    @if($errors->has('maxLoan'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('maxLoan')}}</span>--}}
{{--                                    @endif--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <input type="number" placeholder="Max Loan in percentage" name="maxLoan" min="0"--}}
{{--                                               max="100"--}}
{{--                                               class="form-control form-control-success {{$errors->has('maxLoan') ? 'is-invalid' : ''}}"--}}
{{--                                               required>--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <small class="form-text text-muted ml-3" style="margin-top: -10px;">max is 100%*--}}
{{--                                    </small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-2 form-control-label">Provident</label>--}}
{{--                                <div class="col-md-10">--}}
{{--                                    @if($errors->has('provident'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('provident')}}</span>--}}
{{--                                    @endif--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <input type="number" placeholder="Provident Fund Cut Off percentage"--}}
{{--                                               name="provident" min="0" max="100"--}}
{{--                                               class="form-control form-control-success {{$errors->has('provident') ? 'is-invalid' : ''}}"--}}
{{--                                               required>--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <small class="form-text text-muted ml-3" style="margin-top: -10px;">--}}
{{--                                        max is 100%*--}}
{{--                                    </small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="form-control-label col-md-3">Supervisor</label>--}}
{{--                                <div class=" col-md-9">--}}
{{--                                    <select class="form-control" name="supervisor" required>--}}
{{--                                        @if($errors->has('supervisor'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('supervisor')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <option selected disabled hidden value="">Choose...</option>--}}
{{--                                        @foreach($jobs as $j)--}}
{{--                                            <option value="{{$j->id}}">{{$j->title}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="form-control-label col-md-3">Pay Scale</label>--}}
{{--                                <div class=" col-md-9">--}}
{{--                                    <select class="form-control" name="payScale" required>--}}
{{--                                        @if($errors->has('payScale'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('payScale')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <option selected disabled hidden value="">Choose...</option>--}}
{{--                                        @foreach($ps as $p)--}}
{{--                                            <option value="{{$p->id}}">{{$p->title}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Create</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-7 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h6 class="text-uppercase mb-0">All Job Title</h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Job Title</th>--}}
{{--                                <th>Supervisor</th>--}}
{{--                                <th>Max Loan</th>--}}
{{--                                <th>Provident</th>--}}
{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($jobs as $i => $j)--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">{{$i +1}}</th>--}}
{{--                                    <td>{{$j->title}}</td>--}}
{{--                                    <td>{{$j->supervisor}}</td>--}}
{{--                                    <td>{{$j->maxLoanInPercentage}} %</td>--}}
{{--                                    <td>{{$j->provident}} %</td>--}}
{{--                                    <td class="text-right">--}}
{{--                                        <a href="{{route('job.edit', ['jid' => $j->id])}}"--}}
{{--                                           class="btn btn-sm btn-success">Edit</a>--}}
{{--                                        @if(($j->is_supervisor * 1) == 0)--}}
{{--                                            <a href="{{route('job.delete', ['jid' => $j->id])}}"--}}
{{--                                               class="btn btn-sm btn-danger"--}}
{{--                                               onclick="return confirm('Are you sure ?')">X</a>--}}
{{--                                        @else--}}
{{--                                            <a href="#" class="btn btn-sm btn-outline-danger disabled"--}}
{{--                                               onclick="return confirm('Are you sure ?')">X</a>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
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