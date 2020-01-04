@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        @if(session('TaskCreateSuccess'))
            <div class="alert alert-success text-center">
                {{session('TaskCreateSuccess')}}
            </div>
        @elseif(session('DepartmentCreateSuccess'))
            <div class="alert alert-success text-center">
                {{session('DepartmentCreateSuccess')}}
            </div>
        @elseif(session('DepartmentUpdateSuccess'))
            <div class="alert alert-success text-center">
                {{session('DepartmentUpdateSuccess')}}
            </div>
        @elseif(session('TaskReopenSuccess'))
            <div class="alert alert-info text-center">
                {{session('TaskReopenSuccess')}}
            </div>
        @elseif(session('TaskAcceptSuccess'))
            <div class="alert alert-success text-center">
                {{session('TaskAcceptSuccess')}}
            </div>
        @endif
        <div class="row">
            <div class="col mb-5">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('update.project.title', ['pid' => $project->id])}}"
                              class="form-horizontal" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="col-md-2 form-control-label"><strong>Project
                                                Title</strong></label>
                                        <div class="col-md-10">
                                            <input type="text" name="projectTitle" placeholder="Project Title"
                                                   value="{{$project->title}}" id="projectTitle"
                                                   class="form-control form-control-success {{$errors->has('projectTitle') ? 'has-error' : ''}}">
                                            @if($errors->has('projectTitle'))
                                                <span class="help-block text-danger">{{$errors->first('projectTitle')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                    id="projectTitleSubmit" disabled>Update Project Title
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="m-5"></div>
                        <hr>
                        @php $i = 1; @endphp
                        @if(count($departments) > 0)
                            @foreach($departments as $d)
                                <hr>
                                <form action="{{route('update.department', ['did' => $d->id, 'pid' => $project->id])}}"
                                      class="form-horizontal department-form"
                                      method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group row">
                                                <label class="col-md-2 form-control-label"><span
                                                            style="color: #fa8231;"># {{$i}} </span><strong>Department
                                                        Title</strong></label>
                                                <div class="col-md-10">
                                                    <input type="text" name="departmentTitle"
                                                           placeholder="Department Title" value="{{$d->title}}"
                                                           class="form-control form-control-success" required>
                                                    @if($errors->has('departmentTitle'))
                                                        <span class="help-block text-danger">{{$errors->first('departmentTitle')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <div class="col-md-9 ml-auto">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                            disabled>Update Department Title
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        {{--Tasks Section Start--}}
                                        @if($errors->has('taskTitle'))
                                            <span class="help-block text-danger">{{$errors->first('taskTitle')}}</span>
                                            <hr>
                                        @endif
                                        @if($errors->has('deadline'))
                                            <span class="help-block text-danger">{{$errors->first('deadline')}}</span>
                                            <hr>
                                        @endif
                                        @if($errors->has('remark'))
                                            <span class="help-block text-danger">{{$errors->first('remark')}}</span>
                                            <hr>
                                        @endif
                                        @if(count($tasks) > 0)
                                            @foreach($tasks as $t)
                                                @if((($t->department_id)*1) == (($d->id)*1))
                                                    @if((($t->submit_accept)*1) == 0)
                                                        <form action="{{route('update.task', ['tid' => $t->id, 'did' => $d->id, 'pid' => $project->id])}}"
                                                              class="task-form form-horizontal" method="post">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="form-group row">
                                                                        <label class="col-md-2 form-control-label">Task
                                                                            Title</label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" name="taskTitle"
                                                                                   placeholder="Task Title"
                                                                                   class="form-control form-control-success"
                                                                                   value="{{$t->title}}"
                                                                                   required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-2 form-control-label">Deadline</label>
                                                                        <div class="col-md-10">
                                                                            <input type="date" name="deadline"
                                                                                   value="{{$t->deadline}}"
                                                                                   class="form-control form-control-success"
                                                                                   required>
                                                                        </div>
                                                                    </div>
                                                                    @if(count($tasks) > 1)
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 form-control-label">Dependency</label>
                                                                            <div class="col-md-10">
                                                                                @foreach($tasks as $tt)
                                                                                    <label class="checkbox-inline">
                                                                                        @if($t->id != $tt->id    )
                                                                                            <input type="checkbox"
                                                                                                   name="dependency[]"
                                                                                                   @foreach($dependencies as $dependency)
                                                                                                   @if(count($dependency) > 0)
                                                                                                   @foreach($dependency as $dd)
                                                                                                   @if(((($dd->task_id)*1) == (($t->id)*1)) && ((($dd->dependency)*1) == (($tt->id)*1)))
                                                                                                   checked
                                                                                                   @break
                                                                                                   @endif
                                                                                                   @endforeach
                                                                                                   @endif
                                                                                                   @endforeach
                                                                                                   value="{{$tt->id}}"> {{$tt->title}}
                                                                                        @endif
                                                                                    </label>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    <div class="form-group row">
                                                                        <label class="col-md-2 form-control-label">Assign
                                                                            to</label>
                                                                        <div class="col-md-10">
                                                                            @foreach($users as $u)
                                                                                <label class="checkbox-inline">
                                                                                    <input type="checkbox"
                                                                                           name="assigns[]"
                                                                                           @foreach($assigns as $assign)
                                                                                           @if(count($assign) > 0)
                                                                                           @foreach($assign as $aa)
                                                                                           {{--$assign here is only for a single task so we can break--}}
                                                                                           @if((($aa->user_id)*1) == (($u->id)*1) && (($aa->task_id)*1) == (($t->id)*1))
                                                                                           checked
                                                                                           @break
                                                                                           @endif
                                                                                           @endforeach
                                                                                           @endif
                                                                                           @endforeach
                                                                                           value="{{$u->id}}"> {{$u->name}}
                                                                                </label>
                                                                            @endforeach
                                                                            @if($errors->has('assigns'))
                                                                                <span class="help-block text-danger">Please select at least one Employee.</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-2 form-control-label">Remark</label>
                                                                        <div class="col-md-10">
                                                                        <textarea class="form-control" name="remark"
                                                                                  cols="30" rows="1"
                                                                                  required>{{$t->remark}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="today"
                                                                       value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                                                                <div class="col-md-3">
                                                                    <div class="form-group row">
                                                                        <div class="col-md-9 ml-auto">
                                                                            <button type="submit"
                                                                                    class="btn btn-sm btn-outline-secondary"
                                                                                    disabled>
                                                                                Update {{$t->title}}</button>
                                                                        </div>
                                                                    </div>
                                                                    @if((($t->submit)*1) == 1)
                                                                        <div class="form-group row">
                                                                            <div class="col-md-9 ml-auto">
                                                                                <a href="{{route('view.report', ['tid' => $t->id])}}"
                                                                                   class="btn btn-sm btn-success">View
                                                                                    Report</a>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <div class="form-group row">
                                                                    <label class="col-md-2 form-control-label">Task
                                                                        Title</label>
                                                                    <div class="col-md-10">
                                                                        <input type="text" class="form-control form-control-success" value="{{$t->title}}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group row">
                                                                    <div class="col-md-9 ml-auto">
                                                                        <a href="{{route('view.report', ['tid' => $t->id])}}"
                                                                           class="btn btn-sm btn-outline-success" target="_blank">View
                                                                            Report</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <hr>
                                                @endif
                                            @endforeach
                                        @endif
                                        <hr>
                                        <form action="{{route('store.task', ['did' => $d->id, 'pid' => $project->id])}}"
                                              class="form-horizontal"
                                              method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group row">
                                                        <label class="col-md-2 form-control-label">Task Title</label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="taskTitleT"
                                                                   placeholder="Task Title"
                                                                   id="taskTitle"
                                                                   class="form-control form-control-success"
                                                                   required>
                                                            @if($errors->has('taskTitleT'))
                                                                <span class="help-block text-danger">{{$errors->first('taskTitleT')}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-2 form-control-label">Deadline</label>
                                                        <div class="col-md-10">
                                                            <input type="date" name="taskDeadline"
                                                                   class="form-control form-control-success"
                                                                   id="deadline"
                                                                   required>
                                                            @if($errors->has('taskDeadline'))
                                                                <span class="help-block text-danger">{{$errors->first('taskDeadline')}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if(count($tasks) > 0)
                                                        @php $c = 0; @endphp
                                                        @foreach($tasks as $t)
                                                            @if((($t->department_id)*1) == (($d->id)*1))
                                                                @php $c = 1; @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @if($c == 1)
                                                            <div class="form-group row">
                                                                <label class="col-md-2 form-control-label">Dependency</label>
                                                                <div class="col-md-10">
                                                                    @foreach($tasks as $t)
                                                                        @if((($t->department_id)*1) == (($d->id)*1))
                                                                            <label class="checkbox-inline">
                                                                                <input type="checkbox"
                                                                                       name="dependency[]"
                                                                                       value="{{$t->id}}"> {{$t->title}}
                                                                            </label>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    <div class="form-group row">
                                                        <label class="col-md-2 form-control-label">Assign
                                                            to</label>
                                                        <div class="col-md-10">
                                                            @foreach($users as $u)
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" name="assigns[]"
                                                                           value="{{$u->id}}"> {{$u->name}}
                                                                </label>
                                                            @endforeach
                                                            @if($errors->has('assigns'))
                                                                <span class="help-block text-danger">Please select at least one Employee.</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-2 form-control-label">Remark</label>
                                                        <div class="col-md-10">
                                                        <textarea class="form-control" name="remarkT" cols="30" rows="2"
                                                                  id="remark" required></textarea>
                                                            @if($errors->has('remarkT'))
                                                                <span class="help-block text-danger">{{$errors->first('remarkT')}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="today"
                                                       value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <div class="col-md-9 ml-auto">
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary btn-block">
                                                                Add Task
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        {{--Task Section End--}}
                                    </div>
                                </div>
                                <hr>
                                <div class="m-5"></div>
                                <hr>
                                @php $i++; @endphp
                            @endforeach
                        @endif
                        <form action="{{route('store.department', ['pid' => $project->id])}}" class="form-horizontal"
                              method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label"><strong>Department Title</strong></label>
                                <div class="col-md-10">
                                    <input type="text" name="departmentTitle" placeholder="Department Title"
                                           class="form-control form-control-success" required>
                                    @if($errors->has('departmentTitle'))
                                        <span class="help-block text-danger">{{$errors->first('departmentTitle')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-9 ml-auto">
                                    <button type="submit" class="btn btn-primary">Add New Department</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="m-5"></div>
                        <hr>
                        <a href="{{route('project.delete', ['pid' => $project->id])}}" class="btn btn-block btn-danger" onclick="return confirm('Everything related related to this project will be deleted. Are you sure ???')">Delete Project "{{$project->title}}"</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@include('includes.bubbly.footer')

<script>
    $(function () {
        $("#projectTitle").change((e) => {
            var check = $("#projectTitle").val();
            if (check != '') {
                document.getElementById("projectTitleSubmit").disabled = false;
            } else {
                document.getElementById("projectTitleSubmit").disabled = true;
            }
        });
        $('.task-form').each((i, e) => {
            $(e).find('input:not(:hidden), textarea').change((f) => {
                var taskForm = $(f.target).closest('.task-form');
                var validFields = [];
                var fields = taskForm.find('input:not(:hidden), textarea');
                fields.each((j, g) => {
                    validFields.push(g.value != "");
                });
                taskForm.find('button').prop("disabled", validFields.includes(false));
            });
        });
        $('.department-form').each((i, e) => {
            $(e).find('input:not(:hidden)').change((f) => {
                var departmentForm = $(f.target).closest('.department-form');
                var validFields2 = [];
                var fields2 = departmentForm.find('input:not(:hidden)');
                fields2.each((j, g) => {
                    validFields2.push(g.value != "");
                });
                departmentForm.find('button').prop("disabled", validFields2.includes(false));
            });
        });
    });
</script>


</body>
</html>