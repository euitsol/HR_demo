<?php

namespace App\Http\Controllers;

use App\Commentt;
use App\Department;
use App\Project;
use App\Replyt;
use App\Task;
use App\User;
use App\Userassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReplytController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create($cid)
    {
        $c = Commentt::find($cid);
        $task = Task::find($c->task_id);
        $tasks = Task::where('department_id', $task->department_id)->orderBy('created_at', 'ASC')->get();
        $project = Project::find($task->project_id);
        $assignss = Userassign::where('user_id', Auth::id())->get();
        $departments = [];
        if (count($assignss) > 0){
            foreach ($assignss as $assign){
                if (($assign->project_id) == $task->project_id){
                    $d = Department::find($assign->department_id);
                    if (!in_array($d, $departments)){
                        array_push($departments, $d);
                    }
                }
            }
        }
        $dependencies = $task->dependencies()->get();
        $users = User::all();
        $assigns = Userassign::where('task_id', $task->id)->get();
        $replies = Replyt::where('commentt_id', $cid)->get();
        return view('tasks/replyTCreate', compact('task', 'tasks', 'project', 'departments', 'dependencies', 'users', 'assigns', 'c', 'replies'));

    }


    public function store(Request $request, $cid, $tid)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $r = new Replyt;
        $r->user_id = Auth::id();
        $r->task_id = $tid;
        $r->commentt_id = $cid;
        $r->replyt = $request->reply;
        if ($request->hasFile('file')) {
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/replies', $f_name);
            $d = 'uploads/replies/' . $f_name;
            $r->file = $d;
        }
        $r->save();
        Session::flash('ReplytCreateSuccess', "The Reply has been posted successfully.");
        return redirect()->route('task.view.employee', ['tid' => $tid]);
    }


    public function downloadReplyFile($rid){
        $r = Replyt::find($rid);
        $ext = pathinfo($r->file, PATHINFO_EXTENSION);
        $name = 'reply_file_task.'.$ext;
        return response()->download($r->file, $name);
    }


    public function show(Replyt $replyt)
    {
        //
    }


    public function edit($rid)
    {
        $reply = Replyt::find($rid);
        $c = Commentt::find($reply->commentt_id);
        $task = Task::find($c->task_id);
        $tasks = Task::where('department_id', $task->department_id)->orderBy('created_at', 'ASC')->get();
        $project = Project::find($task->project_id);
        $assignss = Userassign::where('user_id', Auth::id())->get();
        $departments = [];
        if (count($assignss) > 0){
            foreach ($assignss as $assign){
                if (($assign->project_id) == $task->project_id){
                    $d = Department::find($assign->department_id);
                    if (!in_array($d, $departments)){
                        array_push($departments, $d);
                    }
                }
            }
        }
        $dependencies = $task->dependencies()->get();
        $users = User::all();
        $assigns = Userassign::where('task_id', $task->id)->get();
        return view('tasks/replyTEdit', compact('task', 'tasks', 'project', 'departments', 'dependencies', 'users', 'assigns', 'c', 'reply'));
    }


    public function update(Request $request, $rid)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $r = Replyt::find($rid);
        $r->replyt = $request->reply;
        if ($request->hasFile('file')) {
            if ($r->file){
                unlink($r->file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/replies', $f_name);
            $d = 'uploads/replies/' . $f_name;
            $r->file = $d;
        }
        $r->update();
        Session::flash('ReplytUpdateSuccess', "The Reply has been updated successfully.");
        return redirect()->route('task.view.employee', ['tid' => $r->task_id]);
    }


    public function destroy($rid)
    {
        $r = Replyt::find($rid);
        if ($r->file != null){
            unlink($r->file);
        }
        $r->delete();
        Session::flash('ReplytDeleteSuccess', "The Reply has been deleted successfully.");
        return redirect()->route('task.view.employee', ['tid' => $r->task_id]);
    }
}
