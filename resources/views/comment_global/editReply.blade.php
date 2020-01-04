@extends('layouts.joli')
@section('title', 'Global Communication')
@section('style')
    <style>
        .comment-img {
            max-height: 100px;
            max-width: 500px;
            margin-left: 55px;
        }

        .messages.messages-img .item .image img {
            margin-top: 3px;
        }

        .reply-item {
            margin-bottom: 1px !important;
        }

        .reply-item-first {
            margin-top: 12px;
        }
    </style>
@endsection
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[39]->display_name}}</li>
        <li><a href="{{route('commentg')}}">{{$menu[40]->display_name}}</a></li>
        <li>Reply</li>
        <li class="active">Edit</li>
    </ul>
@endsection
@section('pageTitle', 'Global Messaging')
@section('content')
    <div class="row mb-5">
        <div class="col-md-10 offset-md-1">
            <div class="content-frame-body content-frame-body-left">
                <div class="panel panel-default push-up-10">
                    <div class="panel-body panel-body-search">
                        <form action="{{route('replyg.update', ['rid' => $reply->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <input type="file" name="file" id="file" style="display: none;">
                                    <button type="button" class="btn btn-default" id="file-btn"><span
                                                class="fa fa-camera"></span></button>
                                </div>
                                <input type="text" class="form-control {{$errors->has('reply') ? 'is-invalid' : ''}}"
                                       name="reply" value="{{$reply->replyg}}" required>
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Update Reply</button>
                                </div>
                            </div>
                            @if($errors->has('reply'))
                                <span class="help-block text-danger"
                                      style="margin-left: 100px;">{{$errors->first('reply')}}</span>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    <script>
        $(function () {
            $("#file-btn").on('click', e => {
                $("#file").click();
            });
        });
    </script>
    <!-- END THIS PAGE PLUGINS-->
@endsection


{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        <div class="row">--}}
{{--            <div class="col">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Edit Reply</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('replyg.update', ['rid' => $reply->id])}}" class="form-horizontal"--}}
{{--                              method="post" enctype="multipart/form-data">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-2 form-control-label">Reply</label>--}}
{{--                                <div class="col-md-10">--}}
{{--                                                <textarea--}}
{{--                                                        class="form-control {{$errors->has('reply') ? 'has-error' : ''}}"--}}
{{--                                                        name="reply" cols="30" rows="2"--}}
{{--                                                        required>{{$reply->replyg}}</textarea>--}}
{{--                                    @if($errors->has('reply'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('reply')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-2 form-control-label">Upload</label>--}}
{{--                                <div class="col-md-10">--}}
{{--                                    <input type="file" class="form-control-file" name="file">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-9 ml-auto">--}}
{{--                                    <button type="submit" class="btn btn-primary">Update Reply</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}