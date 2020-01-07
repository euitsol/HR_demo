<?php

Route::get('/', function () {
//    return view('welcome');
    return view('auth.login');
});

Auth::routes();

Route::post('/test', [
    'uses' => 'HomeController@test',
    'as' => 'test'
]);
Route::get('/t', function (){
    return redirect()->route('permission');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/refresh', 'ApplicantController@back')->name('back');


Route::get('/permission-setup', 'AclController@permission')->name('permission');
Route::get('/permission-edit/{pid}', 'AclController@permissionEdit')->name('permission.edit');
Route::post('/permission-update/{pid}', 'AclController@permissionUpdate')->name('permission.update');

Route::get('/role-setup', 'AclController@index')->name('role');
Route::post('/role-store', 'AclController@store')->name('role.store');
Route::get('/role-delete/{rid}', 'AclController@destroy')->name('role.delete');
Route::get('/role-edit/{rid}', 'AclController@edit')->name('role.edit');
Route::post('/role-update/{rid}', 'AclController@update')->name('role.update');

Route::get('/menu-setup', 'MenuController@index')->name('menu.setup');
Route::get('/menu-edit/{mid}', 'MenuController@edit')->name('menu.edit');
Route::post('/menu-update/{mid}', 'MenuController@update')->name('menu.update');

Route::get('/office-setup', 'OfficeController@index')->name('office.setup');
Route::post('/office-setup-update', 'OfficeController@store')->name('office.setup.update');

Route::get('/users-setup', 'HomeController@users')->name('users');
Route::post('/user-store', 'HomeController@storeUser')->name('user.store');
Route::get('/user-edit/{uid}', 'HomeController@edit')->name('user.edit');
Route::post('/user-update/{uid}', 'HomeController@update')->name('user.update');

Route::get('/Branch-Setup', 'BranchController@index')->name('branch.setup');
Route::post('/Branch/Store', 'BranchController@store')->name('branch.store');
Route::get('/Branch/Edit/{bid}', 'BranchController@edit')->name('branch.edit');
Route::post('/Branch/Update/{bid}', 'BranchController@update')->name('branch.update');
Route::get('/Branch-Delete/{bid}', 'BranchController@destroy')->name('branch.delete');

Route::get('/Pension', 'PensionController@index')->name('pension');
Route::post('/Pension/is_active_change', 'PensionController@pensionIsActiveChange')->name('pension.isActive.change');
Route::post('/Pension/is_company_pay', 'PensionController@pensionIsBoth')->name('pension.is.both');
Route::post('/pension-update', 'PensionController@update')->name('pension.update');
Route::get('/Pension/is_gross', 'PensionController@isGrossAjax')->middleware('auth');
//Route::get('/Pension/is_gross_text', 'PensionController@isGrossTextAjax')->middleware('auth');

Route::get('/Leave/Setup', 'LeavetypeController@index')->name('leave.setup');
Route::post('/Leave/Setup/Update', 'LeavetypeController@updatemlpt')->name('leave.mlpt.update');
Route::post('/Leave-Type/Store', 'LeavetypeController@store')->name('leaveType.store');
Route::get('/Leave-Type/Edit/{ltid}', 'LeavetypeController@edit')->name('leaveType.edit');
Route::post('/Leave-Type/Update/{ltid}', 'LeavetypeController@update')->name('leaveType.update');
Route::get('/Leave-Type/{ltid}/Delete', 'LeavetypeController@delete')->name('leaveType.delete');

Route::get('/loan-scheme', 'LoantypeController@index')->name('loan.type');
Route::post('/loan-type-store', 'LoantypeController@store')->name('loanType.store');
Route::get('/loan-scheme-edit/{ltid}', 'LoantypeController@edit')->name('loan.type.edit');
Route::post('/loan-type-update/{ltid}', 'LoantypeController@update')->name('loan.type.update');
Route::get('/loan-type/{ltid}/delete', 'LoantypeController@delete')->name('loanType.delete');

Route::get('/General-Setup', 'SalaryController@generalSetup')->name('general.setup');
Route::post('/Salary-Setup/Update', 'SalaryController@generalUpdate')->name('general.setup.update');

Route::get('/Bonus/Setup', 'BonusController@index')->name('bonus.setup');
Route::post('/Bonus/Update', 'BonusController@update')->name('bonus.update');
Route::get('/Bonus/Reset', 'BonusController@reset')->name('bonus.reset');

Route::get('/Provident-Fund-Setup', 'ProvidentController@index')->name('provident');
Route::post('/Provident-Fund-Update', 'ProvidentController@update')->name('provident.update');

Route::get('/Employee-Type', 'EmployeeTypeController@index')->name('employee.type');
Route::post('/employee-type-store', 'EmployeeTypeController@store')->name('employeeType.store');
Route::get('/employee-type-edit/{etid}', 'EmployeeTypeController@edit')->name('employee.type.edit');
Route::post('/employee-type-update/{etid}', 'EmployeeTypeController@update')->name('employee.type.update');
Route::get('/employee-type/{etid}/delete', 'EmployeeTypeController@destroy')->name('employeeType.delete');

Route::get('/Religion/Setup', 'ReligionController@index')->name('religion');
Route::post('/religion-store', 'ReligionController@store')->name('religion.store');
Route::get('/Religion/edit/{rid}', 'ReligionController@edit')->name('religion.edit');
Route::post('/religion-update/{rid}', 'ReligionController@update')->name('religion.update');
Route::get('/religion/{rid}/delete', 'ReligionController@destroy')->name('religion.delete');

Route::get('/Pay-Scale/Setup', 'PayscaleController@index')->name('payScale');
Route::get('/Pay-Scale/Create', 'PayscaleController@create')->name('payScale.create');
Route::post('/Pay-Scale/store', 'PayscaleController@store')->name('payScale.store');
Route::get('/Pay-Scale/Edit/{pid}', 'PayscaleController@edit')->name('payScale.edit');
Route::post('/Pay-Scale/update/{pid}', 'PayscaleController@update')->name('payScale.update');
Route::get('/Pay-Scale/delete/{pid}', 'PayscaleController@destroy')->name('payScale.delete');

Route::get('/Designation/Setup', 'JobController@index')->name('designation');
Route::post('/designation/store', 'JobController@store')->name('job.store');
Route::get('/Designation/Edit/{jid}', 'JobController@edit')->name('job.edit');
Route::post('/designation/update/{jid}', 'JobController@update')->name('job.update');
Route::get('/Designation/Delete/{jid}', 'JobController@destroy')->name('job.delete');

Route::get('/Circular', 'NoticeController@index')->name('circular');
Route::post('/Circular/store', 'NoticeController@store')->name('circular.store');
Route::get('/notice/{nid}/applied-users', 'NoticeController@totalAppliedUser')->name('total.applied.user');
Route::get('/notice/{nid}/delete', 'NoticeController@noticeDelete')->name('notice.delete');
Route::get('/Notice-unpublish/{nid}', 'NoticeController@unpublish')->name('circular.unpublish');
Route::get('/Notice-publish/{nid}', 'NoticeController@publish')->name('circular.publish');
Route::get('/Circular/{nid}', 'NoticeController@view')->name('notice.view');
Route::get('/Circular/edit/{nid}', 'NoticeController@edit')->name('notice.edit');
Route::post('/notice-update/{nid}', 'NoticeController@update')->name('notice.update');
Route::get('/Circular/{nid}/applicant-list', 'NoticeController@noticeApplicantView')->name('notice.applicant.view');
Route::get('/select-applicant/{aid}', 'NoticeController@selectApplicant')->name('select.applicant');
Route::get('/unselect-applicant/{aid}', 'NoticeController@unSelectApplicant')->name('unselect.applicant');
Route::get('/applicant/to/{aid}/employee/{nid}', 'EmployeeController@applicantEmployee')->name('applicant.employee');
Route::post('/applicant/to/employee/{aid}/{nid}', 'EmployeeController@applicantEmployeeStore')->name('employee.applicant.store');
Route::get('/applicant/view/{aid}', 'NoticeController@applicantView')->name('applicant.view');
Route::get('/applicant-cv-download/{aid}', 'NoticeController@downloadApplicantCV')->name('downloadApplicantCV');
// Circular web portal
Route::get('/circulars', 'ApplicantController@show')->name('show-notices');
Route::get('/circular/view/{nid}', 'ApplicantController@view')->name('notice.view.noAuth');
Route::get('/circular/{nid}/apply', 'ApplicantController@apply')->name('apply');
Route::get('/applicant/login', 'Auth\LoginApplicantController@loginFormShow')->name('applicant.login');
Route::post('/applicant/login', 'Auth\LoginApplicantController@login')->name('applicant.login');
Route::get('/applicant/logout', 'Auth\LoginApplicantController@logout')->name('applicant.logout');
Route::get('/applicant/error/{aid}/{nid}', 'ApplicantController@dummyOne')->name('applicant.dummy.1');
Route::post('/Apply-Submit/{aid}/{nid}', 'ApplicantController@applySubmit')->name('apply.submit');
Route::get('/Register/e-Recruitment', 'ApplicantController@register')->name('applicant.register');
Route::post('/applicant/store', 'ApplicantController@store')->name('applicant.store');

Route::get('/complain/create', 'WarningController@create')->name('warning.create');
Route::post('/complain/store', 'WarningController@store')->name('warning.store');
Route::get('/complain/list', 'WarningController@warningShowDH')->name('warning.showDH');
Route::post('/complain/dh/store', 'WarningController@warningDH_Store')->name('warning.dh.store');
Route::get('/complain/delete/{wid}', 'WarningController@delete')->name('warning.delete');
Route::get('/complain/forward/{wid}', 'WarningController@warningForward')->name('warning.forward');
Route::get('/appeal/create', 'WarningController@appealCreate')->name('appeal.create');
Route::post('/appeal/store', 'WarningController@appealStore')->name('appeal.store');
Route::get('/complain/forwarded/list', 'WarningController@warningShowHR')->name('warning.showHR');
Route::get('/complain/appeal/{wid}/show', 'WarningController@appealShow')->name('warning.appeal.show');
Route::get('/complain/appeal/{wid}/accept', 'WarningController@appealAccept')->name('warning.appeal.accept');
Route::get('/complain/appeal-reject/{wid}/hearing', 'WarningController@appealRejectHearing')->name('warning.appeal.reject.hearing');
Route::get('/complain/verbal-hearing/{wid}/create', 'WarningController@verbalHearingCreate')->name('verbalHearing.create');
Route::post('/verbal-hearing/store', 'WarningController@verbalHearingStore')->name('verbalHearing.store');
Route::get('/complain/written-hearing/{wid}/create', 'WarningController@writtenHearingCreate')->name('writtenHearing.create');
Route::post('/written-hearing/store', 'WarningController@writtenHearingStore')->name('writtenHearing.store');

Route::get('/employee/create', 'EmployeeController@create')->name('employee.create');
Route::post('/employee/store', 'EmployeeController@store')->name('employee.store');
Route::post('/employee/create/from-user', 'EmployeeController@createFromUser')->name('employee.create.fromUser');
Route::get('/employee/create/{uid}', 'EmployeeController@createFromUserDummy')->name('employee.create.fromUser.dummy');
Route::get('/employee/edit', 'EmployeeController@edit')->name('employee.edit');
Route::post('/employee/edit', 'EmployeeController@editOne')->name('employee.edit.1');
Route::get('/employee/edit/{eid}', 'EmployeeController@editForm')->name('employee.edit.dummy');
Route::post('/employee/update/{eid}', 'EmployeeController@update')->name('employee.update');

Route::get('/Increment-Policy', 'IncrementpolicyController@index')->name('increment.policy');
Route::post('/Increment-Policy/update', 'IncrementpolicyController@update')->name('increment.policy.update');
Route::get('/Increment', 'IncrementController@index')->name('increment');
Route::post('/Increment/employee/{eid}', 'IncrementController@incrementEmployee')->name('increment.employee');
Route::post('/Promote/Employee', 'IncrementController@promote')->name('promote.employee');


Route::get('/transfer/release', 'BranchController@transferRelease')->name('transfer.release');
Route::post('/transfer/release/submit', 'BranchController@transferReleaseSubmit')->name('transfer.release.submit');
Route::get('/transfer/join', 'BranchController@transferJoin')->name('transfer.join');
Route::post('/transfer/join/submit/{eid}', 'BranchController@joinSubmit')->name('transfer.join.submit');

Route::get('/Leave-Application', 'LeaveController@application')->name('leave.application');
Route::get('/applied-leave-date/{lid}/delete', 'LeaveController@appliedLeaveDateDelete')->name('applied.leave.delete');
Route::post('/Leave-Application-submit/{uid}', 'LeaveController@applicationSubmit')->name('leave.application.submit');
Route::get('/Leave-Application-View/{uid}', 'LeaveController@applicationView')->name('leave.application.view');
Route::get('/Leave-Application/Reject/{lid}/HR', 'LeaveController@applicationRejectHR')->name('leave.application.reject.hr');
Route::post('/Leave-Application-Forward', 'LeaveController@applicationForward')->name('leave.application.forward');
Route::get('/Leave-Application-View-From-Department/{uid}', 'LeaveController@applicationViewDH')->name('leave.application.view.DH');
Route::get('/Leave-Application/Reject/{lid}/DH', 'LeaveController@applicationRejectDH')->name('leave.application.reject.dh');
Route::post('/Leave-Application-Approve', 'LeaveController@applicationApprove')->name('leave.application.approve');
Route::post('/Leave/Entry/DH', 'LeaveController@leaveEntryDH')->name('leave.entry.dh');

Route::get('/attendance', 'AttendanceController@index')->name('attendance.receive');
Route::post('/attendance/in/store', 'AttendanceController@attendanceIN_Store')->name('attendance.in.store');
Route::post('/attendance/out/store', 'AttendanceController@attendanceOUT_Store')->name('attendance.out.store');
Route::get('/attendance/show', 'AttendanceController@attendanceShow')->name('attendance.show');
Route::get('/attendance/ajax/{uid}/current', 'AttendanceController@currentAttendanceDateAjax')->middleware('auth');
Route::get('/attendance/{aid}/edit', 'AttendanceController@attendanceEdit')->name('attendance.edit');
Route::post('/attendance/update', 'AttendanceController@attendanceUpdate')->name('attendance.update');

Route::get('/Communication/Global', 'CommentgController@index')->name('commentg');
Route::post('/comment/global/store', 'CommentgController@store')->name('commentg.store');
Route::get('/comment-file-download/global/{cid}', 'CommentgController@downloadCommentFile')->name('download.commentg.file');
Route::get('/Communication/Single/Global/{cid}', 'CommentgController@show')->name('commentg.single.view');
Route::get('/communication-edit/global/{cid}', 'CommentgController@edit')->name('commentg.edit');
Route::post('/comment-update/global/{cid}', 'CommentgController@update')->name('commentg.update');
Route::get('/communication-edit/global/{cid}', 'CommentgController@edit')->name('commentg.edit');
Route::get('/comment-delete/global/{cid}', 'CommentgController@destroy')->name('commentg.delete');
Route::get('/Communication/Global/reply/{cid}', 'ReplygController@create')->name('replyg.create');
Route::post('/reply-store/global/{cid}', 'ReplygController@store')->name('replyg.store');
Route::get('/reply-file-download/global/{rid}', 'ReplygController@downloadReplyFile')->name('download.replyg.file');
Route::get('/Communication/Global/reply-edit/global/{rid}', 'ReplygController@edit')->name('replyg.edit');
Route::post('/reply-update/global/{rid}', 'ReplygController@update')->name('replyg.update');
Route::get('/reply-delete/global/{rid}', 'ReplygController@destroy')->name('replyg.delete');

// Increment OLD
Route::get('/increment/persons/select', 'IncrementController@selectPersons')->name('increment.persons.select');
Route::post('/increment/persons/selected', 'IncrementController@selectedPersons')->name('increment.persons.selected');
Route::get('/increment/show/hr', 'IncrementController@showInHR')->name('increment.show.hr');
Route::post('/increment/store/hr', 'IncrementController@storeHR')->name('increment.store.hr');
Route::get('/increment/show/ceo', 'IncrementController@showCEO')->name('increment.show.ceo');
Route::post('/increment/accept/ceo', 'IncrementController@acceptCEO')->name('increment.accept.ceo');

Route::get('/message/create', 'PrivateMessageController@createNewMessage')->name('message.create');
Route::post('/message/send', 'PrivateMessageController@sendNewMessage')->name('message.send');
Route::get('/message/sent', 'PrivateMessageController@sentMessages')->name('message.sent');
Route::get('/message/sent/{mid}/show', 'PrivateMessageController@sentMessageShow')->name('message.sent.show');
Route::get('/message/sent/{mid}/delete', 'PrivateMessageController@deleteSentMessage')->name('message.sent.delete');
Route::get('/message/{id}/file/download', 'PrivateMessageController@downloadMessageFile')->name('message.file.download');
Route::get('/message/inbox', 'PrivateMessageController@inbox')->name('message.inbox');
Route::get('/message/{mid}/show', 'PrivateMessageController@messageShow')->name('message.show');
Route::post('/message/reply', 'PrivateMessageController@messageReply')->name('message.reply');
Route::get('/message/inbox/{mid}/delete', 'PrivateMessageController@deleteInboxMessage')->name('message.inbox.delete');
Route::get('/message/inbox/show/{mid}/delete', 'PrivateMessageController@deleteInboxShowMessage')->name('message.inbox.show.delete');

Route::post('/comment/store/{did}/{pid}', 'CommentController@store')->name('comment.store');
Route::get('/comment-file-download/{cid}', 'CommentController@downloadCommentFile')->name('download.comment.file');
Route::get('/comment-edit/{cid}/{did}/{pid}', 'CommentController@edit')->name('comment.edit');
Route::post('/comment-update/{cid}/{did}/{pid}', 'CommentController@update')->name('comment.update');
Route::get('/comment-delete/{cid}/{did}/{pid}', 'CommentController@destroy')->name('comment.delete');
Route::get('/reply-create/{cid}/{did}/{pid}', 'ReplyController@create')->name('reply.create');
Route::post('/reply-store/{cid}/{did}/{pid}', 'ReplyController@store')->name('reply.store');
Route::get('/reply-file-download/{rid}', 'ReplyController@downloadReplyFile')->name('download.reply.file');
Route::get('/reply-edit/{rid}/{cid}/{did}/{pid}', 'ReplyController@edit')->name('reply.edit');
Route::post('/reply-update/{rid}/{did}/{pid}', 'ReplyController@update')->name('reply.update');
Route::get('/reply-delete/{rid}/{did}/{pid}', 'ReplyController@destroy')->name('reply.delete');

Route::post('/department-store/{pid}', 'DepartmentController@store')->name('store.department');
Route::post('/department-update/{did}/{pid}', 'DepartmentController@update')->name('update.department');
Route::get('/Project-Details-Per-Department/Employee/{did}/{pid}', 'DepartmentController@departmentDetailsEmployee')->name('department.details.employee');

Route::get('/KPI', 'KpiController@index')->name('kpi');
Route::get('/KPI/Setup', 'KpisetupController@index')->name('kpi.setup');
Route::post('/KPI/Setup/update', 'KpisetupController@update')->name('kpi.setup.update');
Route::get('/KPI/Voting-on', 'KpisetupController@kpiVotingOn')->name('kpi.voting.on');
Route::get('/KPI/Vote', 'KpivoteController@index')->name('kpi.vote');
Route::post('/KPI/Vote', 'KpivoteController@store')->name('kpi.vote.store');
Route::get('/KPI/Calculate', 'KpiController@calculate')->name('kpi.calculate');

Route::get('/Tax/Setup', 'TaxController@setup')->name('tax.setup');
Route::post('/Tax/isGross', 'TaxController@isGross')->name('tax.isGross');
Route::post('/Tax/Default/Update', 'TaxController@defaultUpdate')->name('tax.default.update');
Route::post('/Tax/Store', 'TaxController@store')->name('tax.store');
Route::get('/Tax/Delete/{tid}', 'TaxController@destroy')->name('tax.delete');
Route::get('/Tax/Edit/{tid}', 'TaxController@edit')->name('tax.edit');
Route::post('/Tax/Update/{tid}', 'TaxController@update')->name('tax.update');

Route::get('/Salary', 'SalaryController@index')->name('salary');
Route::get('/Salary-Generate/{is_over}/{is_pay_over}', 'SalaryController@generate')->name('salary.generate');
Route::get('/Salary/Edit/{sid}', 'SalaryController@edit')->name('salary.edit');
Route::post('/Salary/update/{sid}', 'SalaryController@update')->name('salary.update');
Route::get('/salary/csv/download', 'SalaryController@salaryCsvDownload')->name('salary.csv.download');

// Project Management New
Route::get('/Tasks-Management/General', 'TaskController2@general')->name('task.general');
Route::get('/ajax/get-department-of-project', 'TaskController2@ajaxDfromP');
Route::get('/ajax/get-tasks-of-project', 'TaskController2@ajaxTfromP');
Route::get('/ajax/task-status-change', 'TaskController2@ajaxTSC');
Route::get('/Tasks-Management/General/Department/{did}/Comment', 'TaskController2@departmentComment')->name('department.comment');
Route::get('/Tasks-Management/General/Department/Comment/{cid}/reply', 'TaskController2@departmentReply')->name('department.reply');
Route::post('/Tasks-Management/General/Department/{did}/Comment/store', 'TaskController2@departmentCommentStore')->name('department.comment.store');
Route::post('/Tasks-Management/General/Department/Reply/{cid}/store', 'TaskController2@departmentReplyStore')->name('department.reply.store');
Route::get('/Tasks-Management/General/Department/{did}/Comment/edit/{cid}', 'TaskController2@departmentCommentEdit')->name('department.comment.edit');
Route::get('/Tasks-Management/General/Department/Comment/reply/{rid}/edit', 'TaskController2@departmentReplyEdit')->name('department.reply.edit');
Route::post('/Tasks-Management/General/Department/Comment/update/{cid}', 'TaskController2@departmentCommentUpdate')->name('department.comment.update');
Route::post('/Tasks-Management/General/Department/Reply/update/{rid}', 'TaskController2@departmentReplyUpdate')->name('department.reply.update');
Route::get('/Department/Comment/download/{cid}', 'TaskController2@departmentCommentDownload')->name('download.department.comment.file');
Route::get('/Department/Reply/download/{rid}', 'TaskController2@departmentReplyDownload')->name('download.department.reply.file');
Route::get('/Department/Comment/delete/{cid}', 'TaskController2@departmentCommentDelete')->name('department.comment.delete');
Route::get('/Department/reply/delete/{rid}', 'TaskController2@departmentReplyDelete')->name('department.reply.delete');
Route::get('/Tasks-Management/General/Task/{tid}/Comment', 'TaskController2@taskComment')->name('task.comment');
Route::get('/Tasks-Management/General/Task/Comment/{cid}/reply', 'TaskController2@taskReply')->name('task.reply');
Route::post('/Tasks-Management/General/Task/{tid}/Comment/store', 'TaskController2@taskCommentStore')->name('task.comment.store');
Route::post('/Tasks-Management/General/task/Reply/{cid}/store', 'TaskController2@taskReplyStore')->name('task.reply.store');
Route::get('/Tasks-Management/General/Task/Comment/edit/{cid}', 'TaskController2@taskCommentEdit')->name('task.comment.edit');
Route::get('/Tasks-Management/General/Task/Comment/reply/{rid}/edit', 'TaskController2@taskReplyEdit')->name('task.reply.edit');
Route::post('/Tasks-Management/General/Task/Comment/update/{cid}', 'TaskController2@taskCommentUpdate')->name('task.comment.update');
Route::post('/Tasks-Management/General/task/Reply/update/{rid}', 'TaskController2@taskReplyUpdate')->name('task.reply.update');
Route::get('/task/Comment/download/{cid}', 'TaskController2@taskCommentDownload')->name('download.task.comment.file');
Route::get('/task/Reply/download/{rid}', 'TaskController2@taskReplyDownload')->name('download.task.reply.file');
Route::get('/task/Comment/delete/{cid}', 'TaskController2@taskCommentDelete')->name('task.comment.delete');
Route::get('/task/reply/{rid}', 'TaskController2@taskReplyDelete')->name('task.reply.delete');
Route::get('/Tasks-Management/General/Submit-Report/{tid}', 'TaskController2@submitReport')->name('submit.report');
Route::post('/Tasks-Management/General/Submit-Report/{tid}', 'TaskController2@submitReportStore')->name('submit.report.store');

Route::get('/Tasks-Management/Project-Manager', 'TaskController3@projectManager')->name('task.project.manager');
Route::get('/ajax/manager/get-tasks-of-project', 'TaskController3@ajaxMTfromP');
Route::get('/ajax/manager/get-department-of-project', 'TaskController3@ajaxMDfromP');
Route::post('/Tasks-Management/Project-Manager/Project/Store', 'TaskController3@projectStore')->name('project.store');
Route::get('/ajax/manager/department_store', 'TaskController3@departmentStore');
Route::post('/ajax/manager/task_store', 'TaskController3@taskStore')->name('task.store');
Route::get('/Tasks-Management/Tak-details/{tid}', 'TaskController3@taskDetail')->name('task.detail');
Route::post('/Tasks-Management/Tak-details/{tid}/update', 'TaskController3@taskDetailUpdate')->name('task.detail.update');
Route::get('/Tasks-Management/Tak-details/{tid}/submit-file-download', 'TaskController3@downloadTaskFile')->name('downloadTaskFile');
Route::get('/task-accept-2/{tid}', 'TaskController3@taskAccept')->name('task.accept2');
Route::get('/task-reopen-2/{tid}', 'TaskController3@taskReopen')->name('task.reopen2');




// Project Management
Route::get('/Tasks/Index', 'TaskController@index')->name('task.index');
Route::get('/Tasks/create-initial-project', 'TaskController@createInitialProject')->name('task.create.initial.project');
Route::post('/Tasks/store-initial-project', 'TaskController@storeInitialProject')->name('task.store.initial.project');
Route::get('/Project-View/{pid}', 'TaskController@ProjectView')->name('Project.View');
Route::get('/Project-Delete/{pid}', 'TaskController@ProjectDelete')->name('project.delete');
Route::get('/Report-View/{tid}', 'TaskController@viewReport')->name('view.report');
Route::get('/download-Report-file/{tid}', 'TaskController@downloadReportFile')->name('download.report.file');
Route::get('/task-reopen/{tid}', 'TaskController@taskReopen')->name('task.reopen');
Route::get('/task-accept/{tid}', 'TaskController@taskAccept')->name('task.accept');
Route::post('/Tasks/update-project-title/{pid}', 'TaskController@updateProjectTitle')->name('update.project.title');
Route::post('/Tasks/update-task/{tid}/{did}/{pid}', 'TaskController@updateTask')->name('update.task');
Route::post('/Tasks/store-task/{did}/{pid}', 'TaskController@storeTask')->name('store.task');
Route::get('/Tasks-Submit-View/{tid}/{did}/{pid}', 'TaskController@taskSubmitView')->name('task.submit.view');
Route::post('/Tasks-Submit-Store/{tid}/{did}/{pid}', 'TaskController@taskSubmitStore')->name('task.submit.store');
Route::get('/Tasks/Index-For-Employee', 'TaskController@indexForEmployee')->name('task.index.employee');
Route::get('/Tasks-View-Employee/{tid}', 'TaskController@taskViewEmployee')->name('task.view.employee');
Route::get('/Project-View-Employee/{pid}', 'TaskController@ProjectViewEmployee')->name('Project.View.Employee');

Route::post('/comment/task/store/{tid}', 'CommenttController@store')->name('commentt.store');
Route::get('/comment-file-download/task/{cid}', 'CommenttController@downloadCommentFile')->name('download.commentt.file');
Route::get('/comment-edit/task/{cid}', 'CommenttController@edit')->name('commentt.edit');
Route::post('/comment-update/task/{cid}', 'CommenttController@update')->name('commentt.update');
Route::get('/comment-delete/task/{cid}', 'CommenttController@destroy')->name('commentt.delete');
Route::get('/reply-create/task/{cid}', 'ReplytController@create')->name('replyt.create');
Route::post('/reply-store/task/{cid}/{tid}', 'ReplytController@store')->name('replyt.store');
Route::get('/reply-file-download/task/{rid}', 'ReplytController@downloadReplyFile')->name('download.replyt.file');
Route::get('/reply-edit/task/{rid}', 'ReplytController@edit')->name('replyt.edit');
Route::post('/reply-update/task/{rid}', 'ReplytController@update')->name('replyt.update');
Route::get('/reply-delete/task/{rid}', 'ReplytController@destroy')->name('replyt.delete');


Route::post('/demo-user-store', 'DemouserController@store')->name('demo.user.store');







Route::get('/User-General-Info-Search', [
    'uses' => 'UserinfoController@userInfoSearch',
    'as' => 'userinfosearch'
])->middleware('auth');
Route::post('/User-General-Info', [
    'uses' => 'UserinfoController@index',
    'as' => 'userInfo'
])->middleware('auth');
Route::post('/User-General-Info-Store/{uid}', [
    'uses' => 'UserinfoController@storeAndUpdate',
    'as' => 'userInfo.store'
])->middleware('auth');
Route::get('/User-Search-Role', [
    'uses' => 'HomeController@userSearchRole',
    'as' => 'user.search.role'
])->middleware('auth');
Route::post('/User-Role', [
    'uses' => 'HomeController@userRole',
    'as' => 'user.role'
])->middleware('auth');
Route::get('/User-Role-Details/{uid}', [
    'uses' => 'HomeController@userRoleShow',
    'as' => 'userRoleShow'
])->middleware('auth');
Route::post('/User-Role-Info-Store/{uid}', [
    'uses' => 'HomeController@RoleStoreAndUpdate',
    'as' => 'userRole.store'
])->middleware('auth');
Route::get('/User-Job-Info-Search', [
    'uses' => 'UserjobinfoController@userInfoSearch',
    'as' => 'userJobInfoSearch'
])->middleware('auth');
Route::post('/User-Job-Info', [
    'uses' => 'UserjobinfoController@index',
    'as' => 'userJobInfo'
])->middleware('auth');
Route::post('/User-Job-Info-Store/{uid}', [
    'uses' => 'UserjobinfoController@storeAndUpdate',
    'as' => 'userJobInfo.store'
])->middleware('auth');

Route::get('/User-Loan-Info-Search', [
    'uses' => 'UserloanController@userInfoSearch',
    'as' => 'userLoanInfoSearch'
])->middleware('auth');
Route::post('/User-Loan-Info', [
    'uses' => 'UserloanController@index',
    'as' => 'userLoanInfo'
])->middleware('auth');
Route::get('/User-Loan-Info/show/{uid}', [
    'uses' => 'UserloanController@userLoanInfoShow',
    'as' => 'userLoanInfoShow'
])->middleware('auth');
Route::post('/User-Loan-Info-Store/{uid}', [
    'uses' => 'UserloanController@store',
    'as' => 'userLoanInfo.store'
])->middleware('auth');
Route::get('/User-Loan-Info-Edit/{lid}', [
    'uses' => 'UserloanController@edit',
    'as' => 'user.loan.edit'
])->middleware('auth');
Route::post('/User-Loan-Info-Update/{lid}', [
    'uses' => 'UserloanController@update',
    'as' => 'user.loan.update'
])->middleware('auth');

Route::get('/User-Pay-Info-Search', [
    'uses' => 'UserpayController@userInfoSearch',
    'as' => 'userPayInfoSearch'
])->middleware('auth');
Route::post('/User-Pay-Info', [
    'uses' => 'UserpayController@index',
    'as' => 'userPayInfo'
])->middleware('auth');
Route::post('/User-Pay-Info-Store/{uid}', [
    'uses' => 'UserpayController@storeAndUpdate',
    'as' => 'userPayInfo.store'
])->middleware('auth');
Route::get('/User-Pay-Info/{uid}/show', [
    'uses' => 'UserpayController@userPayInfoShow',
    'as' => 'userPayInfoShow'
])->middleware('auth');



Route::get('/User-General-Info/{uid}/show', [
    'uses' => 'UserinfoController@userInfoShow',
    'as' => 'userInfoShow'
])->middleware('auth');
Route::get('/User-Job-Info/{uid}/show', [
    'uses' => 'UserjobinfoController@userJobInfoShow',
    'as' => 'userJobInfoShow'
])->middleware('auth');

Route::get('/Account-Close', [
    'uses' => 'TerminationController@index',
    'as' => 'account.close'
])->middleware('auth');
Route::post('/Account-Close-Permanently', [
    'uses' => 'TerminationController@ac',
    'as' => 'account.close.user'
])->middleware('auth');


///////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////
///
///
///

Route::get('/user/{id}/cv', 'UserinfoController@cv')->name('user.cv');





