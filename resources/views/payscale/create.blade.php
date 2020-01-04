@extends('layouts.joli')
@section('title', 'Pay Scale Create')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[6]->display_name}}</li>
        <li><a href="{{route('payScale')}}">{{$menu[9]->display_name}}</a></li>
        <li class="active">Create</li>
    </ul>
@endsection
@section('pageTitle', 'Pay Scale Create')
@section('content')
    <section class="pb-5">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">PAY SCALE CREATE</h3>
                    </div>
                    <form action="{{route('payScale.store')}}" class="form-horizontal"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Title</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" placeholder="Pay Scale Title" name="title" required
                                               class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('title'))
                                        <span class="help-block text-danger">{{$errors->first('title')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Wage</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <input type="number" step="0.01" min="0" name="pay" required
                                               class="form-control {{$errors->has('pay') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('pay'))
                                        <span class="help-block text-danger">{{$errors->first('pay')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Compensation</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <input type="number" step="0.01" min="0" name="compensation" required
                                               class="form-control {{$errors->has('compensation') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('compensation'))
                                        <span class="help-block text-danger">{{$errors->first('compensation')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Benefit</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <input type="number" step="0.01" min="0" name="benefit" required
                                               class="form-control {{$errors->has('benefit') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('benefit'))
                                        <span class="help-block text-danger">{{$errors->first('benefit')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Benefit Details</label>
                                <div class="col-md-6 col-xs-12">
                                    <textarea
                                            class="form-control {{$errors->has('BenefitDetails') ? 'is-invalid' : ''}}"
                                            rows="5" name="BenefitDetails" required></textarea>
                                    @if($errors->has('BenefitDetails'))
                                        <span class="help-block text-danger">{{$errors->first('BenefitDetails')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Family Support</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <input type="number" step="0.01" min="0" name="familySupport" required
                                               class="form-control {{$errors->has('familySupport') ? 'is-invalid' : ''}}">
                                    </div>
                                    @if($errors->has('familySupport'))
                                        <span class="help-block text-danger">{{$errors->first('familySupport')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Family Support Details</label>
                                <div class="col-md-6 col-xs-12">
                                    <textarea
                                            class="form-control {{$errors->has('familySupportDetails') ? 'is-invalid' : ''}}"
                                            rows="5" name="familySupportDetails" required></textarea>
                                    @if($errors->has('familySupportDetails'))
                                        <span class="help-block text-danger">{{$errors->first('familySupportDetails')}}</span>
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
{{--        <div class="row">--}}
{{--            <div class="col-lg-10 offset-lg-1 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Pay Scale Create</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('payScale.store')}}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Title</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <input type="text" name="title"--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('title') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                           required>--}}
{{--                            --}}{{--                                    @if($errors->has('title'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('title')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Wage</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <input type="number" step="0.01" min="0" name="pay"--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('pay') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                           required>--}}
{{--                            --}}{{--                                    @if($errors->has('pay'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('pay')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Compensation</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <input type="number" step="0.01" min="0" name="compensation"--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('compensation') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                           required>--}}
{{--                            --}}{{--                                    @if($errors->has('compensation'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('compensation')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Benefit</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <input type="number" step="0.01" min="0" name="benefit" required--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('benefit') ? 'is-invalid' : ''}}">--}}
{{--                            --}}{{--                                    @if($errors->has('benefit'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('benefit')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Benefit Details</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <textarea--}}
{{--                            --}}{{--                                            class="form-control form-control-success {{$errors->has('BenefitDetails') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                            name="BenefitDetails" id="" cols="30" rows="3" required></textarea>--}}
{{--                            --}}{{--                                    @if($errors->has('BenefitDetails'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('BenefitDetails')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Family Support</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <input type="number" step="0.01" min="0" name="familySupport" required--}}
{{--                            --}}{{--                                           class="form-control form-control-success {{$errors->has('familySupport') ? 'is-invalid' : ''}}">--}}
{{--                            --}}{{--                                    @if($errors->has('familySupport'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('familySupport')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            --}}{{--                            <div class="form-group row">--}}
{{--                            --}}{{--                                <label class="col-md-3 form-control-label">Family Support Details</label>--}}
{{--                            --}}{{--                                <div class="col-md-9">--}}
{{--                            --}}{{--                                    <textarea--}}
{{--                            --}}{{--                                            class="form-control form-control-success {{$errors->has('familySupportDetails') ? 'is-invalid' : ''}}"--}}
{{--                            --}}{{--                                            name="familySupportDetails" id="" cols="30" rows="3" required></textarea>--}}
{{--                            --}}{{--                                    @if($errors->has('familySupportDetails'))--}}
{{--                            --}}{{--                                        <span class="help-block text-danger">{{$errors->first('familySupportDetails')}}</span>--}}
{{--                            --}}{{--                                    @endif--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Create</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}