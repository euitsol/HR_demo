@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="row">
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-10 col-md-10 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Pay Info about {{$u->name}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('userPayInfo.store', ['uid' => $u->id])}}" class="form-horizontal"
                              method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Pay</label>
                                <div class="col-md-9">
                                    <input type="number" step="0.01" min="0" name="pay"
                                           @if($userPayInfo) value="{{$userPayInfo->pay}}"
                                           @elseif($pay) value="{{$pay->pay}}" @endif
                                           class="form-control form-control-success {{$errors->has('pay') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('pay'))
                                        <span class="help-block text-danger">{{$errors->first('pay')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Tax</label>
                                <div class="col-md-9">
                                    <input type="number" step="0.01" min="0" name="tax"
                                           @if($userPayInfo) value="{{$userPayInfo->tax}}"
                                           @elseif($pay) value="{{$pay->tax}}" @endif
                                           class="form-control form-control-success {{$errors->has('tax') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('tax'))
                                        <span class="help-block text-danger">{{$errors->first('tax')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Compensation</label>
                                <div class="col-md-9">
                                    <input type="number" step="0.01" min="0" name="compensation"
                                           @if($userPayInfo) value="{{$userPayInfo->compensation}}"
                                           @elseif($pay) value="{{$pay->compensation}}" @endif
                                           class="form-control form-control-success {{$errors->has('compensation') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('compensation'))
                                        <span class="help-block text-danger">{{$errors->first('compensation')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Benefit</label>
                                <div class="col-md-9">
                                    <input type="number" step="0.01" min="0" name="benefit"
                                           @if($userPayInfo) value="{{$userPayInfo->benefit}}"
                                           @elseif($pay) value="{{$pay->benefit}}" @endif
                                           class="form-control form-control-success {{$errors->has('benefit') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('benefit'))
                                        <span class="help-block text-danger">{{$errors->first('benefit')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Benefit Details</label>
                                <div class="col-md-9">
                                    <textarea
                                            class="form-control form-control-success {{$errors->has('BDetails') ? 'has-error' : ''}}"
                                            name="BDetails" id="" cols="30" rows="4" required>@if($userPayInfo)
                                            {{$userPayInfo->benefit_detail}} @elseif($pay)
                                            {{$pay->benefit_detail}} @endif</textarea>
                                    @if($errors->has('BDetails'))
                                        <span class="help-block text-danger">{{$errors->first('BDetails')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Child & Family Support</label>
                                <div class="col-md-9">
                                    <input type="number" step="0.01" min="0" name="CFS"
                                           @if($userPayInfo) value="{{$userPayInfo->child_family_support}}"
                                           @elseif($pay) value="{{$pay->child_family_support}}" @endif
                                           class="form-control form-control-success {{$errors->has('CFS') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('CFS'))
                                        <span class="help-block text-danger">{{$errors->first('CFS')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Child & Family Support Details</label>
                                <div class="col-md-9">
                                    <textarea
                                            class="form-control form-control-success {{$errors->has('SDetails') ? 'has-error' : ''}}"
                                            name="SDetails" id="" cols="30" rows="4" required>@if($userPayInfo)
                                            {{$userPayInfo->child_family_support_detail}} @elseif($pay)
                                            {{$pay->child_family_support_detail}} @endif</textarea>
                                    @if($errors->has('SDetails'))
                                        <span class="help-block text-danger">{{$errors->first('SDetails')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-9 ml-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
</body>
</html>