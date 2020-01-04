@extends('layouts.joli')
@section('title', 'Role Edit')
@section('breadcrumb')
    @php
        $menuU = Storage::disk('local')->get('menu');
        $menu = json_decode($menuU);
    @endphp
    <ul class="breadcrumb">
        <li>{{$menu[1]->display_name}}</li>
        <li><a href="{{route('role')}}">{{$menu[3]->display_name}}</a></li>
        <li class="active">Edit</li>
    </ul>
@endsection
@section('pageTitle', 'Role Edit')
@section('content')
    <div class="row mb-5">
        @if(session('unsuccess'))
            <div class="alert alert-danger text-center">
                {{session('unsuccess')}}
            </div>
        @elseif(session('canNoteDelete'))
            <div class="alert alert-danger text-center">
                {{session('canNoteDelete')}}
            </div>
        @elseif(session('DeleteSuccess'))
            <div class="alert alert-success text-center">
                {{session('DeleteSuccess')}}
            </div>
        @endif
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ROLE Edit</h3>
                </div>
                {{--     Form Start              --}}
                <form action="{{route('role.update', ['rid' => $redit->id])}}" class="form-horizontal" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" value="{{$redit->name}}" name="name" required
                                           class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('name'))
                                    <span class="help-block text-danger">{{$errors->first('name')}}</span>
                                @endif
                                <small class="help-block">Duplicate entry is not allowed*</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Display Name</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" value="{{$redit->display_name}}" name="displayName" required
                                           class="form-control {{$errors->has('displayName') ? 'is-invalid' : ''}}">
                                </div>
                                @if($errors->has('displayName'))
                                    <span class="help-block text-danger">{{$errors->first('displayName')}}</span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        {{--      Permissions will go here              --}}
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Menu Permissions</label>
                            <br>
                            <div class="col-md-6 col-xs-12">
                                @if($errors->has('permission'))
                                    <span class="help-block text-danger">Please Select at least one permission.</span>
                                @endif
                                @foreach($menus as $m)
                                    @if((($m->id * 1) != 25) && (($m->id * 1) != 26) && (($m->id * 1) != 32) && (($m->id * 1) != 44) && (($m->id * 1) != 46) && (($m->id * 1) != 48) && (($m->id * 1) != 50) && (($m->id * 1) != 51) && (($m->id * 1) != 54))
                                        @if($m->permission == 0)
                                            <div class="form-check form-check-inline d-block permission-0"
                                                 @if($m->level == 0)
                                                 style="margin-left: 10px;"
                                                 @elseif($m->level == 1)
                                                 style="margin-left: 40px;"
                                                    @endif
                                            >
                                                <input class="form-check-input" type="checkbox" {{ (($m->id * 1) == 1) ? 'checked disabled' : '' }} id="{{$m->name}}">
                                                <label class="text-secondary" for="{{$m->name}}">{{$m->display_name}}</label>
                                            </div>
                                        @elseif($m->permission == 1)
                                            <div class="form-check form-check-inline d-block {{ ((($m->id * 1) != 17) && (($m->id * 1) != 49)) ? 'permission-1' : 'stopP' }}"
                                                 @if($m->level == 0)
                                                 style="margin-left: 10px;"
                                                 @elseif($m->level == 1)
                                                 style="margin-left: 40px;"
                                                    @endif
                                            >
                                                <input class="form-check-input" type="checkbox" value="{{$m->id}}"
                                                       name="permission[]" id="{{$m->name}}"
                                                       @foreach($pedits as $pe)
                                                       @if(($pe->id * 1) == ($m->pid * 1))
                                                       checked
                                                        @break
                                                        @endif
                                                        @endforeach
                                                >
                                                <label for="{{$m->name}}">{{$m->display_name}}</label>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
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
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ALL ROLES</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Display Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $i => $r)
                            @if($i > 2)
                                <tr>
                                    <th scope="row">{{$i - 2}}</th>
                                    <td>{{$r->display_name}}</td>
                                    <td>
                                        @if($r->id != $redit->id)
                                            <a href="{{route('role.edit', ['rid' => $r->id])}}"
                                               class="btn btn-sm btn-success m-1"><span class="fa fa-pencil"></span></a>
                                            <a href="{{route('role.delete', ['rid' => $r->id])}}"
                                               class="btn btn-sm btn-danger m-1"
                                               onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i></a>
                                        @else
                                            <a href="{{route('role.edit', ['rid' => $r->id])}}"
                                               class="btn btn-sm btn-success m-1 disabled"><span
                                                        class="fa fa-pencil"></span></a>
                                            <a href="#" class="btn btn-sm btn-danger m-1 disabled"><i
                                                        class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- START THIS PAGE PLUGINS-->
    {{--    <script type='text/javascript' src="{{asset('joli/js/plugins/icheck/icheck.min.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/demo_tables.js')}}"></script>--}}
    {{--    <script type='text/javascript' src="{{asset('joli/js/plugins/icheck/icheck.min.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('joli/js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>--}}
    <!-- END THIS PAGE PLUGINS-->
    <script>
        $(function () {
            $('.form-check-input').click((e) => {
                var target_div = $(e.target).closest('.form-check');
                if (target_div.hasClass('permission-0')) {
                    target_div = $(target_div).next();
                    while (target_div.length > 0 && !target_div.hasClass('permission-0')) {
                        if (!target_div.hasClass('stopP')) {
                            target_div.find('input').prop("checked", e.target.checked);
                        }
                        target_div = target_div.next();
                    }
                } else if (target_div.hasClass('permission-1')) {
                    var checkbox_arr = [e.target.checked];
                    target_div = $(target_div).next();
                    while (target_div.length > 0 && !target_div.hasClass('permission-0')) {
                        checkbox_arr.push(target_div.find('input').is(':checked'));
                        target_div = target_div.next();
                    }
                    var target_div = $(e.target).closest('.form-check').prev();
                    while (target_div.length > 0 && !target_div.hasClass('permission-0')) {
                        checkbox_arr.push(target_div.find('input').is(':checked'));
                        target_div = target_div.prev();
                    }
                    var checked_arr = checkbox_arr.filter(x => x);
                    target_div.find('input').prop("checked", checked_arr.length > 0);
                }
            });
        });
    </script>
@endsection


{{--@include('includes.bubbly.header')--}}
{{--@include('includes.bubbly.sidebar')--}}
{{--<div class="container-fluid px-xl-5">--}}
{{--    <section class="py-5">--}}
{{--        @if(session('unsuccess'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('unsuccess')}}--}}
{{--            </div>--}}
{{--        @elseif(session('canNoteDelete'))--}}
{{--            <div class="alert alert-danger text-center">--}}
{{--                {{session('canNoteDelete')}}--}}
{{--            </div>--}}
{{--        @elseif(session('DeleteSuccess'))--}}
{{--            <div class="alert alert-success text-center">--}}
{{--                {{session('DeleteSuccess')}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="h6 text-uppercase mb-0">Role Edit</h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="{{route('role.update', ['rid' => $redit->id])}}" class="form-horizontal"--}}
{{--                              method="post">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Name</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    @if($errors->has('name'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('name')}}</span>--}}
{{--                                    @endif--}}
{{--                                    <input type="text" value="{{$redit->name}}" name="name"--}}
{{--                                           class="form-control form-control-success {{$errors->has('name') ? 'is-invalid' : ''}}"--}}
{{--                                           required>--}}
{{--                                    <small class="form-text text-muted ml-3">Duplicate entry is not allowed*--}}
{{--                                    </small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-md-3 form-control-label">Display Name</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input type="text" value="{{$redit->display_name}}" name="displayName"--}}
{{--                                           class="form-control form-control-success {{$errors->has('displayName') ? 'is-invalid' : ''}}"--}}
{{--                                           required>--}}
{{--                                    @if($errors->has('displayName'))--}}
{{--                                        <span class="help-block text-danger">{{$errors->first('displayName')}}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        <hr>--}}
{{--                        <label class="col-md-3 form-control-label">Permissions</label>--}}
{{--                        @if($errors->has('permission'))--}}
{{--                            <span class="help-block text-danger">Please Select at least one permission.</span>--}}
{{--                        @endif--}}
{{--                        <div class="col">--}}
{{--                            @foreach($menus as $m)--}}
{{--                                @if($m->permission == 0)--}}
{{--                                    <div class="form-check form-check-inline"--}}
{{--                                         @if($m->level == 0)--}}
{{--                                         style="margin-left: 10px;"--}}
{{--                                         @elseif($m->level == 1)--}}
{{--                                         style="margin-left: 40px;"--}}
{{--                                         @elseif($m->level == 2)--}}
{{--                                         style="margin-left: 70px;"--}}
{{--                                         @elseif($m->level == 3)--}}
{{--                                         style="margin-left: 100px;"--}}
{{--                                         @elseif($m->level == 4)--}}
{{--                                         style="margin-left: 130px;"--}}
{{--                                            @endif--}}
{{--                                    >--}}
{{--                                        <input class="form-check-input" type="checkbox">--}}
{{--                                        <label class="form-check-label text-secondary">{{$m->display_name}}</label>--}}
{{--                                    </div>--}}
{{--                                    <br>--}}
{{--                                @elseif($m->permission == 1)--}}
{{--                                    <div class="form-check form-check-inline"--}}
{{--                                         @if($m->level == 0)--}}
{{--                                         style="margin-left: 10px;"--}}
{{--                                         @elseif($m->level == 1)--}}
{{--                                         style="margin-left: 40px;"--}}
{{--                                         @elseif($m->level == 2)--}}
{{--                                         style="margin-left: 70px;"--}}
{{--                                         @elseif($m->level == 3)--}}
{{--                                         style="margin-left: 100px;"--}}
{{--                                         @elseif($m->level == 4)--}}
{{--                                         style="margin-left: 130px;"--}}
{{--                                            @endif--}}
{{--                                    >--}}
{{--                                        <input class="form-check-input" type="checkbox" value="{{$m->id}}"--}}
{{--                                               name="permission[]"--}}
{{--                                               @foreach($pedits as $pe)--}}
{{--                                               @if(($pe->id * 1) == ($m->pid * 1))--}}
{{--                                               checked--}}
{{--                                                @break--}}
{{--                                                @endif--}}
{{--                                                @endforeach--}}
{{--                                        >--}}
{{--                                        <label class="form-check-label">{{$m->display_name}}</label>--}}
{{--                                    </div>--}}
{{--                                    <br>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="form-group row">--}}
{{--                            <div class="col">--}}
{{--                                <button type="submit" class="btn btn-primary btn-block">Update</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-4 mb-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h6 class="text-uppercase mb-0">All Roles</h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-striped table-sm card-text">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Role Title</th>--}}
{{--                                <th>Display Name</th>--}}
{{--                                <th class="text-right">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($roles as $i => $r)--}}
{{--                                @if($i > 2)--}}
{{--                                    <tr>--}}
{{--                                        <th scope="row">{{$i - 2}}</th>--}}
{{--                                        <td>{{$r->name}}</td>--}}
{{--                                        <td>{{$r->display_name}}</td>--}}
{{--                                        <td class="text-right">--}}
{{--                                            @if($r->id != $redit->id)--}}
{{--                                                <a href="{{route('role.edit', ['rid' => $r->id])}}"--}}
{{--                                                   class="btn btn-sm btn-success m-1">Edit</a>--}}
{{--                                                <a href="{{route('role.delete', ['rid' => $r->id])}}"--}}
{{--                                                   class="btn btn-sm btn-danger m-1"--}}
{{--                                                   onclick="return confirm('Are you sure ?')">Delete</a>--}}
{{--                                            @else--}}
{{--                                                <a href="{{route('role.edit', ['rid' => $r->id])}}"--}}
{{--                                                   class="btn btn-sm btn-success m-1 disabled">Edit</a>--}}
{{--                                                <a href="#" class="btn btn-sm btn-danger m-1 disabled">Delete</a>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--</div>--}}
{{--@include('includes.bubbly.footer')--}}
{{--</body>--}}
{{--</html>--}}