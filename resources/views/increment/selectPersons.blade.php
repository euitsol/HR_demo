@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{session('error')}}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-10 col-md-10 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Select Persons</h3>
                    </div>
                    <div class="card-body">
                        @if ($pending)
                            <h5 class="text-center bg-warning py-2 font-weight-normal">
                                Sorry, Increment info pending in CEO
                            </h5>
                        @else
                            <div class="table-responsive">
                                <form action="{{ route('increment.persons.selected') }}" method="post">
                                    @csrf
                                    @if ($edit) <input type="hidden" name="edit" value="1"> @endif
                                    <table class="table table-striped table-borderless">
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Remark</th>
                                        </tr>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>#{{ $key + 1 }}</td>
                                                <td>{{ ($edit) ? optional($user->user)->name : $user->name }}</td>
                                                <td>
                                                    <input type="text" name="remark[{{ ($edit) ? $user->user_id : $user->id }}]" value="{{ ($edit) ? $user->remark : '' }}" class="form-control" required>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <p class="text-center">
                                        <input type="submit" value="{{ ($edit) ? 'Update' : 'Submit' }}" class="btn btn-primary">
                                    </p>
                                </form>
                            </div>
                        @endif
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