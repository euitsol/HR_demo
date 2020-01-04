@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        @if(session('mppm'))
            <div class="alert alert-danger text-center">
                {{session('mppm')}}
            </div>
        @elseif(session('LoanUpdateSuccess'))
            <div class="alert alert-success text-center">
                {{session('LoanUpdateSuccess')}}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-10 col-md-10 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Edit Loan Info about "{{$user->name}}"</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('user.loan.update', ['lid' => $loan->id])}}" class="form-horizontal"
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
                                        <option selected hidden value="{{$loan->id}}">{{$loan->type}}</option>
                                        @foreach($loanTypes as $lt)
                                            <option value="{{$lt->id}}">{{$lt->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Total Amount</label>
                                <div class="col-md-9">
                                    <input type="number" name="totalAmount"
                                           min="{{(($loan->total_amount)*1) - (($loan->due)*1)}}" id="ta"
                                           value="{{$loan->total_amount}}"
                                           class="form-control form-control-success {{$errors->has('totalAmount') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('totalAmount'))
                                        <span class="help-block text-danger">{{$errors->first('totalAmount')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Already Paid</label>
                                <div class="col-md-9">
                                    <input type="number" name="AlreadyPaid"
                                           value="{{(($loan->total_amount)*1) - (($loan->due)*1)}}"
                                           class="form-control form-control-success" readonly required>
                                    @if($errors->has('AlreadyPaid'))
                                        <span class="help-block text-danger">{{$errors->first('AlreadyPaid')}}</span>
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
                                    <button id="submit" type="submit" class="btn btn-primary" disabled>Update Loan</button>
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
        var tta = '{{(($loan->total_amount)*1)}}';
        var mta = '{{(($loan->total_amount)*1) - (($loan->due)*1)}}';

        function check() {
            var ta = $("#ta").val();
            var month = $("#ms").val();
            if (ta && month && (ta * 1) > 0 && (month * 1) > 0) {
                var ppm = (ta * 1) / (month * 1);
                ppm = Math.round(ppm * 100) / 100;
                if ((ppm * 1) > (mppm * 1)) {
                    $("#ms").val(0);
                    $("#ppm").val(0);
                    document.getElementById('submit').disabled = true;
                    alert('Pay Per Month has exceed the max amount !');
                } else {
                    $("#ppm").val(ppm);
                    document.getElementById('submit').disabled = false;
                }
            }
        }

        $("#ta").change((e) => {
            var taa = $("#ta").val();
            if (taa && (taa * 1) > 0) {
                if ((taa * 1) < (mta * 1)) {
                    $("#ta").val(tta);
                    var month = $("#ms").val();
                    if (month && (month * 1) > 0) {
                        var ppm = (tta * 1) / (month * 1);
                        ppm = Math.round(ppm * 100) / 100;
                        if ((ppm * 1) > (mppm * 1)) {
                            $("#ms").val(0);
                            $("#ppm").val(0);
                        } else {
                            $("#ppm").val(ppm);
                        }
                    }
                    document.getElementById('submit').disabled = true;
                    alert('Total amount can not be less than already paid amount !');
                } else {
                    check();
                }
            }
        });
        $("#ms").change((e) => {
            check();
        });
    });


</script>


</body>
</html>