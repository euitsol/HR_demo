@extends('layouts.joli')
@section('title', 'Loan')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[33]->display_name}}</li>
        <li class="active">{{$menu[38]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Loan')
@section('content')
    <div class="row mb-5">
        @if(session('LoanTypeCreateSuccess'))
            <div class="alert alert-success text-center">
                {{session('LoanTypeCreateSuccess')}}
            </div>
        @elseif(session('LoanTypeUpdateSuccess'))
            <div class="alert alert-success text-center">
                {{session('LoanTypeUpdateSuccess')}}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger text-center">
                {{session('error')}}
            </div>
        @elseif(session('success'))
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        @endif
        @if(count($users) > 0)
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Issue Loan</h3>
                    </div>
                    {{--     Form Start              --}}
                    <form action="{{route('user.loan')}}" class="form-horizontal" method="post" id="user-id-form">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Select Employee who has no due</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="input-group">
                                        {{--                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>--}}
                                        <select class="form-control" name="userId" required id="user-id">
                                            <option selected disabled hidden value="">Choose...</option>
                                            @foreach($users as $u)
                                                <option value="{{$u->id}}">{{$u->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer"></div>
                    </form>
                    {{--     Form end               --}}
                </div>
            </div>
        @endif
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Loan Type Create</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('loanType.store')}}" class="form-horizontal" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Type</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" placeholder="Type Name" name="type" required
                                           class="form-control {{$errors->has('type') ? 'is-invalid' : ''}}">
                                </div>
                                <small class="help-block">Duplicate entry is not allowed*</small>
                                @if($errors->has('type'))
                                    <span class="help-block text-danger">{{$errors->first('type')}}</span>
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
                    <h3 class="panel-title">All Loan Types</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Loan Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($loantypes as $i => $lt)
                            <tr>
                                <th scope="row">{{$i + 1}}</th>
                                <td>{{$lt->type}}</td>
                                <td>
                                    @if ($lt->id != 1)
                                        <a href="{{route('loan.type.edit', ['ltid' => $lt->id])}}"
                                           class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('loanType.delete', ['ltid' => $lt->id]) }}"
                                           class="btn btn-sm btn-danger" onclick="return confirm('Are you sure ?')"><i
                                                    class="fa fa-trash-o"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if(count($loanUsers) > 0)
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">All User Loan</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Loan Type</th>
                                <th>Due</th>
                                <th>Salary Cut Per Month</th>
                                <th>Months Lef</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($loanUsers as $i => $lu)
                                <tr>
                                    <th scope="row">{{$i + 1}}</th>
                                    <td>{{$lu->name}}</td>
                                    <td>{{$lu->loanType}}</td>
                                    <td>{{$lu->due}}</td>
                                    <td>{{$lu->pay_per_month}}</td>
                                    <td>{{($lu->due * 1) / ($lu->pay_per_month * 1)}}</td>
                                    <td>
                                        <a href="{{route('user.loan.edit.2', ['lid' => $lu->id])}}"
                                           class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('script')
    @if(count($users) > 0)
        <script>
            $(document).on('change', '#user-id', function () {
                $('#user-id-form').submit();
            });
        </script>
    @endif
@endsection

{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        --}}{{--        @if(session('LoanTypeCreateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('LoanTypeCreateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('LoanTypeUpdateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('LoanTypeUpdateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('error'))--}}
{{--        --}}{{--            <div class="alert alert-danger text-center">--}}
{{--        --}}{{--                {{session('error')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @elseif(session('success'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('success')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-6 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        --}}{{--                        <h3 class="h6 text-uppercase mb-0">Loan Type Create</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        --}}{{--                        <form action="{{route('loanType.store')}}" class="form-horizontal" method="post">--}}
{{--                        @csrf--}}
{{--                        --}}{{--                            <div class="form-group row">--}}
{{--                        --}}{{--                                <label class="col-md-3 form-control-label">Type</label>--}}
{{--                        --}}{{--                                <div class="col-md-9">--}}
{{--                        --}}{{--                                    @if($errors->has('type'))--}}
{{--                        --}}{{--                                        <span class="help-block text-danger">{{$errors->first('type')}}</span>--}}
{{--                        --}}{{--                                    @endif--}}
{{--                        --}}{{--                                    <input type="text" placeholder="Loan Type" name="type"--}}
{{--                        --}}{{--                                           class="form-control form-control-success {{$errors->has('type') ? 'is-invalid' : ''}}"--}}
{{--                        --}}{{--                                           required>--}}
{{--                                                            <small class="form-text text-muted ml-3">Duplicate entry is not allowed*.--}}
{{--                                                            </small>--}}
{{--                        --}}{{--                                </div>--}}
{{--                        --}}{{--                            </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            --}}{{--                                <div class="col-md-9 ml-auto">--}}
{{--                            --}}{{--                                    <button type="submit" class="btn btn-primary">Create</button>--}}
{{--                            --}}{{--                                </div>--}}
{{--                        </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        --}}{{--                        <h6 class="text-uppercase mb-0">All Loan Types</h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                --}}{{--                                <th>#</th>--}}
{{--                                --}}{{--                                <th>Loan Type</th>--}}
{{--                                --}}{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            --}}{{--                            @foreach($loantypes as $i => $lt)--}}
{{--                            --}}{{--                                <tr>--}}
{{--                            --}}{{--                                    <th scope="row">{{$i + 1}}</th>--}}
{{--                            --}}{{--                                    <td>{{$lt->type}}</td>--}}
{{--                            --}}{{--                                    <td class="text-right">--}}
{{--                            --}}{{--                                        @if ($lt->id != 1)--}}
{{--                            --}}{{--                                            <a href="{{route('loan.type.edit', ['ltid' => $lt->id])}}"--}}
{{--                            --}}{{--                                               class="btn btn-sm btn-success">Edit</a>--}}
{{--                            --}}{{--                                            <a href="{{ route('loanType.delete', ['ltid' => $lt->id]) }}"--}}
{{--                            --}}{{--                                               class="btn btn-sm btn-danger" onclick="return confirm('Are you sure ?')">Delete</a>--}}
{{--                            --}}{{--                                        @endif--}}
{{--                            --}}{{--                                    </td>--}}
{{--                            --}}{{--                                </tr>--}}
{{--                            --}}{{--                            @endforeach--}}
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