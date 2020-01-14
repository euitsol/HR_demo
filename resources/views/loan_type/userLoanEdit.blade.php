@extends('layouts.joli')
@section('title', 'Loan')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[33]->display_name}}</li>
        <li><a href="{{route('loan.type')}}">{{$menu[38]->display_name}}</a></li>
        <li class="active">User Loan Edit</li>
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
        @elseif(session('unsuccess'))
            <div class="alert alert-warning text-center">
                {{session('unsuccess')}}
            </div>
        @endif
        <div class="col-lg-10 offset-lg-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Loan of {{$user->name}}</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('user.loan.update.2', ['lid' => $userLoan->id])}}" class="form-horizontal"
                      method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Amount</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" value="{{$userLoan->pay_per_month}}" name="loanAmount" required
                                           max="{{$maxLoanPerMonth}}"
                                           class="form-control {{$errors->has('loanAmount') ? 'is-invalid' : ''}}">
                                </div>
                                <small class="help-block">max amount is {{$maxLoanPerMonth}}</small>
                                @if($errors->has('loanAmount'))
                                    <span class="help-block text-danger">{{$errors->first('loanAmount')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Number of months</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="number" name="months" required
                                           value="{{($userLoan->due * 1) / ($userLoan->pay_per_month * 1)}}"
                                           class="form-control {{$errors->has('months') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('months'))
                                    <span class="help-block text-danger">{{$errors->first('months')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                    class="fa fa-refresh"></span></a>
                        <button class="btn btn-primary pull-right">Update</button>
                    </div>
                </form>
                {{--     Form end               --}}
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection