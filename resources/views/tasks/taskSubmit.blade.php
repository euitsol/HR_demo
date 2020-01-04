@include('includes.bubbly.header')
@include('includes.bubbly.sidebar')
<div class="container-fluid px-xl-5">
    <section class="py-5">
        <div class="card">
            <div class="card-header">
                <h3 class="h6 text-uppercase mb-0">{{$task->title}}</h3>
            </div>
            <form action="{{route('task.submit.store', ['tid' => $task->id, 'did' => $did, 'pid' => $pid])}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col">
                            <textarea name="reportDescription"
                                      class="{{$errors->has('reportDescription') ? 'has-error' : ''}}" cols="30"
                                      rows="10" required>{!! $task->submit_report !!}</textarea>
                            @if($errors->has('reportDescription'))
                                <span class="help-block text-danger">{{$errors->first('reportDescription')}}</span>
                            @endif
                            <script>
                                CKEDITOR.replace('reportDescription');
                            </script>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label>Attach File</label>
                        <input type="file" class="form-control-file" name="file">
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@include('includes.bubbly.footer')


</body>
</html>