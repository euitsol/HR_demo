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
        <div class="row">
            <div class="col mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h6 text-uppercase mb-0">Create Task</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('task.store.initial.project')}}" class="form-horizontal" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label">Project Title</label>
                                <div class="col-md-10">
                                    <input type="text" name="projectTitle" placeholder="Project Title"
                                           class="form-control form-control-success {{$errors->has('projectTitle') ? 'has-error' : ''}}"
                                           required>
                                    @if($errors->has('projectTitle'))
                                        <span class="help-block text-danger">{{$errors->first('projectTitle')}}</span>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="form-group row">--}}
                            {{--<label class="col-md-2 form-control-label">Task Title</label>--}}
                            {{--<div class="col-md-10">--}}
                            {{--<input type="text" name="taskTitle" placeholder="Task Title"--}}
                            {{--class="form-control form-control-success" required>--}}
                            {{--@if($errors->has('taskTitle'))--}}
                            {{--<span class="help-block text-danger">{{$errors->first('taskTitle')}}</span>--}}
                            {{--@endif--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group row">--}}
                            {{--<label class="col-md-2 form-control-label">Deadline</label>--}}
                            {{--<div class="col-md-10">--}}
                            {{--<input type="date" name="deadline" class="form-control form-control-success"--}}
                            {{--required>--}}
                            {{--@if($errors->has('deadline'))--}}
                            {{--<span class="help-block text-danger">{{$errors->first('deadline')}}</span>--}}
                            {{--@endif--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group row">--}}
                            {{--<label class="col-md-2 form-control-label">Remark</label>--}}
                            {{--<div class="col-md-10">--}}
                            {{--<textarea class="form-control" name="remark" cols="30" rows="10"--}}
                            {{--required></textarea>--}}
                            {{--@if($errors->has('remark'))--}}
                            {{--<span class="help-block text-danger">{{$errors->first('remark')}}</span>--}}
                            {{--@endif--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<input type="hidden" name="today" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">--}}
                            <div class="form-group row">
                                <div class="col-md-9 ml-auto">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
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