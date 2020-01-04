<div class="page-sidebar">
@php
    $Office = Storage::disk('local')->get('office');
    $OfficE = json_decode($Office);
    $jobTitle = Storage::disk('local')->get('job_title');
    $menuU = Storage::disk('local')->get('menu');
    $menu = json_decode($menuU);
@endphp
<!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="{{url('/')}}" style="background-color:
            @if($OfficE && $OfficE->logo_bg)
            {{$OfficE->logo_bg}}
            @else
                    #1caf9a
            @endif
                    ;">
                @if($OfficE && $OfficE->logo)
                    <img src="{{asset($OfficE->logo)}}" alt="logo"
                         style="max-width: 180px;max-height: 35px;margin-top: -8px;">
                @else
                    European IT
                @endif
            </a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img
                        @if(Auth::user()->image)
                        src="{{asset(Auth::user()->image)}}"
                        @else
                        src="{{asset('joli/avatar.png')}}"
                        @endif
                        alt="Full Name"
                >
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img
                            @if(Auth::user()->image)
                            src="{{asset(Auth::user()->image)}}"
                            @else
                            src="{{asset('joli/avatar.png')}}"
                            @endif
                            alt="Full Name"
                    >
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{Auth::user()->name}}</div>
                    @if((Auth::user()->branch_id * 1) != 0)
                        <div class="profile-data-title">
                            {{$jobTitle}}
                        </div>
                    @endif
                </div>
                @if((Auth::user()->branch_id * 1) != 0)
                    <div class="profile-controls">
                        <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                    </div>
                @endif
            </div>
        </li>
        <li>
            <a href="{{route('home')}}"><span class="glyphicon glyphicon-home"></span> <span
                        class="xn-text">{{$menu[0]->display_name}}</span></a>
        </li>
        @permission('permission|role|menu|user_create')
        <li class="xn-openable">
            <a href="#"><span class="glyphicon glyphicon-transfer"></span> <span
                        class="xn-text"> {{$menu[1]->display_name}}</span></a>
            <ul>
                @permission('permission')
                <li><a href="{{route('permission')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[2]->display_name}}</a></li>
                @endpermission
                @permission('role')
                <li><a href="{{route('role')}}"><i class="glyphicon glyphicon-minus"></i> {{$menu[3]->display_name}}
                    </a></li>
                @endpermission
                @permission('menu')
                <li><a href="{{route('menu.setup')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[4]->display_name}}
                    </a></li>
                @endpermission
                @permission('user_create')
                <li><a href="{{route('users')}}"><i class="glyphicon glyphicon-minus"></i> {{$menu[5]->display_name}}
                    </a>
                </li>
                @endpermission
                {{--                <li><a href="{{route('test')}}"><span class="fa fa-download"></span> Test</a></li>--}}
            </ul>
        </li>
        @endpermission
        @permission('office_setup|branch_setup|pay_scale|tax|designation|employee_type|working_hour|religion|leave')
        <li class="xn-openable">
            <a href="#"><span class="fa fa-building-o"></span> <span
                        class="xn-text"> {{$menu[6]->display_name}}</span></a>
            <ul>
                @permission('office_setup')
                <li><a href="{{route('office.setup')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[7]->display_name}}</a></li>
                @endpermission
                @permission('branch_setup')
                <li><a href="{{route('branch.setup')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[8]->display_name}}
                    </a></li>
                @endpermission
                @permission('pay_scale')
                <li><a href="{{route('payScale')}}"><i class="glyphicon glyphicon-minus"></i> {{$menu[9]->display_name}}
                    </a></li>
                @endpermission
                @permission('tax')
                <li><a href="{{route('tax.setup')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[10]->display_name}}</a>
                </li>
                @endpermission
                @permission('designation')
                <li><a href="{{route('designation')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[11]->display_name}}</a>
                </li>
                @endpermission
                @permission('employee_type')
                <li><a href="{{route('employee.type')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[12]->display_name}}</a>
                </li>
                @endpermission
                @permission('general')
                <li><a href="{{route('general.setup')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[13]->display_name}}</a>
                </li>
                @endpermission
                @permission('religion')
                <li><a href="{{route('religion')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[14]->display_name}}</a>
                </li>
                @endpermission
                @permission('leave')
                <li><a href="{{route('leave.setup')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[15]->display_name}}</a>
                </li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @permission('circular')
        <li>
            <a href="{{route('circular')}}"><span class="glyphicon glyphicon-export"></span> <span
                        class="xn-text">{{$menu[16]->display_name}}</span></a>
        </li>
        @endpermission
        @permission('employee_create|employee_edit|increment_policy|increment|promotion|account_close|transfer')
        <li class="xn-openable">
            <a href="#"><span class="fa fa-sitemap"></span> <span
                        class="xn-text"> {{$menu[17]->display_name}}</span></a>
            <ul>
                @permission('employee_create')
                <li><a href="{{route('employee.create')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[18]->display_name}}</a></li>
                @endpermission
                @permission('employee_edit')
                <li><a href="{{route('employee.edit')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[19]->display_name}}</a></li>
                @endpermission
                @permission('increment_policy')
                <li><a href="{{route('increment.policy')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[20]->display_name}}</a></li>
                @endpermission
                @permission('increment')
                <li><a href="{{route('increment')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[21]->display_name}}</a></li>
                {{--Old Increment--}}
                {{--Its Not Coming From $m--}}
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-sitemap"></span> <span
                                class="xn-text"> Increment Old</span></a>
                    <ul>
                        <li><a href="{{route('increment.persons.select')}}"><i class="glyphicon glyphicon-minus"></i>
                                Department Head</a>
                        </li>
                        <li><a href="{{route('increment.show.hr')}}"><i class="glyphicon glyphicon-minus"></i> HR</a>
                        </li>
                        <li><a href="{{route('increment.show.ceo')}}"><i class="glyphicon glyphicon-minus"></i> CEO</a>
                        </li>
                    </ul>
                </li>
                @endpermission
                @permission('account_close')
                <li><a href="{{route('account.close')}}"><i class="glyphicon glyphicon-minus"></i>
                        [[{{$menu[22]->display_name}}]]</a></li>
                @endpermission
                @permission('transfer')
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-sitemap"></span> <span
                                class="xn-text"> {{$menu[23]->display_name}}</span></a>
                    <ul>
                        <li><a href="{{route('transfer.release')}}"><i
                                        class="glyphicon glyphicon-minus"></i> {{$menu[24]->display_name}}</a>
                        </li>
                        <li><a href="{{route('transfer.join')}}"><i
                                        class="glyphicon glyphicon-minus"></i> {{$menu[25]->display_name}}
                            </a></li>
                        {{--                        <li><a href="{{route('test')}}"><span class="fa fa-download"></span> Test</a></li>--}}
                    </ul>
                </li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @permission('l_application|l_supervisor|l_HR')
        <li class="xn-openable">
            <a href="#"><span class="fa fa-plane"></span> <span
                        class="xn-text"> {{$menu[26]->display_name}}</span></a>
            <ul>
                @permission('l_application')
                <li><a href="{{route('leave.application')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[27]->display_name}}</a></li>
                @endpermission
                @permission('l_HR')
                <li><a href="{{route('leave.application.view', ['uid' => 0])}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[28]->display_name}}</a></li>
                @endpermission
                @permission('l_supervisor')
                <li><a href="{{route('leave.application.view.DH', ['uid' => 0])}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[29]->display_name}}</a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @if((Auth::user()->branch_id * 1) != 0)
            <li class="xn-openable">
                <a href="#"><span class="glyphicon glyphicon-check"></span> <span
                            class="xn-text"> {{$menu[30]->display_name}}</span></a>
                <ul>
                    <li><a href="{{route('attendance.receive')}}"><i
                                    class="glyphicon glyphicon-minus"></i> {{$menu[31]->display_name}}</a></li>
                    @permission('attendance_edit')
                    <li><a href="{{route('attendance.show')}}"><i
                                    class="glyphicon glyphicon-minus"></i> {{$menu[32]->display_name}}</a></li>
                    @endpermission
                </ul>
            </li>
        @endif
        @permission('salary_generate|bonus|provident_fund|pension|loan')
        <li class="xn-openable">
            <a href="#"><span class="fa fa-money"></span> <span
                        class="xn-text"> {{$menu[33]->display_name}}</span></a>
            <ul>
                @permission('salary_generate')
                <li><a href="{{route('salary')}}"><i class="glyphicon glyphicon-minus"></i> {{$menu[34]->display_name}}
                    </a></li>
                @endpermission
                @permission('bonus')
                <li><a href="{{route('bonus.setup')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[35]->display_name}}</a></li>
                @endpermission
                @permission('provident_fund')
                <li><a href="{{route('provident')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[36]->display_name}}</a></li>
                @endpermission
                @permission('pension')
                <li><a href="{{route('pension')}}"><i class="glyphicon glyphicon-minus"></i> {{$menu[37]->display_name}}
                    </a></li>
                @endpermission
                @permission('loan')
                <li><a href="{{route('loan.type')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[38]->display_name}}</a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @permission('communication_global|communication_private')
        <li class="xn-openable">
            <a href="#"><span class="glyphicon glyphicon-envelope"></span> <span
                        class="xn-text"> {{$menu[39]->display_name}} </span>
                @if((((Auth::user()->tag)*1) > 0) || (Auth::user()->new_message_count > 0))
                    <span class="badge badge-warning ml-1">&nbsp;<b>{{(Auth::user()->tag * 1) + (Auth::user()->new_message_count * 1)}}</b></span>
                @endif
            </a>
            <ul>
                @permission('communication_global')
                <li><a href="{{route('commentg')}}"><span
                                class="fa fa-comments-o"></span> {{$menu[40]->display_name}}
                        @if(((Auth::user()->tag)*1) > 0)
                            <span class="badge badge-warning ml-1">&nbsp;<b>{{Auth::user()->tag}}</b></span>
                        @endif
                    </a></li>
                @endpermission
                @permission('communication_private')
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-envelope"></span> <span
                                class="xn-text"> {{$menu[41]->display_name}} </span>
                        @if(Auth::user()->new_message_count > 0)
                            <span class="badge badge-warning ml-1">{{Auth::user()->new_message_count}}</span>
                        @endif
                    </a>
                    <ul>
                        <li><a href="{{route('message.inbox')}}"><span class="fa fa-inbox"></span> Inbox</a></li>
                        <li><a href="{{route('message.sent')}}"><span class="glyphicon glyphicon-send"></span> Sent</a>
                        </li>
                        <li><a href="{{route('message.create')}}"><span class="fa fa-pencil"></span> New</a></li>
                    </ul>
                </li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @if((Auth::user()->branch_id * 1) != 0)
            <li class="xn-openable">
                <a href="#"><span class="fa fa-thumbs-o-down"></span> <span
                            class="xn-text"> {{$menu[42]->display_name}}</span></a>
                <ul>
                    <li><a href="{{route('warning.create')}}"><i
                                    class="glyphicon glyphicon-minus"></i> {{$menu[43]->display_name}}</a></li>
                    @permission('warningDH')
                    <li><a href="{{route('warning.showDH')}}"><i
                                    class="glyphicon glyphicon-minus"></i> {{$menu[44]->display_name}}</a></li>
                    @endpermission
                    <li><a href="{{route('appeal.create')}}"><i
                                    class="glyphicon glyphicon-minus"></i> {{$menu[45]->display_name}}</a></li>
                    @permission('warningHR')
                    <li><a href="{{route('warning.showHR')}}"><i
                                    class="glyphicon glyphicon-minus"></i> {{$menu[46]->display_name}}</a></li>
                    @endpermission
                </ul>
            </li>
            @if((Auth::user()->kpiVoting * 1) == 1)
                <li>
                    <a href="{{route('kpi.vote')}}"><span class="fa fa-tasks"></span> <span
                                class="xn-text">{{$menu[47]->display_name}}</span></a>
                </li>
            @endif
        @endif
        @permission('kpi')
        <li class="xn-openable">
            <a href="#"><span class="fa fa-gavel"></span> <span
                        class="xn-text"> {{$menu[48]->display_name}}</span></a>
            <ul>
                <li><a href="{{route('kpi.setup')}}"><i
                                class="glyphicon glyphicon-minus"></i> {{$menu[49]->display_name}}</a></li>
                <li><a href="{{route('kpi')}}"><i class="glyphicon glyphicon-minus"></i> {{$menu[50]->display_name}}</a>
                </li>
            </ul>
        </li>
        @endpermission
        @if((Auth::user()->branch_id * 1) != 0)
            <li class="xn-openable">
                <a href="#"><span class="glyphicon glyphicon-calendar"></span> <span
                            class="xn-text"> {{$menu[51]->display_name}}</span></a>
                <ul>
                    @permission('project_manager')
                    <li><a href="{{route('task.project.manager')}}"><i
                                    class="glyphicon glyphicon-minus"></i> {{$menu[52]->display_name}}</a></li>
                    @endpermission
                    <li><a href="{{route('task.general')}}"><i
                                    class="glyphicon glyphicon-minus"></i> {{$menu[53]->display_name}}</a></li>
                </ul>
            </li>
        @endif
        <li class="xn-title">Old</li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-info"></span> <span
                        class="xn-text"> Info</span></a>
            <ul>
                <li><a href="{{route('userinfosearch')}}"><span
                                class="fa fa-info"></span> User Info</a></li>
                <li><a href="{{route('userJobInfoSearch')}}"><span
                                class="fa fa-info"></span> User Job Info</a></li>
                <li><a href="{{route('userPayInfoSearch')}}"><span
                                class="fa fa-info"></span> [[User Pay Info]]</a></li>
                <li><a href="{{route('userLoanInfoSearch')}}"><span
                                class="fa fa-info"></span> User Loan Info</a></li>
                <li><a href="{{route('user.search.role')}}"><span
                                class="fa fa-info"></span> User Role</a></li>
            </ul>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="glyphicon glyphicon-calendar"></span> <span
                        class="xn-text"> Task Management</span></a>
            <ul>
                <li><a href="{{route('task.index')}}"><i class="glyphicon glyphicon-minus"></i> Project Manager</a></li>
                <li><a href="{{route('task.index.employee')}}"><i class="glyphicon glyphicon-minus"></i> Employee</a>
                </li>
            </ul>
        </li>


        {{--        <li class="xn-title">Navigation</li>--}}
        {{--        <li>--}}
        {{--            <a href="index.html"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>--}}
        {{--        </li>--}}
        {{--        <li class="xn-openable">--}}
        {{--            <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Pages</span></a>--}}
        {{--            <ul>--}}
        {{--                <li><a href="pages-gallery.html"><span class="fa fa-image"></span> Gallery</a></li>--}}
        {{--                <li><a href="pages-profile.html"><span class="fa fa-user"></span> Profile</a></li>--}}
        {{--                <li><a href="pages-address-book.html"><span class="fa fa-users"></span> Address Book</a></li>--}}
        {{--                <li class="xn-openable">--}}
        {{--                    <a href="#"><span class="fa fa-clock-o"></span> Timeline</a>--}}
        {{--                    <ul>--}}
        {{--                        <li><a href="pages-timeline.html"><span class="fa fa-align-center"></span> Default</a></li>--}}
        {{--                        <li><a href="pages-timeline-simple.html"><span class="fa fa-align-justify"></span> Full--}}
        {{--                                Width</a></li>--}}
        {{--                    </ul>--}}
        {{--                </li>--}}
        {{--                <li class="xn-openable">--}}
        {{--                    <a href="#"><span class="fa fa-envelope"></span> Mailbox</a>--}}
        {{--                    <ul>--}}
        {{--                        <li><a href="pages-mailbox-inbox.html"><span class="fa fa-inbox"></span> Inbox</a></li>--}}
        {{--                        <li><a href="pages-mailbox-message.html"><span class="fa fa-file-text"></span> Message</a></li>--}}
        {{--                        <li><a href="pages-mailbox-compose.html"><span class="fa fa-pencil"></span> Compose</a></li>--}}
        {{--                    </ul>--}}
        {{--                </li>--}}
        {{--                <li><a href="pages-messages.html"><span class="fa fa-comments"></span> Messages</a></li>--}}
        {{--                <li><a href="pages-calendar.html"><span class="fa fa-calendar"></span> Calendar</a></li>--}}
        {{--                <li><a href="pages-tasks.html"><span class="fa fa-edit"></span> Tasks</a></li>--}}
        {{--                <li><a href="pages-content-table.html"><span class="fa fa-columns"></span> Content Table</a></li>--}}
        {{--                <li><a href="pages-faq.html"><span class="fa fa-question-circle"></span> FAQ</a></li>--}}
        {{--                <li><a href="pages-search.html"><span class="fa fa-search"></span> Search</a></li>--}}
        {{--                <li class="xn-openable">--}}
        {{--                    <a href="#"><span class="fa fa-file"></span> Blog</a>--}}

        {{--                    <ul>--}}
        {{--                        <li><a href="pages-blog-list.html"><span class="fa fa-copy"></span> List of Posts</a></li>--}}
        {{--                        <li><a href="pages-blog-post.html"><span class="fa fa-file-o"></span>Single Post</a></li>--}}
        {{--                    </ul>--}}
        {{--                </li>--}}
        {{--                <li class="xn-openable">--}}
        {{--                    <a href="#"><span class="fa fa-sign-in"></span> Login</a>--}}
        {{--                    <ul>--}}
        {{--                        <li><a href="pages-login.html">App Login</a></li>--}}
        {{--                        <li><a href="pages-login-website.html">Website Login</a></li>--}}
        {{--                        <li><a href="pages-login-website-light.html"> Website Login Light</a></li>--}}
        {{--                    </ul>--}}
        {{--                </li>--}}
        {{--                <li class="xn-openable">--}}
        {{--                    <a href="#"><span class="fa fa-warning"></span> Error Pages</a>--}}
        {{--                    <ul>--}}
        {{--                        <li><a href="pages-error-404.html">Error 404 Sample 1</a></li>--}}
        {{--                        <li><a href="pages-error-404-2.html">Error 404 Sample 2</a></li>--}}
        {{--                        <li><a href="pages-error-500.html"> Error 500</a></li>--}}
        {{--                    </ul>--}}
        {{--                </li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        {{--        <li class="xn-openable">--}}
        {{--            <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Layouts</span></a>--}}
        {{--            <ul>--}}
        {{--                <li><a href="layout-boxed.html">Boxed</a></li>--}}
        {{--                <li><a href="layout-nav-toggled.html">Navigation Toggled</a></li>--}}
        {{--                <li><a href="layout-nav-top.html">Navigation Top</a></li>--}}
        {{--                <li><a href="layout-nav-right.html">Navigation Right</a></li>--}}
        {{--                <li><a href="layout-nav-top-fixed.html">Top Navigation Fixed</a></li>--}}
        {{--                <li><a href="layout-nav-custom.html">Custom Navigation</a></li>--}}
        {{--                <li><a href="layout-frame-left.html">Frame Left Column</a></li>--}}
        {{--                <li><a href="layout-frame-right.html">Frame Right Column</a></li>--}}
        {{--                <li><a href="layout-search-left.html">Search Left Side</a></li>--}}
        {{--                <li><a href="blank.html">Blank Page</a></li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        {{--        <li class="xn-title">Components</li>--}}
        {{--        <li class="xn-openable">--}}
        {{--            <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">UI Kits</span></a>--}}
        {{--            <ul>--}}
        {{--                <li><a href="ui-widgets.html"><span class="fa fa-heart"></span> Widgets</a></li>--}}
        {{--                <li><a href="ui-elements.html"><span class="fa fa-cogs"></span> Elements</a></li>--}}
        {{--                <li><a href="ui-buttons.html"><span class="fa fa-square-o"></span> Buttons</a></li>--}}
        {{--                <li><a href="ui-panels.html"><span class="fa fa-pencil-square-o"></span> Panels</a></li>--}}
        {{--                <li><a href="ui-icons.html"><span class="fa fa-magic"></span> Icons</a>--}}
        {{--                    <div class="informer informer-warning">+679</div>--}}
        {{--                </li>--}}
        {{--                <li><a href="ui-typography.html"><span class="fa fa-pencil"></span> Typography</a></li>--}}
        {{--                <li><a href="ui-portlet.html"><span class="fa fa-th"></span> Portlet</a></li>--}}
        {{--                <li><a href="ui-sliders.html"><span class="fa fa-arrows-h"></span> Sliders</a></li>--}}
        {{--                <li><a href="ui-alerts-popups.html"><span class="fa fa-warning"></span> Alerts & Popups</a></li>--}}
        {{--                <li><a href="ui-lists.html"><span class="fa fa-list-ul"></span> Lists</a></li>--}}
        {{--                <li><a href="ui-tour.html"><span class="fa fa-random"></span> Tour</a></li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        {{--        <li class="xn-openable">--}}
        {{--            <a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Forms</span></a>--}}
        {{--            <ul>--}}
        {{--                <li>--}}
        {{--                    <a href="form-layouts-two-column.html"><span class="fa fa-tasks"></span> Form Layouts</a>--}}
        {{--                    <div class="informer informer-danger">New</div>--}}
        {{--                    <ul>--}}
        {{--                        <li><a href="form-layouts-one-column.html"><span class="fa fa-align-justify"></span> One Column</a>--}}
        {{--                        </li>--}}
        {{--                        <li><a href="form-layouts-two-column.html"><span class="fa fa-th-large"></span> Two Column</a>--}}
        {{--                        </li>--}}
        {{--                        <li><a href="form-layouts-tabbed.html"><span class="fa fa-table"></span> Tabbed</a></li>--}}
        {{--                        <li><a href="form-layouts-separated.html"><span class="fa fa-th-list"></span> Separated Rows</a>--}}
        {{--                        </li>--}}
        {{--                    </ul>--}}
        {{--                </li>--}}
        {{--                <li><a href="form-elements.html"><span class="fa fa-file-text-o"></span> Elements</a></li>--}}
        {{--                <li><a href="form-validation.html"><span class="fa fa-list-alt"></span> Validation</a></li>--}}
        {{--                <li><a href="form-wizards.html"><span class="fa fa-arrow-right"></span> Wizards</a></li>--}}
        {{--                <li><a href="form-editors.html"><span class="fa fa-text-width"></span> WYSIWYG Editors</a></li>--}}
        {{--                <li><a href="form-file-handling.html"><span class="fa fa-floppy-o"></span> File Handling</a></li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        {{--        <li class="xn-openable">--}}
        {{--            <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Tables</span></a>--}}
        {{--            <ul>--}}
        {{--                <li><a href="table-basic.html"><span class="fa fa-align-justify"></span> Basic</a></li>--}}
        {{--                <li><a href="table-datatables.html"><span class="fa fa-sort-alpha-desc"></span> Data Tables</a></li>--}}
        {{--                <li><a href="table-export.html"><span class="fa fa-download"></span> Export Tables</a></li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        {{--        <li class="xn-openable">--}}
        {{--            <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Charts</span></a>--}}
        {{--            <ul>--}}
        {{--                <li><a href="charts-morris.html"><span class="xn-text">Morris</span></a></li>--}}
        {{--                <li><a href="charts-nvd3.html"><span class="xn-text">NVD3</span></a></li>--}}
        {{--                <li><a href="charts-rickshaw.html"><span class="xn-text">Rickshaw</span></a></li>--}}
        {{--                <li><a href="charts-other.html"><span class="xn-text">Other</span></a></li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        {{--        <li>--}}
        {{--            <a href="maps.html"><span class="fa fa-map-marker"></span> <span class="xn-text">Maps</span></a>--}}
        {{--        </li>--}}
        {{--        <li class="xn-openable">--}}
        {{--            <a href="#"><span class="fa fa-sitemap"></span> <span class="xn-text">Navigation Levels</span></a>--}}
        {{--            <ul>--}}
        {{--                <li class="xn-openable">--}}
        {{--                    <a href="#">Second Level</a>--}}
        {{--                    <ul>--}}
        {{--                        <li class="xn-openable">--}}
        {{--                            <a href="#">Third Level</a>--}}
        {{--                            <ul>--}}
        {{--                                <li class="xn-openable">--}}
        {{--                                    <a href="#">Fourth Level</a>--}}
        {{--                                    <ul>--}}
        {{--                                        <li><a href="#">Fifth Level</a></li>--}}
        {{--                                    </ul>--}}
        {{--                                </li>--}}
        {{--                            </ul>--}}
        {{--                        </li>--}}
        {{--                    </ul>--}}
        {{--                </li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}

    </ul>
    <!-- END X-NAVIGATION -->
</div>