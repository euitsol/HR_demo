<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Commentt;
use App\Department;
use App\Dependency;
use App\Project;
use App\Reply;
use App\Replyt;
use App\Task;
use App\User;
use App\Userassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TaskController2 extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function general()
    {
        // no need of any permission
        $us = Userassign::where('user_id', Auth::id())->get()->groupBy('project_id');
        $projects = [];
        $departments = [];
        $tasks = null;
        $j = 0;
        foreach ($us as $u) {
            $projects[] = Project::find($u[0]->project_id);
            if ($j == 0) {
                // get only the departments where user has assigned jobs
                $uss = Userassign::where('user_id', Auth::id())->where('project_id', $u[0]->project_id)->get()->groupBy('department_id');
                $jj = 0;
                foreach ($uss as $uu) {
                    $departments[] = Department::find($uu[0]->department_id);
                    if ($jj == 0) {
                        $tasks = Task::where('project_id', $u[0]->project_id)->where('department_id', $uu[0]->department_id)->get();
                    }
                    $jj++;
                }
            }
            $j++;
        }
        if ($tasks != null) {
            foreach ($tasks as $t) {
                // add dependencies
//                $t['can_submit'] = 1;
                $dts = [];
                $ds = Dependency::where('task_id', $t->id)->get();
                if (count($ds) > 0) {
                    foreach ($ds as $d) {
                        $dts[] = Task::find($d->dependency);
                    }
                }
                $t['dependencies'] = $dts;
//                if (!empty($dts)){
//                    foreach ($dts as $d){
//                        if (($d->submit * 1) == 0){
//                            $t['can_submit'] = 0;
//                            break;
//                        }
//                    }
//                }
            }
        }
        return view('taskNew.general.index', compact('projects', 'departments', 'tasks'));
    }


    public function ajaxDfromP()
    {
        if (request()->ajax()) {
            // no need of any permission
            $pid = $_GET['pid'];
            $departments = [];
            $uss = Userassign::where('user_id', Auth::id())->where('project_id', $pid)->get()->groupBy('department_id');
            foreach ($uss as $uu) {
                $departments[] = Department::find($uu[0]->department_id);
            }
            $html = '';
            if (!empty($departments)) {
                foreach ($departments as $i => $d) {
                    $html .= '
                        <div class="project-inner-area">
                            <a href="javascript:void(0)" class="list-group-item departments ' . ($i == 0 ? "active" : "") . '" did="' . $d->id . '">
                                <span class="fa fa-circle text-success"></span> ' . $d->title . '
                            </a>
                            <div class="pull-right">
                                <a href="' .
                        route('department.comment', ['did' => $d->id])
                        . '" target="_blank" title="Department Comment"><span class="fa fa-comments"></span></a>
                            </div>
                        </div>
                        ';
                }
            }
            return $html;
        } else {
            abort(403);
        }
    }

    public function ajaxTfromP()
    {
        if (request()->ajax()) {
            // no need of any permission
            $isPid = $_GET['is_pid'];
            if (($isPid * 1) == 1) {
                $pid = $_GET['pid'];
                // must get the userAssigned first department
                $uss = Userassign::where('user_id', Auth::id())->where('project_id', $pid)->get()->groupBy('department_id');
                $did = 0;
                $jj = 0;
                foreach ($uss as $uu) {
                    if ($jj == 0) {
                        $did = $uu[0]->department_id;
                    } else {
                        break;
                    }
                    $jj++;
                }
            } else {
                $did = $_GET['did'];
                $pid = Department::find($did)->project_id;
            }
            $tasks = Task::where('project_id', $pid)->where('department_id', $did)->get();
            $html = '';
            if (count($tasks) > 0) {
                foreach ($tasks as $t) {
                    // add dependencies
                    $dts = [];
                    $ds = Dependency::where('task_id', $t->id)->get();
                    if (count($ds) > 0) {
                        foreach ($ds as $d) {
                            $dts[] = Task::find($d->dependency);
                        }
                    }
                    $t['dependencies'] = $dts;
                }
                $html .= '<div class="col-md-4">
                    <h3>To-do List</h3>
                    <div class="tasks" id="tasks">';
                foreach ($tasks as $t) {
                    if (($t->progress * 1) == 0) {
                        $html .= '<div class="task-item task-info cursor2">
                                    <div class="task-text">
                                        <p>' . $t->title . '</p>
                                        ' . $t->remark . '';
                        if ($t->dependencies) {
                            $html .= '<br>';
                            foreach ($t->dependencies as $td) {
                                $html .= '<a href="' . route('task.comment', ['tid' => $td->id]) . '" target="_blank" title="Task Comment">' . $td->title . '</a>';
                            }
                        }
                        $html .= '</div>
                                    <div class="task-footer" tid="' . $t->id . '">
                                        <div class="pull-left"><span class="fa fa-clock-o"></span> ' . $t->deadline . '
                                        </div>
                                        <div class="pull-right"><a href="' . route('task.comment', ['tid' => $t->id]) . '" target="_blank" title="Task Comment"><span class="fa fa-comments"></span></a>
                                        </div>
                                    </div>
                                </div>';
                    }
                }
                $html .= ' </div>
                </div>
                <div class="col-md-4">
                    <h3>In Progress</h3>
                    <div class="tasks" id="tasks_progreess">';
                foreach ($tasks as $t) {
                    if ((($t->progress * 1) == 1) && (($t->submit * 1) == 0)) {
                        $html .= '<div class="task-item task-info cursor2">
                                    <div class="task-text">
                                        <p>' . $t->title . '</p>
                                        ' . $t->remark . '';
                        if ($t->dependencies) {
                            $html .= '<br>';
                            foreach ($t->dependencies as $td) {
                                $html .= '<a href="' . route('task.comment', ['tid' => $td->id]) . '" target="_blank" title="Task Comment">' . $td->title . '</a>';

                            }
                        }
                        $html .= '</div>
                                    <div class="task-footer" tid="' . $t->id . '">
                                        <div class="pull-left"><span class="fa fa-clock-o"></span> ' . $t->deadline . '
                                        </div>
                                        <div class="pull-right"><a href="' . route('task.comment', ['tid' => $t->id]) . '" target="_blank" title="Task Comment"><span class="fa fa-comments"></span></a>
                                        </div>
                                    </div>
                                </div>';
                    }
                }
                $html .= '<div class="task-drop push-down-10">
                            <span class="fa fa-cloud"></span>
                            Drag your task here to start working on it
                        </div>
                        </div>
                </div>
                <div class="col-md-4">
                    <h3>Completed</h3>
                    <div class="tasks" id="tasks_completed">';
                foreach ($tasks as $t) {
                    if ((($t->submit * 1) == 1) && (($t->submit_accept * 1) == 0)) {
                        $html .= ' <div class="task-item task-warning task-complete cursor2">
                                    <div class="task-text">
                                        <p>' . $t->title . '</p>
                                        ' . $t->remark . '';
                        if ($t->dependencies) {
                            $html .= '<br>';
                            foreach ($t->dependencies as $td) {
                                $html .= '<a href="' . route('task.comment', ['tid' => $td->id]) . '" target="_blank" title="Task Comment">' . $td->title . '</a>';

                            }
                        }
                        $html .= '</div>
                                    <div class="task-footer" tid="' . $t->id . '">
                                        <div class="pull-left"><span class="fa fa-clock-o"></span> ' . $t->updated_at . '
                                        </div>
                                        <div class="pull-right"><a href="' . route('submit.report', ['tid' => $t->id]) . '" target="_blank" title="Submit Report"><i class="glyphicon glyphicon-envelope"></i></a>
                                        </div>
                                    </div>
                                </div>';
                    } elseif (($t->submit_accept * 1) == 1) {
                        $html .= '<div class="task-item task-primary task-complete  cursor">
                                    <div class="duplicate-task-text">
                                        <p>' . $t->title . '</p>
                                        ' . $t->remark . '';
                        if ($t->dependencies) {
                            $html .= '<br>';
                            foreach ($t->dependencies as $td) {
                                $html .= '<a href="' . route('task.comment', ['tid' => $td->id]) . '" target="_blank" title="Task Comment">' . $td->title . '</a>';
                            }
                        }
                        $html .= '</div>
                                    <div class="task-footer">
                                        <div class="pull-left">
                                            <span class="text-primary"><b>Accepted</b></span>
                                        </div>
                                    </div>
                                </div>';
                    }
                }
                $html .= ' <div class="task-drop">
                            <span class="fa fa-cloud"></span>
                            Drag your task here to finish it
                        </div></div></div>';
            }
            return $html;
        } else {
            abort(403);
        }
    }


    public function ajaxTSC()
    {
        if (request()->ajax()) {
            // no need of any permission
            $isCompleted = $_GET['is_completed'];
            $tid = $_GET['tid'];
            if (($isCompleted) == 0) {
                // in progress
                $t = Task::find($tid);
                $t->progress = 1;
                $t->submit = 0;
                $t->submit_accept = 0;
                $t->update();
            } elseif (($isCompleted) == 1) {
                // completed
                $t = Task::find($tid);
                $t->progress = 1;
                $t->submit = 1;
                $t->update();
            }
            return json_encode(['success' => true]);
        } else {
            abort(403);
        }
    }


    public function departmentComment($did)
    {
        $department = Department::find($did);
        $project = Project::find($department->project_id);
        $comments = Comment::where('department_id', $did)->paginate(10);
        foreach ($comments as $c) {
            $replies = Reply::where('comment_id', $c->id)->get();
            foreach ($replies as $r) {
                $u = User::find($r->user_id);
                $r['user_image'] = $u->image;
                $r['user_name'] = $u->name;
            }
            $c['replies'] = $replies;
            $u = User::find($c->user_id);
            $c['user_image'] = $u->image;
            $c['user_name'] = $u->name;
        }
        return view('taskNew.general.comment.index', compact('department', 'project', 'comments'));
    }


    public function departmentCommentStore(Request $request, $did)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);
        $department = Department::find($did);
        $pid = Project::find($department->project_id)->id;
        $c = new Comment;
        $c->user_id = Auth::id();
        $c->project_id = $pid;
        $c->department_id = $did;
        $c->comment = $request->comment;
        if ($request->hasFile('file')) {
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/comments', $f_name);
            $d = 'uploads/comments/' . $f_name;
            $c->file = $d;
        }
        $c->save();
        Session::flash('success', "The Comment has been posted successfully.");
        return redirect()->back();
    }


    public function departmentCommentDelete($cid)
    {
        $c = Comment::find($cid);
        if ($c->file) {
            unlink($c->file);
        }
        $c->delete();
        Session::flash('success', "The Comment has been deleted successfully.");
        return redirect()->back();
    }


    public function departmentCommentEdit($did, $cid)
    {
        $department = Department::find($did);
        $project = Project::find($department->project_id);
        $comments = Comment::where('department_id', $did)->paginate(10);
        foreach ($comments as $c) {
            $replies = Reply::where('comment_id', $c->id)->get();
            foreach ($replies as $r) {
                $u = User::find($r->user_id);
                $r['user_image'] = $u->image;
                $r['user_name'] = $u->name;
            }
            $c['replies'] = $replies;
            $u = User::find($c->user_id);
            $c['user_image'] = $u->image;
            $c['user_name'] = $u->name;
        }
        $cedit = Comment::find($cid);
        return view('taskNew.general.comment.edit', compact('department', 'project', 'comments', 'cedit'));

    }


    public function departmentCommentUpdate(Request $request, $cid)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);
        $c = Comment::find($cid);
        $c->comment = $request->comment;
        if ($request->hasFile('file')) {
            if ($c->file) {
                unlink($c->file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/comments', $f_name);
            $d = 'uploads/comments/' . $f_name;
            $c->file = $d;
        }
        $c->update();
        Session::flash('success', "The Comment has been updated successfully.");
        return redirect()->back();
    }

    public function departmentCommentDownload($cid)
    {
        $c = Comment::find($cid);
        $ext = pathinfo($c->file, PATHINFO_EXTENSION);
        $name = 'comment_file_department.' . $ext;
        return response()->download($c->file, $name);
    }


    public function departmentReply($cid)
    {
        $c = Comment::find($cid);
        $department = Department::find($c->department_id);
        $project = Project::find($c->project_id);
        $replies = Reply::where('comment_id', $cid)->get();
        foreach ($replies as $r) {
            $u = User::find($r->user_id);
            $r['user_image'] = $u->image;
            $r['user_name'] = $u->name;
        }
        $u = User::find($c->user_id);
        $c['user_image'] = $u->image;
        $c['user_name'] = $u->name;
        $c['replies'] = $replies;
        return view('taskNew.general.comment.reply.index', compact('c', 'project', 'department'));
    }


    public function departmentReplyStore(Request $request, $cid)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $c = Comment::find($cid);
        $r = new Reply;
        $r->user_id = Auth::id();
        $r->project_id = $c->project_id;
        $r->department_id = $c->department_id;
        $r->comment_id = $cid;
        $r->reply = $request->reply;
        if ($request->hasFile('file')) {
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/replies', $f_name);
            $d = 'uploads/replies/' . $f_name;
            $r->file = $d;
        }
        $r->save();
        Session::flash('success', "The Reply has been created successfully.");
        return redirect()->back();
    }


    public function departmentReplyEdit($rid)
    {
        $redit = Reply::find($rid);
        $department = Department::find($redit->department_id);
        $project = Project::find($redit->project_id);
        return view('taskNew.general.comment.reply.edit', compact('redit', 'department', 'project'));
    }


    public function departmentReplyUpdate(Request $request, $rid)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $r = Reply::find($rid);
        $r->reply = $request->reply;
        if ($request->hasFile('file')) {
            if ($r->file) {
                unlink($r->file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/replies', $f_name);
            $d = 'uploads/replies/' . $f_name;
            $r->file = $d;
        }
        $r->update();
        Session::flash('success', "The Reply has been updated successfully.");
        return redirect()->route('department.reply', ['cid' => $r->comment_id]);
    }


    public function departmentReplyDelete($rid)
    {
        $r = Reply::find($rid);
        if ($r->file) {
            unlink($r->file);
        }
        $r->delete();
        Session::flash('success', "The Reply has been deleted successfully.");
        return redirect()->back();
    }


    public function departmentReplyDownload($rid)
    {
        $r = Reply::find($rid);
        $ext = pathinfo($r->file, PATHINFO_EXTENSION);
        $name = 'reply_file_department.' . $ext;
        return response()->download($r->file, $name);
    }


    public function taskComment($tid)
    {
        $task = Task::find($tid);
        $dts = [];
        $ds = Dependency::where('task_id', $task->id)->get();
        if (count($ds) > 0) {
            foreach ($ds as $d) {
                $dts[] = Task::find($d->dependency);
            }
        }
        $task['dependencies'] = $dts;
        $project = Project::find($task->project_id);
        $department = Department::find($task->department_id);
        $comments = Commentt::where('task_id', $tid)->get();
        foreach ($comments as $c) {
            $replies = Replyt::where('commentt_id', $c->id)->get();
            foreach ($replies as $r) {
                $u = User::find($r->user_id);
                $r['user_image'] = $u->image;
                $r['user_name'] = $u->name;
            }
            $c['replies'] = $replies;
            $u = User::find($c->user_id);
            $c['user_image'] = $u->image;
            $c['user_name'] = $u->name;
        }
        return view('taskNew.general.task_comment.index', compact('task', 'project', 'department', 'comments'));
    }


    public function taskCommentStore(Request $request, $tid)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);
        $c = new Commentt;
        $c->user_id = Auth::id();
        $c->task_id = $tid;
        $c->commentt = $request->comment;
        if ($request->hasFile('file')) {
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/comments', $f_name);
            $d = 'uploads/comments/' . $f_name;
            $c->file = $d;
        }
        $c->save();
        Session::flash('success', "The Comment has been posted successfully.");
        return redirect()->back();
    }


    public function taskCommentDelete($cid)
    {
        $c = Commentt::find($cid);
        if ($c->file) {
            unlink($c->file);
        }
        $c->delete();
        Session::flash('success', "The Comment has been deleted successfully.");
        return redirect()->back();
    }


    public function taskCommentDownload($cid)
    {
        $c = Commentt::find($cid);
        $ext = pathinfo($c->file, PATHINFO_EXTENSION);
        $name = 'comment_file_department.' . $ext;
        return response()->download($c->file, $name);
    }


    public function taskCommentEdit($cid)
    {
        $cedit = Commentt::find($cid);
        $task = Task::find($cedit->task_id);
        $dts = [];
        $ds = Dependency::where('task_id', $task->id)->get();
        if (count($ds) > 0) {
            foreach ($ds as $d) {
                $dts[] = Task::find($d->dependency);
            }
        }
        $task['dependencies'] = $dts;
        $project = Project::find($task->project_id);
        $department = Department::find($task->department_id);
        $comments = Commentt::where('task_id', $task->id)->get();
        foreach ($comments as $c) {
            $replies = Replyt::where('commentt_id', $c->id)->get();
            foreach ($replies as $r) {
                $u = User::find($r->user_id);
                $r['user_image'] = $u->image;
                $r['user_name'] = $u->name;
            }
            $c['replies'] = $replies;
            $u = User::find($c->user_id);
            $c['user_image'] = $u->image;
            $c['user_name'] = $u->name;
        }
        return view('taskNew.general.task_comment.edit', compact('task', 'project', 'department', 'cedit', 'comments'));
    }


    public function taskCommentUpdate(Request $request, $cid)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);
        $c = Commentt::find($cid);
        $c->commentt = $request->comment;
        if ($request->hasFile('file')) {
            if ($c->file) {
                unlink($c->file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/comments', $f_name);
            $d = 'uploads/comments/' . $f_name;
            $c->file = $d;
        }
        $c->update();
        Session::flash('success', "The Comment has been updated successfully.");
        return redirect()->back();
    }


    public function taskReply($cid)
    {
        $c = Commentt::find($cid);
        $task = Task::find($c->task_id);
        $dts = [];
        $ds = Dependency::where('task_id', $task->id)->get();
        if (count($ds) > 0) {
            foreach ($ds as $d) {
                $dts[] = Task::find($d->dependency);
            }
        }
        $task['dependencies'] = $dts;
        $project = Project::find($task->project_id);
        $department = Department::find($task->department_id);
        $replies = Replyt::where('commentt_id', $c->id)->get();
        foreach ($replies as $r) {
            $u = User::find($r->user_id);
            $r['user_image'] = $u->image;
            $r['user_name'] = $u->name;
        }
        $c['replies'] = $replies;
        $u = User::find($c->user_id);
        $c['user_image'] = $u->image;
        $c['user_name'] = $u->name;
        return view('taskNew.general.task_comment.reply.index', compact('task', 'project', 'department', 'c'));
    }


    public function taskReplyStore(Request $request, $cid)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $c = Commentt::find($cid);
        $r = new Replyt;
        $r->user_id = Auth::id();
        $r->commentt_id = $cid;
        $r->task_id = $c->task_id;
        $r->replyt = $request->reply;
        if ($request->hasFile('file')) {
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/replies', $f_name);
            $d = 'uploads/replies/' . $f_name;
            $r->file = $d;
        }
        $r->save();
        Session::flash('success', "The Reply has been created successfully.");
        return redirect()->back();
    }


    public function taskReplyDownload($rid)
    {
        $r = Replyt::find($rid);
        $ext = pathinfo($r->file, PATHINFO_EXTENSION);
        $name = 'reply_file_department.' . $ext;
        return response()->download($r->file, $name);
    }


    public function taskReplyDelete($rid)
    {
        $r = Replyt::find($rid);
        if ($r->file) {
            unlink($r->file);
        }
        $r->delete();
        Session::flash('success', "The Reply has been deleted successfully.");
        return redirect()->back();
    }


    public function taskReplyEdit($rid)
    {
        $redit = Replyt::find($rid);
        $task = Task::find($redit->task_id);
        $dts = [];
        $ds = Dependency::where('task_id', $task->id)->get();
        if (count($ds) > 0) {
            foreach ($ds as $d) {
                $dts[] = Task::find($d->dependency);
            }
        }
        $task['dependencies'] = $dts;
        $project = Project::find($task->project_id);
        $department = Department::find($task->department_id);
        return view('taskNew.general.task_comment.reply.edit', compact('task', 'project', 'department', 'redit'));
    }


    public function taskReplyUpdate(Request $request, $rid)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $r = Replyt::find($rid);
        $r->replyt = $request->reply;
        if ($request->hasFile('file')) {
            if ($r->file) {
                unlink($r->file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/replies', $f_name);
            $d = 'uploads/replies/' . $f_name;
            $r->file = $d;
        }
        $r->update();
        Session::flash('success', "The Reply has been updated successfully.");
        return redirect()->route('task.reply', ['cid' => $r->commentt_id]);
    }


    public function submitReport($tid)
    {
        $task = Task::find($tid);
        $dts = [];
        $ds = Dependency::where('task_id', $task->id)->get();
        if (count($ds) > 0) {
            foreach ($ds as $d) {
                $dts[] = Task::find($d->dependency);
            }
        }
        $task['dependencies'] = $dts;
        $project = Project::find($task->project_id);
        $department = Department::find($task->department_id);
        return view('taskNew.general.report.index', compact('task', 'project', 'department'));
    }


    public function submitReportStore(Request $request, $tid)
    {
        $this->validate($request, [
            'report' => 'required',
        ]);
        $t = Task::find($tid);
        $t->submit_report = $request->report;
        if ($request->hasFile('file')) {
            if ($t->submit_file) {
                unlink($t->submit_file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/task_reports', $f_name);
            $d = 'uploads/task_reports/' . $f_name;
            $t->submit_file = $d;
        }
        $t->update();
        Session::flash('success', "The report has been submitted successfully.");
        return redirect()->back();
    }
}
