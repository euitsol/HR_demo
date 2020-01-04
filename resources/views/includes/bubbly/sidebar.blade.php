@php
    // $menu = Session::get('menu');
    $menuU = Storage::disk('local')->get('menu');
    $menu = json_decode($menuU);
@endphp
<div class="d-flex align-items-stretch">
    <div id="sidebar" class="sidebar py-3">
        {{--        NEW///////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item">
                <a href="{{route('home')}}" class="sidebar-link text-muted">
                    {{--                    <i class="fas fa-home mr-3 text-gray"></i>--}}
                    <span>{{$menu[0]->display_name}}</span>
                </a>
            </li>
        </ul>
        @permission('permission|role|menu|user_create')
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#acl" aria-expanded="false"
                                             class="sidebar-link text-muted">
                    <span>{{$menu[1]->display_name}}</span></a>
                <div id="acl" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        @permission('permission')
                        <li class="sidebar-list-item"><a href="{{route('permission')}}" class="sidebar-link text-muted">
{{--                                <i class="fas fa-frog mr-3 text-gray"></i>--}}
                                <span>{{$menu[2]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('role')
                        <li class="sidebar-list-item"><a href="{{route('role')}}" class="sidebar-link text-muted">
{{--                                <i class="fas fa-project-diagram mr-3 text-gray"></i>--}}
                                <span>{{$menu[3]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('menu')
                        <li class="sidebar-list-item"><a href="{{route('menu.setup')}}" class="sidebar-link text-muted">
{{--                                <i class="fas fa-bars mr-3 text-gray"></i>--}}
                                <span>{{$menu[4]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('user_create')
                        <li class="sidebar-list-item"><a href="{{route('users')}}" class="sidebar-link text-muted">
{{--                                <i class="fas fa-user-plus mr-3 text-gray"></i>--}}
                                <span>{{$menu[5]->display_name}}</span></a>
                        </li>
                        @endpermission
                    </ul>
                </div>
            </li>
        </ul>
        @endpermission
        @permission('office_setup|branch_setup|pay_scale|tax|designation|employee_type|working_hour|religion|leave')
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#officeManagement"
                                             aria-expanded="false" class="sidebar-link text-muted">
                    <span>{{$menu[6]->display_name}}</span></a>
                <div id="officeManagement" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        @permission('office_setup')
                        <li class="sidebar-list-item"><a href="{{route('office.setup')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[7]->display_name}}</span></a></li>
                        @endpermission
                        @permission('branch_setup')
                        <li class="sidebar-list-item"><a href="{{route('branch.setup')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[8]->display_name}}</span></a></li>
                        @endpermission
                        @permission('pay_scale')
                        <li class="sidebar-list-item"><a href="{{route('payScale')}}" class="sidebar-link text-muted">
                                <span>{{$menu[9]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('tax')
                        <li class="sidebar-list-item"><a href="{{route('tax.setup')}}" class="sidebar-link text-muted">
                                <span>{{$menu[10]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('designation')
                        <li class="sidebar-list-item"><a href="{{route('designation')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[11]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('employee_type')
                        <li class="sidebar-list-item"><a href="{{route('employee.type')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[12]->display_name}}</span></a>
                        </li>
                        @endpermission
                        {{--                        @permission('weekend')--}}
                        {{--                        <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted">--}}
                        {{--                                <span>[[Weekend]]</span></a>--}}
                        {{--                        </li>--}}
                        {{--                        @endpermission--}}
                        @permission('general')
                        <li class="sidebar-list-item"><a href="{{route('general.setup')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[13]->display_name}}</span></a>
                        </li>
                        @endpermission
                        {{--                        @permission('holiday')--}}
                        {{--                        <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted">--}}
                        {{--                                <span>[[Holiday]]</span></a>--}}
                        {{--                        </li>--}}
                        {{--                        @endpermission--}}
                        @permission('religion')
                        <li class="sidebar-list-item"><a href="{{route('religion')}}" class="sidebar-link text-muted">
                                <span>{{$menu[14]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('leave')
                        <li class="sidebar-list-item"><a href="{{route('leave.setup')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[15]->display_name}}</span></a>
                        </li>
                        @endpermission
                    </ul>
                </div>
            </li>
        </ul>
        @endpermission
        @permission('circular')
        <ul class="sidebar-menu list-unstyled">

            <li class="sidebar-list-item"><a href="{{route('circular')}}" class="sidebar-link text-muted">
                    <span>{{$menu[16]->display_name}}</span></a></li>
        </ul>
        @endpermission
        @permission('employee_create|employee_edit|increment_policy|increment|promotion|account_close|transfer')
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#employeeManagement"
                                             aria-expanded="false" class="sidebar-link text-muted">
                    <span>{{$menu[17]->display_name}}</span></a>
                <div id="employeeManagement" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        @permission('employee_create')
                        <li class="sidebar-list-item"><a href="{{route('employee.create')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[18]->display_name}}</span></a></li>
                        @endpermission
                        @permission('employee_edit')
                        <li class="sidebar-list-item"><a href="{{route('employee.edit')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[19]->display_name}}</span></a></li>
                        @endpermission
                        @permission('increment_policy')
                        <li class="sidebar-list-item"><a href="{{route('increment.policy')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[20]->display_name}}</span></a></li>
                        @endpermission
                        @permission('increment')
                        <li class="sidebar-list-item"><a href="{{route('increment')}}" class="sidebar-link text-muted">
                                <span>{{$menu[21]->display_name}}</span></a></li>
                        {{--                        Its Not Coming From $m--}}
                        <li class="sidebar-list-item">
                            <a href="#" data-toggle="collapse" data-target="#increment" aria-expanded="false"
                               aria-controls="increment" class="sidebar-link text-muted">
                                <span>Increment Old</span>
                            </a>
                            <div id="increment" class="collapse">
                                <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                                    <li class="sidebar-list-item"><a href="{{ route('increment.persons.select') }}"
                                                                     class="sidebar-link text-muted"><i
                                                    class="fa fa-plus mr-3 text-gray"></i><span>Increment DH</span></a>
                                    </li>
                                    <li class="sidebar-list-item"><a href="{{ route('increment.show.hr') }}"
                                                                     class="sidebar-link text-muted"><i
                                                    class="fa fa-plus mr-3 text-gray"></i><span>Increment HR</span></a>
                                    </li>
                                    <li class="sidebar-list-item"><a href="{{ route('increment.show.ceo') }}"
                                                                     class="sidebar-link text-muted"><i
                                                    class="fa fa-plus mr-3 text-gray"></i><span>Increment CEO</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endpermission
                        @permission('account_close')
                        <li class="sidebar-list-item"><a href="{{route('account.close')}}"
                                                         class="sidebar-link text-muted">
                                <span>[[{{$menu[22]->display_name}}]]</span></a></li>
                        @endpermission
                        @permission('transfer')
                        <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#transfer"
                                                         aria-expanded="false" class="sidebar-link text-muted">
                                <span>{{$menu[23]->display_name}}</span></a>
                            <div id="transfer" class="collapse">
                                <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                                    <li class="sidebar-list-item"><a href="{{route('transfer.release')}}"
                                                                     class="sidebar-link text-muted">
                                            <span>{{$menu[24]->display_name}}</span></a></li>
                                    <li class="sidebar-list-item"><a href="{{route('transfer.join')}}"
                                                                     class="sidebar-link text-muted">
                                            <span>{{$menu[25]->display_name}}</span></a></li>
                                </ul>
                            </div>
                        </li>
                        @endpermission
                    </ul>
                </div>
            </li>
        </ul>
        @endpermission
        @permission('l_application|l_supervisor|l_HR')
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#leaveManagement"
                                             aria-expanded="false" class="sidebar-link text-muted">
                    <span>{{$menu[26]->display_name}}</span></a>
                <div id="leaveManagement" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        @permission('l_application')
                        <li class="sidebar-list-item"><a href="{{route('leave.application')}}"
                                                         class="sidebar-link text-muted">
{{--                                <i class="fas fa-gift mr-2 text-gray"></i>--}}
                                <span>{{$menu[27]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('l_HR')
                        <li class="sidebar-list-item"><a href="{{route('leave.application.view', ['uid' => 0])}}"
                                                         class="sidebar-link text-muted">
{{--                                <i class="far fa-clipboard mr-4 text-gray"></i>--}}
                                <span>{{$menu[28]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('l_supervisor')
                        <li class="sidebar-list-item"><a href="{{route('leave.application.view.DH', ['uid' => 0])}}"
                                                         class="sidebar-link text-muted">
{{--                                <i class="far fa-clipboard mr-4 text-gray"></i>--}}
                                <span>{{$menu[29]->display_name}}</span></a>
                        </li>
                        @endpermission
                    </ul>
                </div>
            </li>
        </ul>
        @endpermission
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#attendances"
                                             aria-expanded="false" aria-controls="attendances"
                                             class="sidebar-link text-muted"><span>{{$menu[30]->display_name}}</span></a>
                <div id="attendances" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item"><a href="{{route('attendance.receive')}}"
                                                         class="sidebar-link text-muted">
{{--                                <i class="fa fa-clock mr-3 text-gray"></i>--}}
                                <span>{{$menu[31]->display_name}}</span></a>
                        </li>
                        @permission('attendance_edit')
                        <li class="sidebar-list-item"><a href="{{ route('attendance.show') }}"
                                                         class="sidebar-link text-muted">
{{--                                <i class="fa fa-clock mr-3 text-gray"></i>--}}
                                <span>{{$menu[32]->display_name}}</span></a>
                        </li>
                        @endpermission
                    </ul>
                </div>
            </li>
        </ul>
        @permission('salary_generate|bonus|provident_fund|pension|loan')
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#payroll"
                                             aria-expanded="false" class="sidebar-link text-muted">
                    <span>{{$menu[33]->display_name}}</span></a>
                <div id="payroll" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        @permission('salary_generate')
                        <li class="sidebar-list-item"><a href="{{route('salary')}}" class="sidebar-link text-muted">
                                <span>{{$menu[34]->display_name}}</span></a></li>
                        @endpermission
                        @permission('bonus')
                        <li class="sidebar-list-item"><a href="{{route('bonus.setup')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[35]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('provident_fund')
                        <li class="sidebar-list-item"><a href="{{route('provident')}}" class="sidebar-link text-muted">
                                <span>{{$menu[36]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('pension')
                        <li class="sidebar-list-item"><a href="{{route('pension')}}" class="sidebar-link text-muted">
                                <span>{{$menu[37]->display_name}}</span></a>
                        </li>
                        @endpermission
                        @permission('loan')
                        <li class="sidebar-list-item"><a href="{{route('loan.type')}}" class="sidebar-link text-muted">
                                <span>{{$menu[38]->display_name}}</span></a>
                        </li>
                        @endpermission
                    </ul>
                </div>
            </li>
        </ul>
        @endpermission
        @permission('communication_global|communication_private')
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#communication"
                                             aria-expanded="false" class="sidebar-link text-muted">
                    <span>{{$menu[39]->display_name}} </span>
                    @if((((Auth::user()->tag)*1) > 0) || (Auth::user()->new_message_count > 0))
                        <span class="badge badge-warning ml-1">&nbsp;<b>{{(Auth::user()->tag * 1) + (Auth::user()->new_message_count * 1)}}</b></span>
                    @endif
                </a>
                <div id="communication" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        @permission('communication_global')
                        <li class="sidebar-list-item">
                            <a href="{{route('commentg')}}" class="sidebar-link text-muted">
                                {{$menu[40]->display_name}}
                                @if(((Auth::user()->tag)*1) > 0)
                                    <span class="badge badge-warning ml-1">&nbsp;<b>{{Auth::user()->tag}}</b></span>
                                @endif
                            </a>
                        </li>
                        @endpermission
                        @permission('communication_private')
                        <li class="sidebar-list-item">
                            <a href="#" data-toggle="collapse" data-target="#private-message" aria-expanded="false"
                               aria-controls="private-message" class="sidebar-link text-muted">
                                {{$menu[41]->display_name}}
                                @if(Auth::user()->new_message_count > 0)
                                    <span class="badge badge-warning ml-1">{{Auth::user()->new_message_count}}</span>
                                @endif
                            </a>
                            <div id="private-message" class="collapse">
                                <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                                    <li class="sidebar-list-item"><a href="{{ route('message.create') }}"
                                                                     class="sidebar-link text-muted"><i
                                                    class="fa fa-envelope mr-3 text-gray"></i><span>New</span></a></li>
                                    <li class="sidebar-list-item"><a href="{{ route('message.inbox') }}"
                                                                     class="sidebar-link text-muted"><i
                                                    class="fa fa-inbox mr-3 text-gray"></i><span>Inbox</span></a></li>
                                    <li class="sidebar-list-item"><a href="{{ route('message.sent') }}"
                                                                     class="sidebar-link text-muted"><i
                                                    class="fa fa-paper-plane mr-3 text-gray"></i><span>Sent</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endpermission
                    </ul>
                </div>
            </li>
        </ul>
        @endpermission
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#disputeManagement"
                                             aria-expanded="false" class="sidebar-link text-muted">
                    <span>{{$menu[42]->display_name}}</span></a>
                <div id="disputeManagement" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item"><a href="{{route('warning.create')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[43]->display_name}}</span></a></li>
                        @permission('warningDH')
                        <li class="sidebar-list-item"><a href="{{route('warning.showDH')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[44]->display_name}}</span></a></li>
                        @endpermission
                        <li class="sidebar-list-item"><a href="{{route('appeal.create')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[45]->display_name}}</span></a></li>
                        @permission('warningHR')
                        <li class="sidebar-list-item"><a href="{{route('warning.showHR')}}"
                                                         class="sidebar-link text-muted">
                                <span>{{$menu[46]->display_name}}</span></a></li>
                        @endpermission
                    </ul>
                </div>
            </li>
        </ul>
        @if((Auth::user()->kpiVoting * 1) == 1)
            <ul class="sidebar-menu list-unstyled">
                <li class="sidebar-list-item"><a href="{{route('kpi.vote')}}" class="sidebar-link text-muted">
                        {{$menu[47]->display_name}}</a></li>
            </ul>
        @endif
        @permission('kpi')
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#kpi"
                                             aria-expanded="false" class="sidebar-link text-muted">
                    <span>{{$menu[48]->display_name}}</span></a>
                <div id="kpi" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item"><a href="{{route('kpi.setup')}}" class="sidebar-link text-muted">
                                {{$menu[49]->display_name}}</a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="{{route('kpi')}}" class="sidebar-link text-muted">{{$menu[50]->display_name}}</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        @endpermission


        {{--        New End///////////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}


        @permission('test|user_create')
        I'm a writer!
        @endpermission

        {{--                {{Session::get('menu')}}--}}
        {{--        {{dd($mmm)}}--}}

        {{--        OLD//////////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}
        <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">
            MAIN
        </div>
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item">
                <a href="#" data-toggle="collapse" data-target="#info" aria-expanded="false" aria-controls="info"
                   class="sidebar-link text-muted">
                    {{--                    <i class="fas fa-info-circle mr-4 text-gray"></i>--}}
                    <span>Info</span>
                </a>
                <div id="info" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item"><a href="{{route('userinfosearch')}}"
                                                         class="sidebar-link text-muted"><i
                                        class="fas fa-user-tag mr-3 text-gray"></i><span>User Info</span></a></li>
                        <li class="sidebar-list-item"><a href="{{route('userJobInfoSearch')}}"
                                                         class="sidebar-link text-muted"><i
                                        class="fas fa-user-tie mr-4 text-gray"></i><span>User Job-Info</span></a></li>
                        <li class="sidebar-list-item"><a href="{{route('userPayInfoSearch')}}"
                                                         class="sidebar-link text-muted"><i
                                        class="fas fa-user-lock mr-3 text-gray"></i><span>[[ User Pay-Info ]]</span></a>
                        </li>
                        <li class="sidebar-list-item"><a href="{{route('userLoanInfoSearch')}}"
                                                         class="sidebar-link text-muted"><i
                                        class="fas fa-user-ninja mr-3 text-gray"></i><span>User Loan-Info</span></a>
                        </li>
                        <li class="sidebar-list-item"><a href="{{route('user.search.role')}}"
                                                         class="sidebar-link text-muted"><i
                                        class="fas fa-user-astronaut mr-3 text-gray"></i><span>User Role</span></a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-list-item">
                <a href="#" data-toggle="collapse" data-target="#tasks" aria-expanded="false" aria-controls="tasks"
                   class="sidebar-link text-muted">
{{--                    <i class="fas fa-business-time mr-3 text-gray"></i>--}}
                    <span>Tasks</span>
                </a>
                <div id="tasks" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item"><a href="{{route('task.index')}}"
                                                         class="sidebar-link text-muted"><i
                                        class="fas fa-tasks mr-4 text-gray"></i><span>Task PM</span></a></li>
                        <li class="sidebar-list-item"><a href="{{route('task.index.employee')}}"
                                                         class="sidebar-link text-muted"><i
                                        class="fas fa-tasks mr-4 text-gray"></i><span>Task E.</span></a></li>
                    </ul>
                </div>
            </li>
        </ul>


        {{--                OLD End//////////////////////////////////////////////////////////////////////////////////////////////////////////--}}

    </div>
    <div class="page-holder w-100 d-flex flex-wrap">
