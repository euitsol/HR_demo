@extends('layouts.joli')
@section('title', 'Pension')
@section('link')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
@endsection
@section('style')
    <style>
        #pension .toggle {
            width: 124px !important;
        }

        #pension .off {
            border-color: #6c757d !important;
        }

        .myClass .toggle {
            width: 124px !important;
        }

        .myClass .off {
            border-color: #6c757d !important;
        }

        .panel .panel-title {
            float: none;
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
        <li class="active">{{$menu[37]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Pension')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('PensionActiveSuccess'))
                <div class="alert alert-success text-center">
                    {{session('PensionActiveSuccess')}}
                </div>
            @elseif(session('PensionDEActiveSuccess'))
                <div class="alert alert-success text-center">
                    {{session('PensionDEActiveSuccess')}}
                </div>
            @elseif(session('PensionBothSuccess'))
                <div class="alert alert-success text-center">
                    {{session('PensionBothSuccess')}}
                </div>
            @elseif(session('PensionDEBothSuccess'))
                <div class="alert alert-info text-center">
                    {{session('PensionDEBothSuccess')}}
                </div>
            @elseif(session('PensionUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('PensionUpdateSuccess')}}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Pension
                            <form action="{{route('pension.isActive.change')}}" class="form-horizontal" method="post"
                                  style="float: right;" id="pension">
                                @csrf
                                <input id="is_pension" type="checkbox"
                                       {{ (($p->is_active * 1) == 1 ) ? "checked" : "" }} data-toggle="toggle"
                                       data-onstyle="success" data-offstyle="outline-secondary" name="pension_active"
                                       value="1" style="float: right;">
                            </form>
                        </h3>
                    </div>
                    @if(($p->is_active * 1) == 1 )
                        {{--     Form Start              --}}
                        <form action="{{route('pension.update')}}" class="form-horizontal" method="post">
                            @csrf
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Total Pay</label>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="number" value="{{$p->total_pay_months}}" name="totalPay"
                                                   required
                                                   class="form-control {{$errors->has('totalPay') ? 'is-invalid' : ''}}">
                                            <span class="input-group-addon add-on">
                                                Months of
                                                <span>&nbsp;<b id="Gross">
                                                        {{ (($p->is_gross_salary * 1) == 1 ) ? "Gross" : "Total" }}
                                                    </b>
                                                    &nbsp;</span>
                                                Salary
                                            </span>
                                        </div>
                                        @if($errors->has('totalPay'))
                                            <span class="help-block text-danger">{{$errors->first('totalPay')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Salary Percentage</label>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="number" value="{{$p->salary_percentage}}"
                                                   name="salaryPercentage"
                                                   required min="0" max="100" step="0.01"
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
                                    {{--                                    <label class="col-md-3 col-xs-12 control-label">Only Gross Salary</label>--}}
                                    <label class="col-md-3 col-xs-12 control-label">Salary Type</label>
                                    <div class="col-md-6 col-xs-12 myClass">
                                        {{--                                        <input id="is_gross" type="checkbox" data-on="Gross Salary"--}}
                                        {{--                                               data-off="Total Salary"--}}
                                        {{--                                               {{ (($p->is_gross_salary * 1) == 1 ) ? "checked" : "" }} data-toggle="toggle"--}}
                                        {{--                                               data-onstyle="success" data-offstyle="outline-secondary"--}}
                                        {{--                                               name="is_gross" value="1">--}}
                                        <select id="is_gross"  class="form-control">
                                            <option value="gross" {{ (($p->is_gross_salary * 1) == 1 ) ? "selected" : "" }}>Gross</option>
                                            <option value="total" {{ (($p->is_gross_salary * 1) == 1 ) ? "" : "selected" }}>Total</option>
                                        </select>


                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Max Initial Withdrawal</label>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="number" value="{{$p->max_withdraw_percentage}}"
                                                   name="maxWithdrawal"
                                                   required min="0" max="100" step="0.01"
                                                   class="form-control {{$errors->has('maxWithdrawal') ? 'is-invalid' : ''}}">
                                            <span class="input-group-addon add-on">%</span>
                                        </div>
                                        @if($errors->has('maxWithdrawal'))
                                            <span class="help-block text-danger">{{$errors->first('maxWithdrawal')}}</span>
                                        @endif
                                        <small class="help-block">max is 100%</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Per Month Withdrawal</label>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="number" value="{{$p->per_month_withdraw_percentage}}"
                                                   name="perMonthWithdrawal"
                                                   required min="0" max="100" step="0.01"
                                                   class="form-control {{$errors->has('perMonthWithdrawal') ? 'is-invalid' : ''}}">
                                            <span class="input-group-addon add-on">%</span>
                                        </div>
                                        @if($errors->has('perMonthWithdrawal'))
                                            <span class="help-block text-danger">{{$errors->first('perMonthWithdrawal')}}</span>
                                        @endif
                                        <small class="help-block">max is 100%</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Will Company Cut Salary</label>
                                    <div class="col-md-6 col-xs-12 myClass" style="margin-top: 7px;">
                                        <input id="is_both" type="checkbox" data-on="Salary Cut" data-off="Company Pay"
                                               {{ (($p->is_both * 1) == 1 ) ? "checked" : "" }} data-toggle="toggle"
                                               data-onstyle="success" data-offstyle="outline-secondary"
                                               name="is_both" value="1">
                                    </div>
                                </div>
                                @if(($p->is_both* 1) == 1)
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Company Pay</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span
                                                            class="fa fa-pencil"></span></span>
                                                <input type="number" value="{{$p->company_pay_percentage}}"
                                                       name="companyPay"
                                                       required min="0" max="100" step="0.01"
                                                       class="form-control {{$errors->has('companyPay') ? 'is-invalid' : ''}}">
                                                <span class="input-group-addon add-on">%</span>
                                            </div>
                                            @if($errors->has('companyPay'))
                                                <span class="help-block text-danger">{{$errors->first('companyPay')}}</span>
                                            @endif
                                            <small class="help-block">max is 100%</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="panel-footer">
                                <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                            class="fa fa-refresh"></span></a>
                                <button class="btn btn-primary pull-right">Update</button>
                            </div>
                        </form>
                        {{--     Form end               --}}
                        <form action="{{route('pension.is.both')}}" class="form-horizontal" method="post" id="isBoth">
                            @csrf
                        </form>
                    @else
                        <div class="panel-body"></div>
                        <div class="panel-footer"></div>
                    @endif
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
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#is_pension").next().on("click", (e) => {
                if (confirm('Are you sure ?')) {
                    $('#pension').submit();
                } else {
                    e.stopPropagation();
                }
            });
            $("#is_both").next().on("click", (e) => {
                if (confirm('Are you sure ?')) {
                    $('#isBoth').submit();
                } else {
                    e.stopPropagation();
                }
            });
            // $("#is_gross").next().on("change", (e) => {
            $("#is_gross").on("change", (e) => {
                if (confirm('Are you sure ?')) {
                    $.ajax({
                        url: '/Pension/is_gross',
                        method: "GET",
                        success: function (r) {
                            if (r != '') {
                                $("#Gross").html(r);
                            }
                        }
                    });
                    // $.ajax({
                    //     url: '/Pension/is_gross_text',
                    //     method: "GET",
                    //     success: function (r) {
                    //         if (r != '') {
                    //             $("#Gross").html(r);
                    //         }
                    //     }
                    // });
                } else {
                    e.stopPropagation();
                }
            });
        });
    </script>
    <!-- END THIS PAGE PLUGINS-->
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css"--}}
{{--      rel="stylesheet">--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        --}}{{--        @if(session('PensionActiveSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('PensionActiveSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('PensionDEActiveSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('PensionDEActiveSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('PensionBothSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('PensionBothSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('PensionDEBothSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-info text-center">--}}
{{--        --}}{{--                {{session('PensionDEBothSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('PensionUpdateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('PensionUpdateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        <div id="is_Gross"></div>--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-10 offset-lg-1 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">--}}
{{--                            --}}{{--                            Pension--}}
{{--                            --}}{{--                            <form action="{{route('pension.isActive.change')}}" class="form-horizontal" method="post"--}}
{{--                            --}}{{--                                  style="float: right;" id="pension">--}}
{{--                            --}}{{--                                @csrf--}}
{{--                            --}}{{--                                <input id="is_pension" type="checkbox"--}}
{{--                            --}}{{--                                       {{ (($p->is_active * 1) == 1 ) ? "checked" : "" }} data-toggle="toggle"--}}
{{--                            --}}{{--                                       data-onstyle="success" data-offstyle="outline-secondary" name="pension_active"--}}
{{--                            --}}{{--                                       value="1">--}}
{{--                            --}}{{--                            </form>--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        @if(($p->is_active * 1) == 1 )--}}
{{--                            <form action="{{route('pension.update')}}" class="form-horizontal" method="post">--}}
{{--                                @csrf--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 form-control-label">Total Pay</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <div class="input-group mb-3">--}}
{{--                                            <input type="number" name="totalPay" min="0"--}}
{{--                                                   value="{{$p->total_pay_months}}"--}}
{{--                                                   class="form-control form-control-success {{$errors->has('totalPay') ? 'is-invalid' : ''}}"--}}
{{--                                                   required>--}}
{{--                                            <div class="input-group-append">--}}
{{--                                                <span class="input-group-text" id="basic-addon2"> Months of <span>&nbsp;<b--}}
{{--                                                                id="Gross">{{ (($p->is_gross_salary * 1) == 1 ) ? "Gross" : "Total" }}</b>&nbsp;</span> Salary </span>--}}
{{--                                            </div>--}}
{{--                                            @if($errors->has('totalPay'))--}}
{{--                                                <span class="help-block text-danger">{{$errors->first('totalPay')}}</span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 form-control-label">Salary Percentage</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        @if($errors->has('salaryPercentage'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('salaryPercentage')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <div class="input-group mb-3">--}}
{{--                                            <input type="number" name="salaryPercentage" min="0" max="100"--}}
{{--                                                   value="{{$p->salary_percentage}}"--}}
{{--                                                   class="form-control form-control-success {{$errors->has('salaryPercentage') ? 'is-invalid' : ''}}"--}}
{{--                                                   required step="0.01">--}}
{{--                                            <div class="input-group-append">--}}
{{--                                                <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <small class="form-text text-muted ml-3" style="margin-top: -10px;">max is 100%*--}}
{{--                                        </small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 form-control-label">Only Gross Salary</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <input id="is_gross" type="checkbox" data-on="Yes" data-off="No"--}}
{{--                                               {{ (($p->is_gross_salary * 1) == 1 ) ? "checked" : "" }} data-toggle="toggle"--}}
{{--                                               data-onstyle="outline-success" data-offstyle="outline-secondary"--}}
{{--                                               name="is_gross"--}}
{{--                                               value="1">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 form-control-label">Max Initial Withdrawal</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        @if($errors->has('maxWithdrawal'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('maxWithdrawal')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <div class="input-group mb-3">--}}
{{--                                            <input type="number" name="maxWithdrawal" min="0" max="100"--}}
{{--                                                   value="{{$p->max_withdraw_percentage}}"--}}
{{--                                                   class="form-control form-control-success {{$errors->has('maxWithdrawal') ? 'is-invalid' : ''}}"--}}
{{--                                                   required step="0.01">--}}
{{--                                            <div class="input-group-append">--}}
{{--                                                <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <small class="form-text text-muted ml-3" style="margin-top: -10px;">max is 100%*--}}
{{--                                        </small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 form-control-label">Per Month Withdrawal</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        @if($errors->has('perMonthWithdrawal'))--}}
{{--                                            <span class="help-block text-danger">{{$errors->first('perMonthWithdrawal')}}</span>--}}
{{--                                        @endif--}}
{{--                                        <div class="input-group mb-3">--}}
{{--                                            <input type="number" name="perMonthWithdrawal" min="0" max="100"--}}
{{--                                                   value="{{$p->per_month_withdraw_percentage}}"--}}
{{--                                                   class="form-control form-control-success {{$errors->has('perMonthWithdrawal') ? 'is-invalid' : ''}}"--}}
{{--                                                   required step="0.01">--}}
{{--                                            <div class="input-group-append">--}}
{{--                                                <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <small class="form-text text-muted ml-3" style="margin-top: -10px;">max is 100%*--}}
{{--                                        </small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 form-control-label">Will Company Cut Salary</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <input id="is_both" type="checkbox" data-on="Yes" data-off="No"--}}
{{--                                               {{ (($p->is_both * 1) == 1 ) ? "checked" : "" }} data-toggle="toggle"--}}
{{--                                               data-onstyle="outline-success" data-offstyle="outline-secondary"--}}
{{--                                               name="is_both"--}}
{{--                                               value="1">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @if(($p->is_both* 1) == 1)--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-md-3 form-control-label">Company Pay</label>--}}
{{--                                        <div class="col-md-9">--}}
{{--                                            @if($errors->has('companyPay'))--}}
{{--                                                <span class="help-block text-danger">{{$errors->first('companyPay')}}</span>--}}
{{--                                            @endif--}}
{{--                                            <div class="input-group mb-3">--}}
{{--                                                <input type="number" value="{{$p->company_pay_percentage}}"--}}
{{--                                                       name="companyPay"--}}
{{--                                                       min="0" max="100"--}}
{{--                                                       class="form-control form-control-success {{$errors->has('companyPay') ? 'is-invalid' : ''}}"--}}
{{--                                                       required step="0.01">--}}
{{--                                                <div class="input-group-append">--}}
{{--                                                    <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <small class="form-text text-muted ml-3" style="margin-top: -10px;">max is--}}
{{--                                                100%*--}}
{{--                                            </small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-md-9 ml-auto">--}}
{{--                                        <button type="submit" class="btn btn-primary">Update Pension</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </form>--}}
{{--                            <form action="{{route('pension.is.both')}}" class="form-horizontal" method="post"--}}
{{--                                  id="isBoth">--}}
{{--                                @csrf--}}
{{--                            </form>--}}
{{--                        @endif--}}
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
{{--            if (confirm('Are you sure ?')) {--}}
{{--                $('#pension').submit();--}}
{{--            } else {--}}
{{--                e.stopPropagation();--}}
{{--            }--}}
{{--        });--}}
{{--        $("#is_both").next().on("click", (e) => {--}}
{{--            if (confirm('Are you sure ?')) {--}}
{{--                $('#isBoth').submit();--}}
{{--            } else {--}}
{{--                e.stopPropagation();--}}
{{--            }--}}
{{--        });--}}
{{--        $("#is_gross").next().on("click", (e) => {--}}
{{--            if (confirm('Are you sure ?')) {--}}
{{--                $.ajax({--}}
{{--                    url: '/Pension/is_gross',--}}
{{--                    method: "GET",--}}
{{--                    success: function (r) {--}}
{{--                        if (r != '') {--}}
{{--                            $("#is_Gross").html(r);--}}
{{--                        }--}}
{{--                    }--}}
{{--                });--}}
{{--                $.ajax({--}}
{{--                    url: '/Pension/is_gross_text',--}}
{{--                    method: "GET",--}}
{{--                    success: function (r) {--}}
{{--                        if (r != '') {--}}
{{--                            $("#Gross").html(r);--}}
{{--                        }--}}
{{--                    }--}}
{{--                });--}}
{{--            } else {--}}
{{--                e.stopPropagation();--}}
{{--            }--}}
{{--        });--}}
{{--        // $("#is_gross").change((e) => {--}}
{{--        //     $.ajax({--}}
{{--        //         url: '/Pension/is_gross',--}}
{{--        //         method: "GET",--}}
{{--        //         success: function (r) {--}}
{{--        //             if (r != '') {--}}
{{--        //                 $("#is_Gross").html(r);--}}
{{--        //             }--}}
{{--        //         }--}}
{{--        //     });--}}
{{--        //     $.ajax({--}}
{{--        //         url: '/Pension/is_gross_text',--}}
{{--        //         method: "GET",--}}
{{--        //         success: function (r) {--}}
{{--        //             if (r != '') {--}}
{{--        //                 $("#Gross").html(r);--}}
{{--        //             }--}}
{{--        //         }--}}
{{--        //     });--}}
{{--        // });--}}


{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}