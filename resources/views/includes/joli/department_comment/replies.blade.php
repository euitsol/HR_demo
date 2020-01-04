@foreach($c->replies as $i => $r)
    <div class="item reply-item {{ ($i == 0) ? "reply-item-first" : "" }}">
        <div class="image">
            <img
                    @if($r->user_image != null)
                    src="{{asset($r->user_image)}}"
                    @else
                    src="{{asset('joli/avatar.png')}}"
                    @endif
                    alt="Image">
        </div>
        <div class="text">
            <div class="heading">
                <a href="#" style="text-decoration: none;">{{$r->user_name}}</a>
                <span class="date">
                                                    {{\Carbon\Carbon::createFromTimeStamp(strtotime($r->created_at))->diffForHumans()}}
                    @if((Auth::id()) == (($r->user_id)*1))
                        <a href="{{route('department.reply.edit', ['rid' => $r->id])}}" target="_blank"><i
                                    class="fa fa-pencil"
                                    style="color: #95b75d;"></i></a>
                        <a href="{{route('department.reply.delete', ['rid' => $r->id])}}"
                           onclick="return confirm('Are you sure you want to delete the Reply ?')"><i
                                    class="fa fa-trash-o"
                                    style="color: #E04B4A;"></i></a>
                    @endif
                                                 </span>
            </div>
            {{$r->reply}}
            @if($r->file != null)
                <br>
                @if ((pathinfo($r->file, PATHINFO_EXTENSION) == 'jpeg') || (pathinfo($r->file, PATHINFO_EXTENSION) == 'jpg') || (pathinfo($r->file, PATHINFO_EXTENSION) == 'png') ||(pathinfo($r->file, PATHINFO_EXTENSION) == 'gif'))
                    <a href="{{route('download.department.reply.file', ['rid' => $r->id])}}"
                       onclick="return confirm('Are you sure you want to download the image ?')">
                        <img src="{{asset($r->file)}}" alt="Image"
                             class="comment-img">
                    </a>
                @else
                    <a href="{{route('download.department.reply.file', ['rid' => $r->id])}}">
                        <i class="glyphicon glyphicon-cloud-download"></i>
                    </a>
                @endif
            @endif
        </div>
    </div>
@endforeach