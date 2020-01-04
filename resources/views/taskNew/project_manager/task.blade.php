@extends('layouts.joli')
@section('title', 'Loan Type')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[33]->display_name}}</li>
        <li class="active">{{$menu[38]->display_name}}</li>
    </ul>
@endsection
@section('pageTitle', 'Loan Type')
@section('content')
    <div class="row mb-5">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        @elseif(session('unsuccess'))
            <div class="alert alert-danger text-center">
                {{session('unsuccess')}}
            </div>
        @endif
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Task Detail</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('task.detail.update', ['tid' => $task->id])}}" class="form-horizontal"
                      method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" value="{{$task->title}}" name="title" required
                                           class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('title'))
                                    <span class="help-block text-danger">{{$errors->first('title')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Deadline</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input type="date" value="{{$task->deadline}}" name="deadline" required
                                           class="form-control {{$errors->has('deadline') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('deadline'))
                                    <span class="help-block text-danger">{{$errors->first('deadline')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Remark</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <textarea class="form-control {{$errors->has('remark') ? 'is-invalid' : ''}}"
                                              rows="5" name="remark" required>{{$task->remark}}</textarea>
                                </div>
                                @if($errors->has('remark'))
                                    <span class="help-block text-danger">{{$errors->first('remark')}}</span>
                                @endif
                            </div>
                        </div>
                        {{--      Assigned User  --}}
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Assigned To</label>
                            <div class="col-md-6 col-xs-12">
                                <select multiple="" name="assign[]" id="assign" class="form-control select"
                                        style="display: none !important;" required>
                                    @foreach($users as $u)
                                        <option value="{{$u->id}}" {{(($u->assign * 1) == 1) ? "selected" : ""}}>{{$u->title}}</option>
                                    @endforeach
                                    <div class="btn-group bootstrap-select show-tick form-control select"
                                         style="display: none !important;">
                                        <button type="button" class="btn dropdown-toggle selectpicker btn-default"
                                                data-toggle="dropdown" title="Nothing selected"
                                                aria-expanded="false">
                                            <span class="filter-option pull-left btn-color">Nothing selected</span>&nbsp;
                                            <span class="caret"></span>
                                        </button>
                                        <div class="dropdown-menu open"
                                             style="max-height: 390px; overflow: hidden; min-height: 121px;">
                                            <ul class="dropdown-menu inner selectpicker" role="menu"
                                                style="max-height: 388px; overflow-y: auto; min-height: 119px;">
                                                @foreach($users as $i => $u)
                                                    <li rel="{{$i}}" class="">
                                                        <a tabindex="0" class="" style="">
                                                            <span class="text">{{$u->title}}</span>
                                                            <i class="glyphicon glyphicon-ok icon-ok check-mark"></i>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </select>

                            </div>
                        </div>


                        {{--      Task Priority          --}}


                    </div>
                    <div class="panel-footer">
                        <a title="refresh" class="btn btn-default back" data-link="{{route('back')}}"><span
                                    class="fa fa-refresh"></span></a>
                        <button class="btn btn-primary pull-right">Update</button>
                    </div>
                </form>
                {{--     Form end               --}}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Task detail</h3>
                </div>
                <div class="panel-body">
                    {{--       If Submitted then show submit report                 --}}

                    {{--        Accept / Reopen option            --}}


                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>

@endsection