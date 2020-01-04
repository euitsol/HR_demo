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

                        <form action="{{ route('increment.store.hr') }}" method="post">
                            @csrf

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Remark</th>
                                        <th>Increment</th>
                                    </tr>
                                    @foreach ($incrementsData as $key => $item)
                                        <tr>
                                            <td>#{{ $key + 1 }}</td>
                                            <td>{{ $item->user_name }}</td>
                                            <td>{{ ucfirst($item->remark) }}</td>
                                            <td style="min-width: 150px;">
                                                <div class="input-group">
                                                    <input type="number" name="incrementPercent[{{ $item->user_id }}]" min="0" max="100" placeholder="0.00" class="form-control" step="0.01">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2"> <b>%</b> </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <p class="text-center">
                                @if ($incrementsData->count() > 0)
                                    <input type="submit" value="Forward" class="btn btn-primary">
                                @endif
                            </p>
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