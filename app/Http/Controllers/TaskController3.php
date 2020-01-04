<?php

namespace App\Http\Controllers;

use App\Department;
use App\Project;
use App\Task;
use App\User;
use App\Userassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TaskController3 extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function projectManager()
    {
        if (Auth::user()->can('project_manager')) {
            $departments = null;
            $tasks = null;
            $projects = Project::where('branch_id', Auth::user()->branch_id)->get();
            if (count($projects) > 0) {
                $departments = Department::where('project_id', $projects[0]->id)->get();
                if (count($departments) > 0) {
                    $tasks = Task::where('department_id', $departments[0]->id)->get();
                }
            }
            $users = User::where('branch_id', Auth::user()->branch_id)->get();
            foreach ($users as $u) {
                $n = explode(' ', $u->name);
                $u['title'] = end($n);
            }
//        dd($projects[0]->id);
            return view('taskNew.project_manager.index', compact('projects', 'departments', 'tasks', 'users'));
        } else {
            abort(403);
        }
    }


    public function ajaxMTfromP()
    {
        if (request()->ajax() && Auth::user()->can('project_manager')) {
            $isPid = $_GET['is_pid'];
            if (($isPid * 1) == 1) {
                $did = null;
                $pid = $_GET['pid'];
                $d = Department::where('project_id', $pid)->first();
                if ($d) {
                    $did = $d->id;
                }
            } else {
                $did = $_GET['did'];
                $pid = Department::find($did)->project_id;
            }
            $tasks = [];
            if ($did) {
                $tasks = Task::where('project_id', $pid)->where('department_id', $did)->get();
            }
            $html = '';
            if (count($tasks) > 0) {
                foreach ($tasks as $i => $t) {
                    $html .= '<div class="project-inner-area">
                                                <a href="' . route('task.detail', ['tid' => $t->id]) . '"
                                                   class="list-group-item"
                                                   tid="' . $t->id . '" target="_blank">
                                                    <span class="fa fa-circle ';
                    if (($t->submit_accept * 1) == 1) {
                        $html .= 'text-success';
                    } elseif (($t->submit * 1) == 1) {
                        $html .= 'text-info';
                    } else {
                        $html .= 'text-secondary';
                    }
                    $html .= '"></span> ' . $t->title . '</a></div>';
                }
                $html .= '<small class="m-1 text-secondary">Click on task for details</small>';
            } else {
                $html = 'No Task to show';
            }
            return $html;
        } else {
            return json_encode(['success' => false]);
        }
    }


    public function ajaxMDfromP()
    {
        if (request()->ajax() && Auth::user()->can('project_manager')) {
            $pid = $_GET['pid'];
            $departments = Department::where('project_id', $pid)->get();
            $html = '';
            if (count($departments) > 0) {
                foreach ($departments as $i => $d) {
                    $html .= '<a href="javascript:void(0)"
                                               class="list-group-item departments ' . ($i == 0 ? "active" : "") . '"
                                               did="' . $d->id . '">
                                                <span class="fa fa-circle text-secondary"></span> ' . $d->title . '
                                            </a>';
                }
            } else {
                $html = 'No Department to show';
            }
            return $html;
        } else {
            return json_encode(['success' => false]);
        }
    }


    public function projectStore(Request $request)
    {
        if (Auth::user()->can('project_manager')) {
            $request->validate(['projectName' => 'required']);
            $p = new Project;
            $p->branch_id = Auth::user()->branch_id;
            $p->title = $request->projectName;
            $p->save();
            Session::flash('success', "The Project has been created successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function departmentStore()
    {
        if (request()->ajax() && Auth::user()->can('project_manager')) {
            // check if form is empty
            $title = $_GET['title'];
            $check = 0;
            if ($title != '') {
                $check = 1;
                $pid = $_GET['pid'];
                $d = new Department;
                $d->project_id = $pid;
                $d->title = $title;
                $d->save();
                $ps = Project::all();
                if (count($ps) == 1){
                    $ds = Department::where('project_id', $pid)->get();
                    if (count($ds) == 1){
                        $check = 2;
                    }
                }
                return $check;
            } else {
                return $check;
            }
        } else {
            return json_encode(['success' => false]);
        }
    }


    public function taskStore(Request $request)
    {
        if (request()->ajax() && Auth::user()->can('project_manager')) {
            $t = new Task;
            $t->project_id = $request->pid;
            $t->department_id = $request->did;
            $t->title = $request->task_title;
            $t->deadline = $request->task_deadline;
            $t->remark = $request->task_details;
            $t->save();
            foreach ($request->assign as $a) {
                $ua = new Userassign;
                $ua->user_id = $a;
                $ua->project_id = $request->pid;
                $ua->department_id = $request->did;
                $ua->task_id = $t->id;
                $ua->save();
            }
            return '1';
        } else {
            return json_encode(['success' => false]);
        }
    }


    public function taskDetail($tid)
    {
        $task = Task::find($tid);
        $users = User::where('branch_id', Auth::user()->branch_id)->get();
        $ausers = Userassign::where('task_id', $tid)->get();
        foreach ($users as $u) {
            $n = explode(' ', $u->name);
            $u['title'] = end($n);
            $u['assign'] = 0;
            foreach ($ausers as $au){
                if (($au->user_id * 1) == ($u->id * 1)){
                    $u['assign'] = 1;
                    break;
                }
            }
        }
        return view('taskNew.project_manager.task', compact('task', 'users', 'ausers'));
    }


    public function taskDetailUpdate(Request $request, $tid)
    {
        $request->validate([
            'title' => 'required',
            'deadline' => 'required',
            'remark' => 'required',
            'assign' => 'required',
//            'priority' => 'required',
        ]);
        if (Auth::user()->can('project_manager')) {
            DB::beginTransaction();
            try {
                $t = Task::find($tid);
                $t->title = $request->title;
                $t->deadline = $request->deadline;
                $t->remark = $request->remark;
                $t->update();
                Userassign::where('task_id', $tid)->delete();
                $pid = $t->project_id;
                $did = $t->department_id;
                foreach ($request->assign as $a) {
                    $ua = new Userassign;
                    $ua->user_id = $a;
                    $ua->project_id = $pid;
                    $ua->department_id = $did;
                    $ua->task_id = $tid;
                    $ua->save();
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('success', "The task has been updated successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


}
