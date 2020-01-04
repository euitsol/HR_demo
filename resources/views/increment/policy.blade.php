@extends('layouts.joli')
@section('title', 'Increment Policy')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[17]->display_name}}</li>
        <li class="active">{{$menu[20]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Increment Policy')
@section('content')
    <div class="row">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        @elseif(session('mess'))
            <div class="alert alert-danger text-center">
                {{session('mess')}}
            </div>
        @endif
        <div class="col-md-10 col-md-offset-1">
            <!-- START TABLE HOVER ROWS -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Increment Policy</h3>
                </div>
                <form action="{{route('increment.policy.update')}}" class="form-horizontal" method="post">
                    @csrf
                    <div class="panel-body">
                        @if($errors->has('below') || $errors->has('increment_1') || $errors->has('above_1') || $errors->has('increment_2') || $errors->has('above_2') || $errors->has('increment_3') || $errors->has('increment_max'))
                            <span class="help-block text-danger">Please Do Not Mess With The Original Code !!!</span>
                        @endif
                            <p>Below
                                <input type="number" step="0.01" min="1" max="100" name="below" value="{{$ip->below}}"
                                       style="max-width: 60px;" required>% of KPI target will get no increment.</p>
                            <p> <span id="below">{{$ip->below}}</span>% of KPI target to KPI target will get
                                <input type="number" step="0.01" min="1" max="100" name="increment_1"
                                       value="{{$ip->increment_1}}"
                                       style="max-width: 60px;" required>%
                                increment.</p>
                            <p>KPI target to
                                <input type="number" step="0.01" min="1" max="100" name="above_1"
                                       value="{{$ip->above_1}}"
                                       style="max-width: 60px;" required>% above of KPI
                                target will get <input type="number" step="0.01" min="1" max="100" name="increment_2"
                                                       value="{{$ip->increment_2}}" style="max-width: 60px;" required>%
                                increment.</p>
                            <p>Above <span id="above_1">{{$ip->above_1}}</span>% of KPI target to
                                <input type="number" step="0.01" min="1" max="100" name="above_2"
                                       value="{{$ip->above_2}}"
                                       style="max-width: 60px;" required>% above of KPI target will get
                                <input type="number" step="0.01" min="1" max="100" name="increment_3"
                                       value="{{$ip->increment_3}}"
                                       style="max-width: 60px;" required>% increment.
                            </p>
                            <p>Above <span id="above_2">{{$ip->above_2}}</span>% of KPI
                                target will get max
                                <input type="number" step="0.01" min="1" max="100" name="increment_max"
                                       value="{{$ip->increment_max}}" style="max-width: 60px;" required>%
                                increment.</p>
                            <hr>
                            <input type="checkbox" name="is_KPI"
                                   {{ (($ip->is_kpi * 1) == 1 ) ? "checked" : "" }} style="transform: scale(1.6);">
                            &nbsp;&nbsp;<b>User without KPI assigment will get No Increment.</b>
                    </div>
                    <div class="panel-footer">
                        <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                    class="fa fa-refresh"></span></a>
                        <button type="submit" class="btn btn-primary pull-right">Update</button>
                    </div>
                </form>
            </div>
            <!-- END TABLE HOVER ROWS -->
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('input[name=below]').change((e) => {
                var v = $('input[name=below]').val();
                $("#below").html(v);
            });
            $('input[name=above_1]').change((e) => {
                var v1 = $('input[name=above_1]').val();
                var v2 = $('input[name=above_2]').val();
                if ((v1 * 1) < (v2 * 1)) {
                    $("#above_1").html(v1);
                } else {
                    var vv = (v2 * 1) - 0.01;
                    $("#above_1").html(vv);
                    $('input[name=above_1]').val(vv);
                    alert('This has to be less than the next value !');
                }
            });
            $('input[name=above_2]').change((e) => {
                var v1 = $('input[name=above_1]').val();
                var v2 = $('input[name=above_2]').val();
                if ((v2 * 1) > (v1 * 1)) {
                    $("#above_2").html(v2);
                } else {
                    var vv = (v1 * 1) + .01;
                    $("#above_2").html(vv);
                    $('input[name=above_2]').val(vv);
                    alert('This has to be grater than the previous value !');
                }
            });
        });
    </script>
@endsection


















{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        --}}{{--        @if(session('success'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('success')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('mess'))--}}
{{--        --}}{{--            <div class="alert alert-danger text-center">--}}
{{--        --}}{{--                {{session('mess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Increment Policy</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        --}}{{--                        @if($errors->has('below') || $errors->has('increment_1') || $errors->has('above_1') || $errors->has('increment_2') || $errors->has('above_2') || $errors->has('increment_3') || $errors->has('increment_max'))--}}
{{--                        --}}{{--                            <span class="help-block text-danger">Please Do Not Mess With The Original Code !!!</span>--}}
{{--                        --}}{{--                        @endif--}}
{{--                        <form action="{{route('increment.policy.update')}}" class="form-horizontal" method="post">--}}
{{--                            @csrf--}}
{{--                            <p>Below--}}
{{--                                <input type="number" step="0.01" min="1" max="100" name="below" value="{{$ip->below}}"--}}
{{--                                       style="max-width: 60px;" required>% of KPI target will get no increment.</p>--}}
{{--                            <p>Below <span id="below">{{$ip->below}}</span>% of KPI target to KPI target will get--}}
{{--                                <input type="number" step="0.01" min="1" max="100" name="increment_1"--}}
{{--                                       value="{{$ip->increment_1}}"--}}
{{--                                       style="max-width: 60px;" required>%--}}
{{--                                increment.</p>--}}
{{--                            <p>KPI target to--}}
{{--                                <input type="number" step="0.01" min="1" max="100" name="above_1"--}}
{{--                                       value="{{$ip->above_1}}"--}}
{{--                                       style="max-width: 60px;" required>% above of KPI--}}
{{--                                target will get <input type="number" step="0.01" min="1" max="100" name="increment_2"--}}
{{--                                                       value="{{$ip->increment_2}}" style="max-width: 60px;" required>%--}}
{{--                                increment.</p>--}}
{{--                            <p>Above <span id="above_1">{{$ip->above_1}}</span>% of KPI target to--}}
{{--                                <input type="number" step="0.01" min="1" max="100" name="above_2"--}}
{{--                                       value="{{$ip->above_2}}"--}}
{{--                                       style="max-width: 60px;" required>% above of KPI target will get--}}
{{--                                <input type="number" step="0.01" min="1" max="100" name="increment_3"--}}
{{--                                       value="{{$ip->increment_3}}"--}}
{{--                                       style="max-width: 60px;" required>% increment.--}}
{{--                            </p>--}}
{{--                            <p>Above <span id="above_2">{{$ip->above_2}}</span>% of KPI--}}
{{--                                target will get max--}}
{{--                                <input type="number" step="0.01" min="1" max="100" name="increment_max"--}}
{{--                                       value="{{$ip->increment_max}}" style="max-width: 60px;" required>%--}}
{{--                                increment.</p>--}}
{{--                            <hr>--}}
{{--                            <input type="checkbox" name="is_KPI"--}}
{{--                                   {{ (($ip->is_kpi * 1) == 1 ) ? "checked" : "" }} style="transform: scale(2);">--}}
{{--                            &nbsp;&nbsp;User without KPI assigment will get No Increment.--}}
{{--                            <hr>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Update</button>--}}
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
{{--<script>--}}
{{--    $(function () {--}}
{{--        $('input[name=below]').change((e) => {--}}
{{--            var v = $('input[name=below]').val();--}}
{{--            $("#below").html(v);--}}
{{--        });--}}
{{--        $('input[name=above_1]').change((e) => {--}}
{{--            var v1 = $('input[name=above_1]').val();--}}
{{--            var v2 = $('input[name=above_2]').val();--}}
{{--            if ((v1 * 1) < (v2 * 1)) {--}}
{{--                $("#above_1").html(v1);--}}
{{--            } else {--}}
{{--                var vv = (v2 * 1) - 0.01;--}}
{{--                $("#above_1").html(vv);--}}
{{--                $('input[name=above_1]').val(vv);--}}
{{--                alert('This has to be less than the next value !');--}}
{{--            }--}}
{{--        });--}}
{{--        $('input[name=above_2]').change((e) => {--}}
{{--            var v1 = $('input[name=above_1]').val();--}}
{{--            var v2 = $('input[name=above_2]').val();--}}
{{--            if ((v2 * 1) > (v1 * 1)) {--}}
{{--                $("#above_2").html(v2);--}}
{{--            } else {--}}
{{--                var vv = (v1 * 1) + .01;--}}
{{--                $("#above_2").html(vv);--}}
{{--                $('input[name=above_2]').val(vv);--}}
{{--                alert('This has to be grater than the previous value !');--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}