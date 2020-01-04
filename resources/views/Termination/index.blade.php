@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="row">
                    @if(session('AccountCloseSuccess'))
                        <div class="alert alert-info text-center">
                            {{session('AccountCloseSuccess')}}
                        </div>
        {{--            @elseif(session('UserUpdateSuccess'))--}}
        {{--                <div class="alert alert-success text-center">--}}
        {{--                    {{session('UserUpdateSuccess')}}--}}
        {{--                </div>--}}
                @endif
        <!-- Basic Form-->
            <div class="col-lg-10 offset-lg-1 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Account Close</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('account.close.user')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="form-control-label col-md-2">Select User</label>
                                <div class=" col-md-10">
                                    <select class="form-control" name="user" required>
                                        @if($errors->has('user'))
                                            <span class="help-block text-danger">{{$errors->first('user')}}</span>
                                        @endif
                                        <option selected disabled hidden value="">Choose Employee</option>
                                        @foreach($users as $u)
                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-control-label col-md-2">Reason</label>
                                <div class="col-md-10">
                                    <input type="text" name="reason"
                                           class="form-control form-control-success {{$errors->has('reason') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('reason'))
                                        <span class="help-block text-danger">{{$errors->first('reason')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-control-label col-md-2">Upload Document</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control-file" name="file">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure ?')">
                                    Permanently Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('includes.bubbly.footer')
</body>
</html>