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
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
//        if (Auth::user()->hasRole('task_project_manager')) {
            $projects = Project::where('branch_id', Auth::user()->branch_id)->get();
            return view('tasks/index', compact('projects'));
//        } else {
//            abort(403);
//        }
    }


    public function indexForEmployee()
    {
        $assigns = Userassign::where('user_id', Auth::id())->get();
        $projects = [];
        if (count($assigns) > 0) {
            foreach ($assigns as $assign) {
                $p = Project::find($assign->project_id);
                if (!in_array($p, $projects)) {
                    array_push($projects, $p);
                }
            }
        }
        return view('tasks/indexEmployee', compact('projects'));
    }


    public function createInitialProject()
    {
        return view('tasks/createInitialProject');
    }


    public function storeInitialProject(Request $request)
    {
        // deadline has to be today or greater
        $this->validate($request, [
            'projectTitle' => 'required|unique:projects,title',
        ]);
        $p = new Project;
        $p->branch_id = Auth::user()->branch_id;
        $p->title = $request->projectTitle;
        $p->save();
        return redirect()->route('Project.View', ['pid' => $p->id]);
    }


    public function ProjectView($pid)
    {
        $project = Project::find($pid);
//        if ((Auth::user()->hasRole('task_project_manager')) && ($project->branch_id == Auth::user()->branch_id)) {
            $tasks = Task::where('project_id', $pid)->orderBy('created_at', 'ASC')->get();
            $departments = Department::where('project_id', $pid)->orderBy('title')->get();
            $dependencies = [];
            $assigns = [];
            if (count($tasks) > 0) {
                foreach ($tasks as $t) {
                    $d = $t->dependencies()->get();
                    array_push($dependencies, $d);
                    $a = Userassign::where('task_id', $t->id)->get();
                    array_push($assigns, $a);
                }
            }
            $users = User::where('branch_id', Auth::user()->branch_id)->get();
            return view('tasks/createTaskUnderProject', compact('tasks', 'project', 'dependencies', 'departments', 'users', 'assigns'));
//        } else {
//            abort(403);
//        }
    }


    public function viewReport($tid)
    {
        $task = Task::find($tid);
        return view('tasks/reportView', compact('task'));
    }


    public function downloadReportFile($tid)
    {
        $t = Task::find($tid);
        $ext = pathinfo($t->submit_file, PATHINFO_EXTENSION);
        $name = 'report_file.' . $ext;
        return response()->download($t->submit_file, $name);
    }


    public function taskReopen($tid)
    {
        $t = Task::find($tid);
        $t->submit = 0;
        if ($t->submit_file != null) {
            unlink($t->submit_file);
            $t->submit_file = null;
        }
        $t->update();
        Session::flash('TaskReopenSuccess', "The Task has been reopened successfully.");
        return redirect()->route('Project.View', ['pid' => $t->project_id]);
    }


    public function taskAccept($tid)
    {
        $t = Task::find($tid);
        $t->submit_accept = 1;
        $t->update();
        Session::flash('TaskAcceptSuccess', "The Task has been accepted successfully.");
        return redirect()->route('Project.View', ['pid' => $t->project_id]);
    }


    public function ProjectViewEmployee($pid)
    {
        $project = Project::find($pid);
        $departments = [];
        $assigns = Userassign::where('user_id', Auth::id())->get();
        if (count($assigns) > 0) {
            foreach ($assigns as $assign) {
                if (($assign->project_id) == $pid) {
                    $d = Department::find($assign->department_id);
                    if (!in_array($d, $departments)) {
                        array_push($departments, $d);
                    }
                }
            }
        }
        return view('tasks/projectEmployee', compact('project', 'departments'));
    }


    public function updateProjectTitle(Request $request, $pid)
    {
        $this->validate($request, [
            'projectTitle' => 'required|unique:projects,title',
        ]);
        $p = Project::find($pid);
        $p->title = $request->projectTitle;
        $p->update();
        return redirect()->back();
    }


    public function storeTask(Request $request, $did, $pid)
    {
        $this->validate($request, [
            'taskTitleT' => 'required',
            'taskDeadline' => 'required|date|after_or_equal:today',
            'remarkT' => 'required',
            'assigns' => 'required',
        ]);
        $t = new Task;
        $t->project_id = $pid;
        $t->department_id = $did;
        $t->title = $request->taskTitleT;
        $t->deadline = $request->taskDeadline;
        $t->remark = $request->remarkT;
        $t->save();
        if ($request->filled('dependency')) {
            foreach ($request->dependency as $de) {
                // de is the task id >> which is the dependency id
                $d = new Dependency;
                $d->task_id = $t->id;
                $d->dependency = $de;
                $d->save();
            }
        }
        foreach ($request->assigns as $a) {
            $ua = new Userassign;
            $ua->user_id = $a;
            $ua->project_id = $pid;
            $ua->department_id = $did;
            $ua->task_id = $t->id;
            $ua->save();
        }
        Session::flash('TaskCreateSuccess', "The Task has been created successfully.");
        return redirect()->route('Project.View', ['pid' => $pid]);
    }


    public function updateTask(Request $request, $tid, $did, $pid)
    {
        $this->validate($request, [
            'taskTitle' => 'required',
            'deadline' => 'required|date|after_or_equal:today',
            'remark' => 'required',
            'assigns' => 'required',
        ]);
        $t = Task::find($tid);
        $t->title = $request->taskTitle;
        $t->deadline = $request->deadline;
        $t->remark = $request->remark;
        $t->update();
        // we do not know if dependency will be added or removed
        // better removed all the dependencies and then add new one again for that task
        Dependency::where('task_id', $tid)->delete();
        if ($request->filled('dependency')) {
            foreach ($request->dependency as $de) {
                // de is the task id >> which is the dependency id
                $d = new Dependency;
                $d->task_id = $tid;
                $d->dependency = $de;
                $d->save();
            }
        }
        Userassign::where('task_id', $tid)->delete();
        foreach ($request->assigns as $a) {
            $ua = new Userassign;
            $ua->user_id = $a;
            $ua->project_id = $pid;
            $ua->department_id = $did;
            $ua->task_id = $t->id;
            $ua->save();
        }
        return redirect()->route('Project.View', ['pid' => $pid]);
    }


    public function taskSubmitView($tid, $did, $pid)
    {
        $task = Task::find($tid);
        return view('tasks/taskSubmit', compact('task', 'did', 'pid'));
    }


    public function taskSubmitStore(Request $request, $tid, $did, $pid)
    {
        $this->validate($request, [
            'reportDescription' => 'required'
        ]);
        $t = Task::find($tid);
        $t->submit = 1;
        $t->submit_report = $request->reportDescription;
        if ($request->hasFile('file')) {
            if ($t->submit_file) {
                unlink($t->submit_file);
            }
            $img = $request->file;
            $img_name = time() . $img->getClientOriginalName();
            $a = $img->move('uploads/task_reports', $img_name);
            $d = 'uploads/task_reports/' . $img_name;
            $t->submit_file = $d;
        }
        $t->update();
        Session::flash('TaskSubmitSuccess', "The Task has been submitted successfully.");
        return redirect()->route('department.details.employee', ['did' => $did, 'pid' => $pid]);
    }


    public function ProjectDelete($pid)
    {
        // reply delete with file
        $replies = Reply::where('project_id', $pid)->get();
        if (count($replies) > 0) {
            foreach ($replies as $r) {
                if ($r->file) {
                    unlink($r->file);
                }
                $r->delete();
            }
        }
        // comment delete with file
        $comments = Comment::where('project_id', $pid)->get();
        if (count($comments) > 0) {
            foreach ($comments as $c) {
                if ($c->file) {
                    unlink($c->file);
                }
                $c->delete();
            }
        }
        $tasks = Task::where('project_id', $pid)->get();
        if (count($tasks) > 0) {
            foreach ($tasks as $t) {
                // task dependency table delete
                Dependency::where('task_id', $t->id)->delete();
                // task delete with file submission
                if ($t->submit_file) {
                    unlink($t->submit_file);
                }
                $t->delete();
            }
        }
        // user assigns table delete
        Userassign::where('project_id', $pid)->delete();
        // department delete
        Department::where('project_id', $pid)->delete();
        // finally project delete
        Project::find($pid)->delete();
        Session::flash('ProjectDeleteSuccess', "The Project has been deleted successfully.");
        return redirect()->route('task.index');
    }


    public function taskViewEmployee($tid)
    {
        $task = Task::find($tid);
        $tasks = Task::where('department_id', $task->department_id)->orderBy('created_at', 'ASC')->get();
        $project = Project::find($task->project_id);
        $assignss = Userassign::where('user_id', Auth::id())->get();
        $departments = [];
        if (count($assignss) > 0) {
            foreach ($assignss as $assign) {
                if (($assign->project_id) == $task->project_id) {
                    $d = Department::find($assign->department_id);
                    if (!in_array($d, $departments)) {
                        array_push($departments, $d);
                    }
                }
            }
        }
        $dependencies = $task->dependencies()->get();
        $users = User::all();
        $assigns = Userassign::where('task_id', $task->id)->get();
        $comments = Commentt::where('task_id', $task->id)->orderBy('created_at', 'DESC')->get();
        if (count($comments) > 0) {
            foreach ($comments as $c) {
                $u = User::find($c->user_id);
                $c['user_name'] = $u->name;
                $c['user_image'] = $u->image;
            }
        }
        $replies = Replyt::where('task_id', $task->id)->orderBy('created_at', 'ASC')->get();
        if (count($replies) > 0) {
            foreach ($replies as $r) {
                $u = User::find($r->user_id);
                $r['user_name'] = $u->name;
                $r['user_image'] = $u->image;
            }
        }
        return view('tasks/taskViewEmployee', compact('task', 'tasks', 'project', 'departments', 'dependencies', 'users', 'assigns', 'comments', 'replies'));
    }

}
