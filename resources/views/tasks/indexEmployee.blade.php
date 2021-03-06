@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        {{--@if(session('ApproveSuccess'))--}}
        {{--<div class="alert alert-success text-center">--}}
        {{--{{session('ApproveSuccess')}}--}}
        {{--</div>--}}
        {{--@elseif(session('NoticeUnpublishSuccess'))--}}
        {{--<div class="alert alert-success text-center">--}}
        {{--{{session('NoticeUnpublishSuccess')}}--}}
        {{--</div>--}}
        {{--@endif--}}
        <div class="card">
            <div class="card">
                <div class="card-header">
                    <h3 class="h6 text-uppercase mb-0">Project Lists</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($projects as $p)
                            <div class="col-md-2 mb-2">
                                <a href="{{route('Project.View.Employee', ['pid' => $p->id])}}" class="btn btn-sm btn-outline-secondary m-1">{{$p->title}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


    </section>

</div>
@include('includes.bubbly.footer')


</body>
</html>