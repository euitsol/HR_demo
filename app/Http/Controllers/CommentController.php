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

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request, $did, $pid)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);
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
        Session::flash('CommentCreateSuccess', "The Comment has been posted successfully.");
        return redirect()->back();
    }


    public function downloadCommentFile($cid){
        $c = Comment::find($cid);
        $ext = pathinfo($c->file, PATHINFO_EXTENSION);
        $name = 'comment_file_department.'.$ext;
        return response()->download($c->file, $name);
    }



    public function edit($cid, $did, $pid)
    {
        $comment = Comment::find($cid);
        if (Auth::id() == (($comment->user_id)*1)){
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
            return view('tasks/commentEdit', compact('comment', 'project', 'tasks', 'dependencies', 'departments', 'did', 'assigns', 'users'));
        }else {
            abort(403);
        }
    }


    public function update(Request $request, $cid, $did, $pid)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);
        $c = Comment::find($cid);
        $c->comment = $request->comment;
        if ($request->hasFile('file')) {
            if ($c->file != null){
                unlink($c->file);
            }
            $f = $request->file;
            $f_name = time() . $f->getClientOriginalName();
            $a = $f->move('uploads/comments', $f_name);
            $d = 'uploads/comments/' . $f_name;
            $c->file = $d;
        }
        $c->update();
        Session::flash('CommentUpdateSuccess', "The Comment has been updated successfully.");
        return redirect()->route('department.details.employee', ['did' => $did, 'pid' => $pid]);
    }


    public function destroy($cid, $did, $pid)
    {
        $c = Comment::find($cid);
        $replies = Reply::where('comment_id', $cid)->get();
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
        Session::flash('CommentDeleteSuccess', "The Comment has been deleted successfully.");
        return redirect()->route('department.details.employee', ['did' => $did, 'pid' => $pid]);
    }
}
