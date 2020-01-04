@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="card">
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
                                @if((($department->id)*1) == (($task->department_id)*1))
                                    <a href="{{route('department.details.employee', ['did' => $department->id, 'pid' => $project->id])}}"
                                       class="btn btn-outline-success">{{$department->title}}</a>
                                @else
                                    <a href="{{route('department.details.employee', ['did' => $department->id, 'pid' => $project->id])}}"
                                       class="btn btn-outline-primary">{{$department->title}}</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="m-5"></div>

                    {{--Task Table--}}
                    @include('includes.taskDetailsTableEmployeeTask')

                </div>
            </div>
        </div>
    </section>


    <section class="py-5">
        <div class="card">
            <div class="card">
                <div class="card-header">
                    <h3 class="h6 text-uppercase mb-0">Edit Comment</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('commentt.update', ['cid' => $comment->id])}}"
                                  class="form-horizontal"
                                  method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label">Comment</label>
                                    <div class="col-md-10">
                                    <textarea class="form-control {{$errors->has('comment') ? 'has-error' : ''}}"
                                              name="comment" cols="30" rows="5"
                                              required>{{$comment->commentt}}</textarea>
                                        @if($errors->has('comment'))
                                            <span class="help-block text-danger">{{$errors->first('comment')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label">Upload</label>
                                    <div class="col-md-10">
                                        <input type="file" class="form-control-file" name="file">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <button type="submit" class="btn btn-primary">Update Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('includes.bubbly.footer')


</body>
</html>