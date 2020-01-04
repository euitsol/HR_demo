@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="row">
            <div class="col">
                @if(session('UserUpdateSuccess'))
                    <div class="alert alert-success text-center">
                        {{session('UserUpdateSuccess')}}
                    </div>
                @elseif(session('NoSuchUser'))
                    <div class="alert alert-danger text-center">
                        {{session('NoSuchUser')}}
                    </div>
                @elseif(session('NoUserJob'))
                    <div class="alert alert-danger text-center">
                        {{session('NoUserJob')}}
                    </div>
                @elseif(session('NoPayForJob'))
                    <div class="alert alert-danger text-center">
                        {{session('NoPayForJob')}}
                    </div>
                @endif
            </div>
            <!-- Basic Form-->
            <div class="col-lg-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Search User</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('userLoanInfo')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email"
                                       class="mr-3 form-control {{$errors->has('email') ? 'has-error' : ''}}" required>
                            </div>
                            @if($errors->has('email'))
                                <span class="help-block text-danger">{{$errors->first('email')}}</span>
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Search</button>
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