@extends('layouts.joli')
@section('title', 'Employee Edit')
{{--@section('link')--}}
{{--    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>--}}
{{--@endsection--}}
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[17]->display_name}}</li>
        <li class="active">{{$menu[19]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Employee Edit')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('unsuccess'))
                <div class="alert alert-danger text-center">
                    {{session('unsuccess')}}
                </div>
            @endif
            <div class="col-lg-6 offset-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Select Employee</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{route('employee.edit.1')}}" class="form-horizontal" method="post"
                              id="userSelected">
                            @csrf
                            <div class="form-group row">
                                {{--                                <label class="col-md-3 col-xs-12 control-label">Select User</label>--}}
                                <div class="col-md-12 col-xs-12">
                                    <select class="form-control" name="employee_id" id="selectUser" required>
                                        <option selected disabled hidden value="">Select Employee to Edit</option>
                                        @foreach($es as $e)
                                            <option value="{{$e->id}}">{{$e->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
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
    <script>
        $(document).ready(function () {
            $("#selectUser").change((e) => {
                $('#userSelected').submit();
            });
        });
    </script>
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('unsuccess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('unsuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-6 offset-lg-3 pb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Select Employee</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('employee.edit.1')}}" method="post" id="userSelected">--}}
{{--                            @csrf--}}
{{--                            <select class="form-control" name="employee_id" id="selectUser">--}}
{{--                                <option selected disabled hidden value="">Choose...</option>--}}
{{--                                @foreach($es as $e)--}}
{{--                                        <option value="{{$e->id}}">{{$e->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $("#selectUser").change((e) => {--}}
{{--            $('#userSelected').submit();--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}