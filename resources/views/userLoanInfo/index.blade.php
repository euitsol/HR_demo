@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        @if(session('mppm'))
            <div class="alert alert-danger text-center">
                {{session('mppm')}}
            </div>
        @elseif(session('LoanStoreSuccess'))
            <div class="alert alert-success text-center">
                {{session('LoanStoreSuccess')}}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-10 col-md-10 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Loan Info about "{{$user->name}}"</h3>
                    </div>
                    <div class="card-body">
                        @if(count($userLoans) > 0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Loan Type</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Due</th>
                                    <th scope="col">Pay Per Month</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userLoans as $i => $ul)
                                    <tr>
                                        <th>{{$i + 1}}</th>
                                        <td>{{$ul->loanType}}</td>
                                        <td>{{$ul->total_amount}}</td>
                                        <td><b style="color: #eb2f06;">{{$ul->due}}</b></td>
                                        <td>{{$ul->pay_per_month}}</td>
                                        <td>
                                            <a href="{{route('user.loan.edit', ['lid' => $ul->id])}}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
{{--                            <span style="float: right;">Total Due: 100</span>--}}
                            <br>
                            <hr>
                            <br>
                        @endif
                        <form action="{{route('userLoanInfo.store', ['uid' => $user->id])}}" class="form-horizontal"
                              method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Loan Type</label>
                                <div class="col-md-9">
                                    <select class="form-control {{$errors->has('loanType') ? 'has-error' : ''}}"
                                            name="loanType" required>
                                        @if($errors->has('loanType'))
                                            <span class="help-block text-danger">{{$errors->first('loanType')}}</span>
                                        @endif
                                        <option selected disabled hidden value="">Choose...</option>
                                        @foreach($loanTypes as $lt)
                                            <option value="{{$lt->id}}">{{$lt->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Total Amount</label>
                                <div class="col-md-9">
                                    <input type="number" name="totalAmount" min="0" id="ta"
                                           class="form-control form-control-success {{$errors->has('totalAmount') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('totalAmount'))
                                        <span class="help-block text-danger">{{$errors->first('totalAmount')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Will pay in</label>
                                <div class="col-md-9">
                                    <div class="input-group mb-3">
                                        <input id="ms" type="number" placeholder="Number of Months" name="monthNumber"
                                               min="0"
                                               class="form-control form-control-success" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"> Months </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Pay Per Month</label>
                                <div class="col-md-9">
                                    <input type="number" name="payPerMonth" min="0" readonly id="ppm"
                                           class="form-control form-control-success {{$errors->has('payPerMonth') ? 'has-error' : ''}}"
                                           required>
                                    <span>max amount is <b>{{$mppm}}</b></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-9 ml-auto">
                                    <button id="submit" type="submit" class="btn btn-primary" disabled>Add Loan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1"></div>
        </div>
    </section>
</div>
@include('includes.bubbly.footer')


<script>
    $(function () {
        var mppm = '{{$mppm}}';

        function check() {
            var ta = $("#ta").val();
            var month = $("#ms").val();
            if (ta && month && (ta * 1) > 0 && (month * 1) > 0) {
                var ppm = (ta * 1) / (month * 1);
                if (ppm > mppm) {
                    $("#ms").val(0);
                    $("#ppm").val(0);
                    document.getElementById('submit').disabled = true;
                    alert('Pay Per Month has exceed the max amount');
                } else {
                    $("#ppm").val(ppm);
                    document.getElementById('submit').disabled = false;
                }
            }
        }

        $("#ta").change((e) => {
            check();
        });
        $("#ms").change((e) => {
            check();
        });
    });


</script>


</body>
</html>