@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        @if(session('CommentCreateSuccess'))
            <div class="alert alert-success text-center">
                {{session('CommentCreateSuccess')}}
            </div>
        @elseif(session('ReplyCreateSuccess'))
            <div class="alert alert-success text-center">
                {{session('ReplyCreateSuccess')}}
            </div>
        @elseif(session('TaskSubmitSuccess'))
            <div class="alert alert-success text-center">
                {{session('TaskSubmitSuccess')}}
            </div>
        @elseif(session('CommentUpdateSuccess'))
            <div class="alert alert-success text-center">
                {{session('CommentUpdateSuccess')}}
            </div>
        @elseif(session('ReplyUpdateSuccess'))
            <div class="alert alert-success text-center">
                {{session('ReplyUpdateSuccess')}}
            </div>
        @elseif(session('ReplyDeleteSuccess'))
            <div class="alert alert-success text-center">
                {{session('ReplyDeleteSuccess')}}
            </div>
        @elseif(session('CommentDeleteSuccess'))
            <div class="alert alert-success text-center">
                {{session('CommentDeleteSuccess')}}
            </div>
        @endif
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
                            @if((($department->id)*1) == (($did)*1))
                                <a href="#" class="btn btn-outline-success disabled">{{$department->title}}</a>
                            @else
                                <a href="{{route('department.details.employee', ['did' => $department->id, 'pid' => $project->id])}}"
                                   class="btn btn-outline-primary">{{$department->title}}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="m-5"></div>

                @include('includes.taskDetailsTableEmployee')

            </div>
        </div>
    </section>


    <section @if(count($comments) > 0) class="py-5" @endif>
        @foreach($comments as $c)
            {{--Comment Section Start--}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img
                                    @if($c->user_image != null)
                                    src="{{asset($c->user_image)}}"
                                    @else
                                    src="{{asset('bubbly/img/avatar.png')}}"
                                    @endif
                                    class="img rounded-circle img-fluid" style="max-height: 110px;"/>
                            <br>
                        </div>
                        <div class="col-md-10">
                            <div>
                                {{--Link to user profile--}}
                                {{--///////////////////////////////////////////////////////////////////////////////--}}
                                <a class="float-left" href="#"><strong>
                                        {{$c->user_name}}
                                    </strong></a><br>
                                {{--                            <p class="text-secondary">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$c->created_at)->format('jS F, Y')}}</p>--}}
                                <span class="text-secondary">{{\Carbon\Carbon::createFromTimeStamp(strtotime($c->created_at))->diffForHumans()}}</span>

                            </div>
                            <div class="clearfix"></div>
                            <p>{{$c->comment}}</p>
                            @if($c->file != null)
                                @if ((pathinfo($c->file, PATHINFO_EXTENSION) == 'jpeg') || (pathinfo($c->file, PATHINFO_EXTENSION) == 'jpg') || (pathinfo($c->file, PATHINFO_EXTENSION) == 'png') ||(pathinfo($c->file, PATHINFO_EXTENSION) == 'gif'))
                                    <a href="{{route('download.comment.file', ['cid' => $c->id])}}"
                                       onclick="return confirm('Are you sure you want to download the image ?')">
                                        <img src="{{asset($c->file)}}" alt="Image" style="max-height: 500px;">
                                    </a>
                                @else
                                    <a href="{{route('download.comment.file', ['cid' => $c->id])}}"><i
                                                class="fas fa-file-download"
                                                style="font-size: 50px; color: #2ecc71;"></i></a>
                                @endif
                            @endif
                            <p class="mt-2">
                                @if((Auth::id()) == (($c->user_id)*1))
                                    <a href="{{route('comment.edit', ['cid' => $c->id, 'did' => $did, 'pid' => $project->id])}}"
                                       class="btn btn-sm btn-dark">Edit</a>
                                    <a href="{{route('comment.delete', ['cid' => $c->id, 'did' => $did, 'pid' => $project->id])}}"
                                       class="btn btn-sm btn-danger" title="Delete Comment"
                                       onclick="return confirm('Are you sure you want to delete this Comment ?')">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                @endif
                                <a href="{{route('reply.create', ['cid' => $c->id, 'did' => $did, 'pid' => $project->id])}}"
                                   class="float-right btn btn-outline-primary ml-2">
                                    <i class="fa fa-reply"></i> Reply
                                </a>
                            </p>
                        </div>
                    </div>


                    {{--Reply Section--}}
                    @foreach($replies as $r)
                        @if((($r->comment_id)*1) == (($c->id)*1) )
                            <div class="card card-inner ml-5">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img
                                                    @if($r->user_image != null)
                                                    src="{{asset($r->user_image)}}"
                                                    @else
                                                    src="{{asset('bubbly/img/avatar.png')}}"
                                                    @endif
                                                    class="img rounded-circle img-fluid"
                                                    style="max-height: 80px;float: right;"/>
                                            <br>
                                        </div>
                                        <div class="col-md-10">
                                            <p>
                                                {{--Link to user profile--}}
                                                {{--///////////////////////////////////////////////////////////////////////////////--}}
                                                <a class="float-left" href="#"><strong>
                                                        {{$r->user_name}}
                                                    </strong></a><br>
                                                {{--                                            <p class="text-secondary">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$c->created_at)->format('jS F, Y')}}</p>--}}
                                                <span class="text-secondary">{{\Carbon\Carbon::createFromTimeStamp(strtotime($r->created_at))->diffForHumans()}}</span>
                                            </p>
                                            <div class="clearfix"></div>
                                            <p>{{$r->reply}}</p>
                                            @if($r->file != null)
                                                @if ((pathinfo($r->file, PATHINFO_EXTENSION) == 'jpeg') || (pathinfo($r->file, PATHINFO_EXTENSION) == 'jpg') || (pathinfo($r->file, PATHINFO_EXTENSION) == 'png') ||(pathinfo($r->file, PATHINFO_EXTENSION) == 'gif'))
                                                    <a href="{{route('download.reply.file', ['rid' => $r->id])}}"
                                                       onclick="return confirm('Are you sure you want to download the image ?')">
                                                        <img src="{{asset($r->file)}}" alt="Image"
                                                             style="max-height: 500px;">
                                                    </a>
                                                @else
                                                    <a href="{{route('download.reply.file', ['rid' => $r->id])}}">
                                                        <i class="fas fa-file-download"
                                                           style="font-size: 50px; color: #2ecc71;"></i>
                                                    </a>
                                                @endif
                                            @endif
                                            <p class="mt-2">
                                                @if((Auth::id()) == (($r->user_id)*1))
                                                    <a href="{{route('reply.edit', ['rid' => $r->id, 'cid' => $c->id, 'did' => $did, 'pid' => $project->id])}}"
                                                       class="btn btn-sm btn-outline-dark">Edit</a>
                                                    <a href="{{route('reply.delete', ['rid' => $r->id, 'did' => $did, 'pid' => $project->id])}}"
                                                       class="btn btn-sm btn-outline-danger" title="Delete Reply"
                                                       onclick="return confirm('Are you sure you want to delete this Reply ?')">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    {{--Reply Section End--}}
                </div>
            </div>
            <br>
            {{--Comment Section End--}}
        @endforeach
    </section>

    <section class="py-5">
        <div class="card">
            <div class="card-header">
                <h3 class="h6 text-uppercase mb-0">Add Comment</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('comment.store', ['did' =>$did, 'pid' => $project->id])}}"
                              class="form-horizontal"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label">Comment</label>
                                <div class="col-md-10">
                                    <textarea class="form-control {{$errors->has('comment') ? 'has-error' : ''}}"
                                              name="comment" cols="30" rows="2"
                                              required></textarea>
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
                                    <button type="submit" class="btn btn-primary">Post Comment</button>
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