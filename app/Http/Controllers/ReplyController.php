<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Department;
use App\Project;
use App\Reply;
use App\Task;
use App\User;
use App\Userassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create($cid, $did, $pid)
    {
        $project = Project::find($pid);
        $tasks = Task::where('department_id', $did)->orderBy('created_at', 'ASC')->get();
        $dependencies = [];
        $assigns = [];
        if (count($tasks) > 0){
            foreach ($tasks as $t){
                $d = $t->dependencies()->get();
                array_push($dependencies,$d);
                $a = Userassign::where('task_id', $t->id)->get();
                array_push($assigns, $a);
            }
        }
        $departments = [];
        $assignss = Userassign::where('user_id', Auth::id())->get();
        if (count($assignss) > 0){
            foreach ($assignss as $assign){
                if (($assign->project_id) == $pid){
                    $dd = Department::find($assign->department_id);
                    if (!in_array($dd, $departments)){
                        array_push($departments, $dd);
                    }
                }
            }
        }
        $users = User::all();
        $c = Comment::find($cid);
        $replies = Reply::where('project_id', $pid)->orderBy('created_at', 'ASC')->get();
        if (count($replies) > 0){
            foreach ($replies as $r){
                $u = User::find($r->user_id);
                $r['user_name'] = $u->name;
                $r['user_image'] = $u->image;
            }
        }
        return view('tasks/replyCreate', compact('tasks', 'project', 'dependencies', 'c', 'departments', 'replies', 'did', 'assigns', 'users'));
    }


    public function store(Request $request, $cid, $did, $pid)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $r = new Reply;
        $r->user_id = Auth::id();
        $r->project_id = $pid;
        $r->department_id = $did;
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
        Session::flash('ReplyCreateSuccess', "The Reply has been posted successfully.");
        return redirect()->route('department.details.employee', ['did' => $did, 'pid' => $pid]);
    }


    public function downloadReplyFile($rid){
        $r = Reply::find($rid);
        $ext = pathinfo($r->file, PATHINFO_EXTENSION);
        $name = 'reply_file_department.'.$ext;
        return response()->download($r->file, $name);
    }


    public function show(Reply $reply)
    {
        //
    }


    public function edit($rid, $cid, $did, $pid)
    {
        $project = Project::find($pid);
        $tasks = Task::where('department_id', $did)->orderBy('created_at', 'ASC')->get();
        $dependencies = [];
        $assigns = [];
        if (count($tasks) > 0){
            foreach ($tasks as $t){
                $d = $t->dependencies()->get();
                array_push($dependencies,$d);
                $a = Userassign::where('task_id', $t->id)->get();
                array_push($assigns, $a);
            }
        }
        $departments = [];
        $assignss = Userassign::where('user_id', Auth::id())->get();
        if (count($assignss) > 0){
            foreach ($assignss as $assign){
                if (($assign->project_id) == $pid){
                    $dd = Department::find($assign->department_id);
                    if (!in_array($dd, $departments)){
                        array_push($departments, $dd);
                    }
                }
            }
        }
        $users = User::all();
        $c = Comment::find($cid);
        $r = Reply::find($rid);
        return view('tasks/replyEdit', compact('tasks', 'project', 'dependencies', 'c', 'r', 'departments', 'did', 'assigns', 'users'));
    }


    public function update(Request $request, $rid, $did, $pid)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $r = Reply::find($rid);
        $r->reply = $request->reply;
        if ($request->hasFile('file')) {
            if ($r->file != null){
                unlink($r->file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/replies', $f_name);
            $d = 'uploads/replies/' . $f_name;
            $r->file = $d;
        }
        $r->update();
        Session::flash('ReplyUpdateSuccess', "The Reply has been updated successfully.");
        return redirect()->route('department.details.employee', ['did' => $did, 'pid' => $pid]);
    }


    public function destroy($rid, $did, $pid)
    {
        $r = Reply::find($rid);
        if ($r->file != null){
            unlink($r->file);
        }
        $r->delete();
        Session::flash('ReplyDeleteSuccess', "The Reply has been deleted successfully.");
        return redirect()->route('department.details.employee', ['did' => $did, 'pid' => $pid]);
    }
}
