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

class CommenttController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request, $tid)
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
        Session::flash('CommenttCreateSuccess', "The Comment has been posted successfully.");
        return redirect()->back();
    }



    public function edit($cid)
    {
        $comment = Commentt::find($cid);
        $task = Task::find($comment->task_id);
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
        return view('tasks/commentTEdit', compact('comment', 'task', 'tasks', 'project', 'departments', 'dependencies', 'users', 'assigns'));
    }


    public function update(Request $request, $cid)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);
        $c = Commentt::find($cid);
        $c->commentt = $request->comment;
        if ($request->hasFile('file')) {
            if ($c->file){
                unlink($c->file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/comments', $f_name);
            $d = 'uploads/comments/' . $f_name;
            $c->file = $d;
        }
        $c->update();
        Session::flash('CommenttUpdateSuccess', "The Comment has been posted successfully.");
        return redirect()->route('task.view.employee', ['tid' => $c->task_id]);
    }


    public function downloadCommentFile($cid){
        $c = Commentt::find($cid);
        $ext = pathinfo($c->file, PATHINFO_EXTENSION);
        $name = 'comment_file_task.'.$ext;
        return response()->download($c->file, $name);
    }


    public function destroy($cid)
    {
        $c = Commentt::find($cid);
        $replies = Replyt::where('commentt_id', $cid)->get();
        foreach ($replies as $r){
            if ($r->file != null){
                unlink($r->file);
            }
            $r->delete();
        }
        if ($c->file != null){
            unlink($c->file);
        }
        $c->delete();
        Session::flash('CommenttDeleteSuccess', "The Comment has been deleted successfully.");
        return redirect()->route('task.view.employee', ['tid' => $c->task_id]);
    }
}
