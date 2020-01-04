@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="card">
            <div class="card-header">
                <h3 class="h6 text-uppercase mb-0">


                    {{--anchor tag only for department head ////////////////////////////////////////////////////////////--}}
                    <a href="{{route('Project.View', ['pid' => $project->id])}}"
                       style="text-decoration: none;">{{$project->title}}</a>
                    {{--Else only heading--}}
                    {{--{{$project->title}}--}}


                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($departments as $department)
                        <div class="col-md-3 col-sm-6">
                            <a href="{{route('department.details.employee', ['did' => $department->id, 'pid' => $project->id])}}" class="btn btn-outline-primary">{{$department->title}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@include('includes.bubbly.footer')


</body>
</html>