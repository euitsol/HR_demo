@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="row">
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-10 col-md-10 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Info about {{$u->name}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('userInfo.store', ['uid' => $u->id])}}" class="form-horizontal"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Name</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" value="{{$u->name}}" readonly
                                           class="form-control form-control-success">
                                    <small class="form-text text-muted ml-3">Please click Users menu to change name.
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Date Of Birth</label>
                                <div class="col-md-9">
                                    <input type="date" name="dob" @if($userinfo) value="{{$userinfo->dob}}" @endif
                                    class="form-control form-control-success {{$errors->has('dob') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('dob'))
                                        <span class="help-block text-danger">{{$errors->first('dob')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Mobile</label>
                                <div class="col-md-9">
                                    <input type="text" name="mobile" @if($userinfo) value="{{$userinfo->mobile}}" @endif
                                    class="form-control form-control-success {{$errors->has('mobile') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('mobile'))
                                        <span class="help-block text-danger">{{$errors->first('mobile')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Address</label>
                                <div class="col-md-9">
                                    <textarea
                                            class="form-control form-control-success {{$errors->has('address') ? 'has-error' : ''}}"
                                            name="address" id="" cols="30" rows="4" required>@if($userinfo)
                                            {{$userinfo->address}} @endif</textarea>
                                    <script>
                                        CKEDITOR.replace('address');
                                    </script>
                                    @if($errors->has('address'))
                                        <span class="help-block text-danger">{{$errors->first('address')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Emergency Contract</label>
                                <div class="col-md-9">
                                    <textarea
                                            class="form-control form-control-success {{$errors->has('EC') ? 'has-error' : ''}}"
                                            name="EC" id="" cols="30" rows="4" required>@if($userinfo)
                                            {{$userinfo->emergency_contract}} @endif</textarea>
                                    <script>
                                        CKEDITOR.replace('EC');
                                    </script>
                                    @if($errors->has('EC'))
                                        <span class="help-block text-danger">{{$errors->first('EC')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Academic</label>
                                <div class="col-md-9">
                                    <textarea
                                            class="form-control form-control-success {{$errors->has('AS') ? 'has-error' : ''}}"
                                            name="AS" id="" cols="30" rows="4" required>
                                        @if($userinfo) {{$userinfo->academic_skills}} @endif
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('AS');
                                    </script>
                                    @if($errors->has('AS'))
                                        <span class="help-block text-danger">{{$errors->first('AS')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Blood Group</label>
                                <div class="col-md-9">
                                    <input type="text" name="bloodGroup"
                                           @if($userinfo) value="{{$userinfo->blood_group}}" @endif
                                           class="form-control form-control-success {{$errors->has('bloodGroup') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('bloodGroup'))
                                        <span class="help-block text-danger">{{$errors->first('bloodGroup')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Reference</label>
                                <div class="col-md-9">
                                    <textarea
                                            class="form-control form-control-success {{$errors->has('reference') ? 'has-error' : ''}}"
                                            name="reference" id="" cols="30" rows="4" required>@if($userinfo)
                                            {{$userinfo->reference}} @endif</textarea>
                                    <script>
                                        CKEDITOR.replace('reference');
                                    </script>
                                    @if($errors->has('reference'))
                                        <span class="help-block text-danger">{{$errors->first('reference')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label>Upload Photo</label>
                                <input type="file" class="form-control-file" name="image">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-9 ml-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('user.cv', $u->id) }}" class="btn btn-info" target="_blank">CV</a>
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