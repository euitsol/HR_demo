@extends('layouts.joli')
@section('title', 'Salary Edit')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[33]->display_name}}</li>
        <li><a href="{{route('salary')}}">{{$menu[34]->display_name}}</a></li>
        <li class="active">Edit</li>
    </ul>
@endsection
@section('pageTitle', 'Salary Edit')
@section('content')
    <section class="mb-5">
        <div class="row">
            @if(session('SalaryUpdateSuccess'))
                <div class="alert alert-success text-center">
                    {{session('SalaryUpdateSuccess')}}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="panel panel-default" id="PC">
                    <div class="panel-heading">
                        <h3 class="panel-title">Salary Edit</h3>
                    </div>
                    <div class="panel-body">
                        @if($errors->has('basicSalary') || $errors->has('tax') || $errors->has('compensation') || $errors->has('benefit') || $errors->has('familySupport') || $errors->has('bonus') || $errors->has('loan') || $errors->has('providentFundUser') || $errors->has('providentFundEmployer') || $errors->has('pensionUser') || $errors->has('pensionEmployer') || $errors->has('totalSalary') || $errors->has('overtime'))
                            <span class="help-block text-danger">Please Do Not Mess With The Original Code !!!</span>
                            <br>
                        @endif
                        <form action="{{route('salary.update', ['sid' => $s->id])}}" method="post">
                            @csrf
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Employee</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Basic Salary</th>
                                    <th scope="col">Tax</th>
                                    <th scope="col">Compensation</th>
                                    <th scope="col">Benefit</th>
                                    <th scope="col">Family Support</th>
                                    <th scope="col">Bonus</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{$s->user_name}}</td>
                                    <td>{{$s->branch}}</td>
                                    <td>
                                        <input type="number" name="basicSalary" min="0" style="max-width: 100px;"
                                               value="{{$s->pay}}" required step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="tax" min="0" style="max-width: 100px;"
                                               value="{{$s->tax}}" required step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="compensation" min="0" style="max-width: 100px;"
                                               value="{{$s->compensation}}" required step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="benefit" min="0" style="max-width: 100px;"
                                               value="{{$s->benefit}}" required step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="familySupport" min="0" style="max-width: 100px;"
                                               value="{{$s->family_support}}" required step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="bonus" min="0" style="max-width: 100px;"
                                               value="{{$s->bonus}}" required step="0.01">
                                    </td>
                                </tr>
                                </tbody>
                                <thead>
                                <tr>
                                    <th scope="col">Loan Paid</th>
                                    <th scope="col">Provident Fund User</th>
                                    <th scope="col">Provident Fund Employer</th>
                                    @if (($pension->is_active * 1) == 1)
                                        <th scope="col">Pension User</th>
                                        <th scope="col">Pension Employer</th>
                                    @endif
                                    <th scope="col">Total Salary</th>
                                    <th scope="col">Overtime (hours)</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input type="number" name="loan" min="0" style="max-width: 100px;"
                                               value="{{$s->loan}}" required step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="providentFundUser" min="0" style="max-width: 100px;"
                                               value="{{$s->pf_user}}" required step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="providentFundEmployer" min="0"
                                               style="max-width: 100px;"
                                               value="{{$s->pf_company}}" required step="0.01">
                                    </td>
                                    @if (($pension->is_active * 1) == 1)
                                        <td>
                                            <input type="number" name="pensionUser" min="0" style="max-width: 100px;"
                                                   value="{{$s->pension_user}}" required step="0.01">
                                        </td>
                                        <td>
                                            <input type="number" name="pensionEmployer" min="0"
                                                   style="max-width: 100px;"
                                                   value="{{$s->pension_company}}" required step="0.01">
                                        </td>
                                    @endif
                                    <td>
                                        <input type="number" name="totalSalary" min="0" style="max-width: 100px;"
                                               value="{{$s->salary}}" required step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="overtime" min="0" style="max-width: 100px;"
                                               value="{{$s->over_time_hour}}" required step="0.01">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-info">Update</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    {{--    --}}
@endsection



{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        --}}{{--        @if(session('SalaryUpdateSuccess'))--}}
{{--        --}}{{--            <div class="alert alert-success text-center">--}}
{{--        --}}{{--                {{session('SalaryUpdateSuccess')}}--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        @endif--}}
{{--        @if($errors->has('basicSalary') || $errors->has('tax') || $errors->has('compensation') || $errors->has('benefit') || $errors->has('familySupport') || $errors->has('bonus') || $errors->has('loan') || $errors->has('providentFundUser') || $errors->has('providentFundEmployer') || $errors->has('pensionUser') || $errors->has('pensionEmployer') || $errors->has('totalSalary') || $errors->has('overtime'))--}}
{{--            <span class="help-block text-danger">Please Do Not Mess With The Original Code !!!</span>--}}
{{--        @endif--}}
{{--        <div class="row" id="PC">--}}
{{--            <div class="col-lg-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Salary Edit</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        --}}{{--                        <form action="{{route('salary.update', ['sid' => $s->id])}}" method="post">--}}
{{--                        --}}{{--                            @csrf--}}
{{--                        <table class="table table-striped">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th scope="col">Employee</th>--}}
{{--                                <th scope="col">Branch</th>--}}
{{--                                <th scope="col">Basic Salary</th>--}}
{{--                                <th scope="col">Tax</th>--}}
{{--                                <th scope="col">Compensation</th>--}}
{{--                                <th scope="col">Benefit</th>--}}
{{--                                <th scope="col">Family Support</th>--}}
{{--                                <th scope="col">Bonus</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <td>{{$s->user_name}}</td>--}}
{{--                                <td>{{$s->branch}}</td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="basicSalary" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->pay}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="tax" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->tax}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="compensation" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->compensation}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="benefit" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->benefit}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="familySupport" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->family_support}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="bonus" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->bonus}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="col">Loan Paid</th>--}}
{{--                                <th scope="col">Provident Fund User</th>--}}
{{--                                <th scope="col">Provident Fund Employer</th>--}}
{{--                                @if (($pension->is_active * 1) == 1)--}}
{{--                                    <th scope="col">Pension User</th>--}}
{{--                                    <th scope="col">Pension Employer</th>--}}
{{--                                @endif--}}
{{--                                <th scope="col">Total Salary</th>--}}
{{--                                <th scope="col">Overtime (hours)</th>--}}
{{--                                <th scope="col">Action</th>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="loan" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->loan}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="providentFundUser" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->pf_user}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="providentFundEmployer" min="0"--}}
{{--                                           style="max-width: 100px;"--}}
{{--                                           value="{{$s->pf_company}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                @if (($pension->is_active * 1) == 1)--}}
{{--                                    <td>--}}
{{--                                        <input type="number" name="pensionUser" min="0" style="max-width: 100px;"--}}
{{--                                               value="{{$s->pension_user}}" required step="0.01">--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <input type="number" name="pensionEmployer" min="0"--}}
{{--                                               style="max-width: 100px;"--}}
{{--                                               value="{{$s->pension_company}}" required step="0.01">--}}
{{--                                    </td>--}}
{{--                                @endif--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="totalSalary" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->salary}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input type="number" name="overtime" min="0" style="max-width: 100px;"--}}
{{--                                           value="{{$s->over_time_hour}}" required step="0.01">--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <button type="submit" class="btn btn-sm btn-outline-success">Update</button>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
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