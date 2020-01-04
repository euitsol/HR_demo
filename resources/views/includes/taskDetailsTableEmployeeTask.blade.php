<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">Task</th>
                <th scope="col">Dependencies</th>
                <th scope="col">Assigned Users</th>
                <th scope="col">Remark</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $checkD = 0; $checkSubmit = 0; $checkDependency = 0; @endphp
            <tr>
                <td>
                    <a href="{{route('task.view.employee', ['tid' => $task->id])}}"
                       style="text-decoration: none;">{{$task->title}}</a>
                </td>
                <td>
                    @foreach($tasks as $tt)
                        @if($task->id != $tt->id)
                            @if(count($dependencies) > 0)
                                @foreach($dependencies as $d)
                                    @if(((($d->task_id)*1) == (($task->id)*1)) && ((($d->dependency)*1) == (($tt->id)*1)))
                                        [
                                        <span style="color: #c23616;">{{$tt->title}}</span>
                                        ]
                                        @php $checkD = 1; @endphp
                                        @if((($tt->submit)*1) == 0)
                                            @php $checkDependency = 1; @endphp
                                        @endif
                                        @break
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @endforeach
                    @if($checkD == 0)
                        _
                    @endif
                </td>
                <td>
                    {{--All assigned Users--}}
                    @foreach($users as $u)
                        @foreach($assigns as $assign)
                            @if((($assign->user_id)*1) == (($u->id)*1) && (($assign->task_id)*1) == (($task->id)*1))
                                [
                                <span style="color: #40407a;">{{$u->name}}</span>
                                ]
                            @endif
                            @if((($assign->user_id)*1) == ((Auth::id())*1) && (($assign->task_id)*1) == (($task->id)*1))
                                @php $checkSubmit = 1; @endphp
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td>{{$task->remark}}</td>
                <td>
                    @if((($task->submit)*1) == 1)
                        @if((($task->submit_accept)*1) == 1)
                            <strong>Approved</strong>
                        @else
                            <i>Pending</i>
                        @endif
                    @else
                        _
                    @endif
                </td>
                <td>
                    @if($checkSubmit == 1 && $checkDependency == 0)
                        @if((($task->submit)*1) == 0)
                            <a href="{{route('task.submit.view', ['tid' => $task->id, 'did' => $task->department_id, 'pid' => $project->id])}}"
                               class="btn btn-sm btn-outline-success">Submit</a>
                        @else
                            @if((($task->submit_accept)*1) == 0)
                                <a href="{{route('task.submit.view', ['tid' => $task->id, 'did' => $task->department_id, 'pid' => $project->id])}}"
                                   class="btn btn-sm btn-outline-warning">Resubmit</a>
                            @elseif((($task->submit_accept)*1) == 1)
                                <a href="{{route('task.submit.view', ['tid' => $task->id, 'did' => $task->department_id, 'pid' => $project->id])}}"
                                   class="btn btn-sm btn-outline-secondary">Resubmit</a>
                            @endif
                        @endif
                    @else
                        <a href="#" class="btn btn-sm btn-outline-success disabled">X</a>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>