@extends('layouts.joli')
@section('title', 'Tax Edit')
@section('link')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
@endsection
@section('style')
    <style>
        .tax-form-body {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .tax-form-body .form-group {
            width: 100% !important;
        }

        .tax-form-body .form-group .input-group-addon span,
        .tax-form-body .form-group .input-group-addon i {
            margin-bottom: 7px;
        }

        #pension .toggle {
            width: 124px !important;
        }

        #pension .off {
            border-color: #6c757d !important;
        }

        #pension .toggle .toggle-group label {
            line-height: 16px !important;
        }
    </style>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[6]->display_name}}</li>
        <li><a href="{{route('tax.setup')}}">{{$menu[10]->display_name}}</a></li>
        <li>Edit</li>
    </ul>
@endsection
@section('pageTitle', 'Tax Edit')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('TaxCreateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('TaxCreateSuccess')}}
                </div>
            @elseif(session('TaxCreateUnsuccess'))
                <div class="alert alert-danger text-center">
                    {{session('TaxCreateUnsuccess')}}
                </div>
            @elseif(session('TaxDefaultUpdate'))
                <div class="alert alert-success text-center">
                    {{session('TaxDefaultUpdate')}}
                </div>
            @elseif(session('TaxDeleteSuccess'))
                <div class="alert alert-info text-center">
                    {{session('TaxDeleteSuccess')}}
                </div>
            @endif
            <div class="col-md-12">
                <!-- START VERTICAL TABS WITH HEADING -->
                <div class="panel panel-default nav-tabs-vertical">
                    <div class="panel-heading">
                        <h3 class="panel-title">TAX SETUP</h3>
                    </div>
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab19" data-toggle="tab">Edit Slab</a></li>
                        </ul>
                        <div class="panel-body tab-content">
                            <div class="tab-pane active" id="tab19">
                                {{--     Create New Form will Go here                       --}}
                                <form action="{{route('tax.update', ['tid' => $tedit->id])}}" class="form-horizontal"
                                      method="post">
                                    @csrf
                                    <div class="panel-body tax-form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                            <div class="col-md-6 col-xs-12">
                                                <select class="form-control" name="branch" required>
                                                    <option selected hidden
                                                            value="{{$tedit->branch_id}}">{{$tedit->title}}</option>
                                                    @foreach($branches as $b)
                                                        <option value="{{$b->id}}" {{(old('branch')== $b->id)?'selected':'' }}>{{$b->title}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('branch'))
                                                    <span class="help-block text-danger">{{$errors->first('branch')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">From</label>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="glyphicon glyphicon-usd"></i></span>
                                                    <input type="number" min="1" name="from" required
                                                           value="{{$tedit->from}}"
                                                           class="form-control {{$errors->has('from') ? 'is-invalid' : ''}}">
                                                </div>
                                                @if($errors->has('from'))
                                                    <span class="help-block text-danger">{{$errors->first('from')}}</span>
                                                @endif
                                                <small class="help-block">Salary Per Year.</small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">To</label>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="glyphicon glyphicon-usd"></i></span>
                                                    <input type="number" min="1" name="to" required
                                                           value="{{$tedit->to}}"
                                                           class="form-control {{$errors->has('to') ? 'is-invalid' : ''}}">
                                                </div>
                                                @if($errors->has('to'))
                                                    <span class="help-block text-danger">The to must be greater than from.</span>
                                                @endif
                                                <small class="help-block">Salary Per Year.</small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Tax Percentage</label>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="glyphicon glyphicon-usd"></i></span>
                                                    <input type="number" min="0" max="100" name="tax" required
                                                           value="{{$tedit->tax}}" step="0.01"
                                                           class="form-control {{$errors->has('tax') ? 'is-invalid' : ''}}">
                                                </div>
                                                @if($errors->has('tax'))
                                                    <span class="help-block text-danger">{{$errors->first('tax')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a title="refresh" class="btn btn-default back"
                                           data-link="{{route('back')}}"><span
                                                    class="fa fa-refresh"></span></a>
                                        <button class="btn btn-primary pull-right">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END VERTICAL TABS WITH HEADING -->
            </div>
        </div>
    </section>
    <section class="mb-5">
        <div class="col-md-12">
            <!-- START TABS -->
            <div class="panel panel-default tabs">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($branches as $i => $b)
                        <li class="{{ ($b->title == $tedit->title) ? "active" : "" }}">
                            <a href="#{{$b->title}}" role="tab" data-toggle="tab">{{$b->title}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="panel-body tab-content">
                    @foreach($branches as $i => $b)
                        <div class="tab-pane {{ ($b->title == $tedit->title) ? "active" : "" }}" id="{{$b->title}}">
                            {{--      Table will go here                 --}}
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Tax</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($taxes as $t)
                                    @if($t->title == $b->title)
                                        <tr>
                                            <td>{{$t->title}}</td>
                                            <td>{{$t->from}} Tk.</td>
                                            <td>{{$t->to}} Tk.</td>
                                            <td>{{$t->tax}} %</td>
                                            <td>
                                                @if($tedit->id != $t->id)
                                                    <a href="{{route('tax.edit', ['tid' => $t->id])}}"
                                                       class="btn btn-sm btn-success"><span class="fa fa-pencil"></span></a>
                                                    <a href="{{route('tax.delete', ['tid' => $t->id])}}"
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Are You Sure ?')"><i
                                                                class="fa fa-trash-o"></i></a>
                                                @else
                                                    <a href="{{route('tax.edit', ['tid' => $t->id])}}"
                                                       class="btn btn-sm btn-success disabled"><span
                                                                class="fa fa-pencil"></span></a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger disabled"><i
                                                                class="fa fa-trash-o"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- END TABS -->
        </div>
    </section>
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    {{--    <script type='text/javascript' src='{{asset('joli/js/plugins/icheck/icheck.min.js')}}'></script>--}}
    <!-- END THIS PAGE PLUGINS-->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
    <script>
        $(document).ready(function () {
            var is_gross = "{{$isGross}}";
            var salary = (is_gross == "1") ? 'total' : 'gross';
            $("#is_pension").next().on("click", (e) => {
                if (confirm("Are you sure you want to change this to " + salary + " salary?")) {
                    $('#pension').submit();
                } else {
                    e.stopPropagation();
                }
            });
        });
    </script>
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css"--}}
{{--      rel="stylesheet">--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('TaxUpdateSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('TaxUpdateSuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('TaxUpdateUnsuccess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('TaxUpdateUnsuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-12 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Tax Edit</h3>--}}
{{--                        <form action="{{route('tax.isGross')}}" class="form-horizontal" method="post"--}}
{{--                              style="float: right;" id="pension">--}}
{{--                            @csrf--}}
{{--                            <label class="form-control-label mr-2">Only Gross Salary</label>--}}
{{--                            <input id="is_pension" type="checkbox"--}}
{{--                                   {{ (($isGross * 1) == 1 ) ? "checked" : "" }}--}}
{{--                                   data-toggle="toggle" data-on="Yes" data-off="No" value="1"--}}
{{--                                   data-onstyle="success" data-offstyle="outline-secondary" name="tax_is_gross">--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('tax.update', ['tid' => $tedit->id])}}" method="post">--}}
{{--                            @csrf--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-lg-1"></div>--}}
{{--                                <div class="col-lg-2">--}}
{{--                                    <label class="form-control-label">Branch</label>--}}
{{--                                    <select class="form-control" name="branch" required>--}}
{{--                                        <option selected hidden value="{{$tedit->branch_id}}">{{$tedit->title}}</option>--}}
{{--                                        @foreach($branches as $b)--}}
{{--                                            <option value="{{$b->id}}">{{$b->title}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    @if($errors->has('branch'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('branch')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2">--}}
{{--                                    <label class="form-control-label">From</label>--}}
{{--                                    <input type="number" value="{{$tedit->from}}" name="from" min="1"--}}
{{--                                           class="form-control form-control-success {{$errors->has('from') ? 'is-invalid' : ''}}"--}}
{{--                                           required>--}}
{{--                                    @if($errors->has('from'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('from')}}</span>--}}
{{--                                    @endif--}}
{{--                                    <small class="form-text text-muted ml-3">Salary Per Year.</small>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2">--}}
{{--                                    <label class="form-control-label">To</label>--}}
{{--                                    <input type="number" value="{{$tedit->to}}" name="to" min="1"--}}
{{--                                           class="form-control form-control-success {{$errors->has('to') ? 'is-invalid' : ''}}"--}}
{{--                                           required>--}}
{{--                                    @if($errors->has('to'))--}}
{{--                                        <span class="help-block text-danger">The to must be greater than from.</span>--}}
{{--                                    @endif--}}
{{--                                    <small class="form-text text-muted ml-3">Salary Per Year.</small>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2">--}}
{{--                                    <label class="form-control-label">Tax Percentage</label>--}}
{{--                                    <input type="number" value="{{$tedit->tax}}" name="tax" min="0.01" max="100"--}}
{{--                                           step="0.01"--}}
{{--                                           class="form-control form-control-success {{$errors->has('tax') ? 'is-invalid' : ''}}"--}}
{{--                                           required>--}}
{{--                                    @if($errors->has('tax'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('tax')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2">--}}
{{--                                    <button type="submit" class="btn btn-primary" style="margin-top: 29px;">Update</button>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-1"></div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-12 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Taxes</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th scope="col">#</th>--}}
{{--                                <th scope="col">Branch</th>--}}
{{--                                <th scope="col">From</th>--}}
{{--                                <th scope="col">To</th>--}}
{{--                                <th scope="col">Tax</th>--}}
{{--                                <th scope="col">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($taxes as $i => $b)--}}
{{--                                <tr>--}}
{{--                                    <th>{{$i + 1}}</th>--}}
{{--                                    <td>{{$b->title}}</td>--}}
{{--                                    <td>{{$b->from}} Tk.</td>--}}
{{--                                    <td>{{$b->to}} Tk.</td>--}}
{{--                                    <td>{{$b->tax}} %</td>--}}
{{--                                    <td>--}}
{{--                                        @if(($b->id * 1) != ($tedit->id * 1))--}}
{{--                                            <a href="{{route('tax.edit', ['tid' => $b->id])}}"--}}
{{--                                               class="btn btn-sm btn-success">Edit</a>--}}
{{--                                            <a href="{{route('tax.delete', ['tid' => $b->id])}}"--}}
{{--                                               class="btn btn-sm btn-danger"--}}
{{--                                               onclick="return confirm('Are You Sure ?')">X</a>--}}
{{--                                        @else--}}
{{--                                            <a href="{{route('tax.edit', ['tid' => $b->id])}}"--}}
{{--                                               class="btn btn-sm btn-success disabled">Edit</a>--}}
{{--                                            <a href="#" class="btn btn-sm btn-danger disabled">X</a>--}}
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
{{--<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>--}}
{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $("#is_pension").next().on("click", (e) => {--}}
{{--            if(confirm('Are you sure ?')) {--}}
{{--                $('#pension').submit();--}}
{{--            } else {--}}
{{--                e.stopPropagation();--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}