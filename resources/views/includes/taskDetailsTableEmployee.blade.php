<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Task</th>
                <th scope="col">Dependencies</th>
                <th scope="col">Assigned Users</th>
                <th scope="col">Remark</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if(count($tasks) > 0)
                @php $i = 1; @endphp
                @foreach($tasks as $t)
                    @php $checkD = 0; $checkSubmit = 0; $checkDependency = 0; @endphp
                    <tr>
                        <th scope="row">{{$i}}</th>
                        <td>
                            <a href="{{route('task.view.employee', ['tid' => $t->id])}}"
                               style="text-decoration: none;">{{$t->title}}</a>
                        </td>
                        <td>
                            @foreach($tasks as $tt)
                                @if($t->id != $tt->id)
                                    @foreach($dependencies as $ds)
                                        @if(count($ds) > 0)
                                            @foreach($ds as $d)
                                                @if(((($d->task_id)*1) == (($t->id)*1)) && ((($d->dependency)*1) == (($tt->id)*1)))
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
                                    @endforeach
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
                                    @if(count($assign) > 0)
                                        @foreach($assign as $aa)
                                            {{--$assign here is only for a single task so we can break--}}
                                            @if((($aa->user_id)*1) == (($u->id)*1) && (($aa->task_id)*1) == (($t->id)*1))
                                                [
                                                <span style="color: #40407a;">{{$u->name}}</span>
                                                ]
                                            @endif
                                            {{--Better check submittion here--}}
                                            @if((($aa->user_id)*1) == ((Auth::id())*1) && (($aa->task_id)*1) == (($t->id)*1))
                                                @php $checkSubmit = 1; @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                        </td>
                        <td>{{$t->remark}}</td>
                        <td>
                            @if((($t->submit)*1) == 1)
                                @if((($t->submit_accept)*1) == 1)
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
                                @if((($t->submit)*1) == 0)
                                    <a href="{{route('task.submit.view', ['tid' => $t->id, 'did' => $did, 'pid' => $project->id])}}"
                                       class="btn btn-sm btn-outline-success">Submit</a>
                                @else
                                    @if((($t->submit_accept)*1) == 0)
                                        <a href="{{route('task.submit.view', ['tid' => $t->id, 'did' => $did, 'pid' => $project->id])}}"
                                           class="btn btn-sm btn-outline-warning">Resubmit</a>
                                    @elseif((($t->submit_accept)*1) == 1)
                                        <a href="{{route('task.submit.view', ['tid' => $t->id, 'did' => $did, 'pid' => $project->id])}}"
                                           class="btn btn-sm btn-outline-secondary">Resubmit</a>
                                    @endif
                                @endif
                            @else
                                <a href="#" class="btn btn-sm btn-outline-success disabled">X</a>
                            @endif
                        </td>
                    </tr>
                    @php $i++; @endphp
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>