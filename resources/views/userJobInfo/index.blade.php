@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="row">
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-10 col-md-10 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Job Info about {{$u->name}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('userJobInfo.store', ['uid' => $u->id])}}" class="form-horizontal"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Job</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="job" required>
                                        @if($errors->has('job'))
                                            <span class="help-block text-danger">{{$errors->first('job')}}</span>
                                        @endif
                                        @if($job)
                                            <option selected hidden value="{{$job->id}}">{{$job->title}}</option>
                                        @else
                                            <option selected disabled hidden value="">Choose...</option>
                                        @endif
                                        @foreach($jobs as $j)
                                            <option value="{{$j->id}}">{{$j->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Description</label>
                                <div class="col-md-9">
                                    <textarea
                                            class="form-control form-control-success {{$errors->has('description') ? 'has-error' : ''}}"
                                            name="description" id="" cols="30" rows="4" required>@if($userJobInfo)
                                            {{$userJobInfo->job_description}} @endif</textarea>
                                    @if($errors->has('description'))
                                        <span class="help-block text-danger">{{$errors->first('description')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Contract</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="contract" required>
                                        @if($errors->has('contract'))
                                            <span class="help-block text-danger">{{$errors->first('contract')}}</span>
                                        @endif
                                        @if($contract)
                                            <option selected hidden
                                                    value="{{$contract->id}}">{{$contract->type}}</option>
                                        @else
                                            <option selected disabled hidden value="">Choose...</option>
                                        @endif
                                        @foreach($contracts as $c)
                                            <option value="{{$c->id}}">{{$c->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Contract Length</label>
                                <div class="col-md-9">
                                    <input type="text" name="CL"
                                           @if($userJobInfo) value="{{$userJobInfo->contract_length}}" @endif
                                           class="form-control form-control-success {{$errors->has('CL') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('CL'))
                                        <span class="help-block text-danger">{{$errors->first('CL')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label>Upload Offer Letter</label>
                                <input type="file" class="form-control-file" name="offerLetter">
                            </div>
                            <div class="form-group row">
                                <label>Upload Resume</label>
                                <input type="file" class="form-control-file" name="resume">
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