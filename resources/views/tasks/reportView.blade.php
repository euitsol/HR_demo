@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="card">
            <div class="card-header">
                <h3 class="h6 text-uppercase mb-0">{{$task->title}}</h3>
            </div>
            <div class="card-body">
                {!! $task->submit_report !!}
                <hr>
                @if($task->submit_file != null)
                    @if ((pathinfo($task->submit_file, PATHINFO_EXTENSION) == 'jpeg') || (pathinfo($task->submit_file, PATHINFO_EXTENSION) == 'jpg') || (pathinfo($task->submit_file, PATHINFO_EXTENSION) == 'png') ||(pathinfo($task->submit_file, PATHINFO_EXTENSION) == 'gif'))
                        <a href="{{route('download.report.file', ['tid' => $task->id])}}"
                           onclick="return confirm('Are you sure you want to download the image ?')">
                            <img src="{{asset($task->submit_file)}}" alt="Image" style="max-height: 500px;">
                        </a>
                    @else
                        <a href="{{route('download.report.file', ['tid' => $task->id])}}">
                            <i class="fas fa-file-download" style="font-size: 50px; color: #2ecc71;"></i>
                        </a>
                    @endif
                    <hr>
                @endif
                <div class="row">
                    @if((($task->submit_accept)*1) == 0)
                        <a href="{{route('task.accept', ['tid' => $task->id])}}" class="btn btn-success m-3"
                           onclick="return confirm('Are you sure ?')">Accept</a>
                    @endif
                    <a href="{{route('task.reopen', ['tid' => $task->id])}}" class="btn btn-danger m-3"
                       onclick="return confirm('Are you sure ?')">Reopen</a>
                </div>
            </div>
        </div>
    </section>
</div>
@include('includes.bubbly.footer')


</body>
</html>