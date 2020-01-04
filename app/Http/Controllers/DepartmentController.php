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

class DepartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request, $pid)
    {
        $this->validate($request, [
            'departmentTitle' => 'required',
        ]);
        $d = new Department;
        $d->project_id = $pid;
        $d->title = $request->departmentTitle;
        $d->save();
        Session::flash('DepartmentCreateSuccess', "The Department has been created successfully.");
        return redirect()->route('Project.View', ['pid' => $pid]);
    }


    public function show(Department $department)
    {
        //
    }
    public function edit(Department $department)
    {
        //
    }


    public function update(Request $request, $did, $pid)
    {
        $this->validate($request, [
            'departmentTitle' => 'required',
        ]);
        $d = Department::find($did);
        $d->title = $request->departmentTitle;
        $d->update();
        Session::flash('DepartmentUpdateSuccess', "The Department has been updated successfully.");
        return redirect()->route('Project.View', ['pid' => $pid]);
    }


    public function departmentDetailsEmployee($did, $pid){
        $project = Project::find($pid);
        $assignss = Userassign::where('user_id', Auth::id())->get();
        $departments = [];
        if (count($assignss) > 0){
            foreach ($assignss as $assign){
                if (($assign->project_id) == $pid){
                    $d = Department::find($assign->department_id);
                    if (!in_array($d, $departments)){
                        array_push($departments, $d);
                    }
                }
            }
        }
        // get all the tasks with assigned users
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
        $users = User::all();
        $comments = Comment::where('department_id', $did)->orderBy('created_at', 'DESC')->get();
        if (count($comments) > 0){
            foreach ($comments as $c){
                $u = User::find($c->user_id);
                $c['user_name'] = $u->name;
                $c['user_image'] = $u->image;
            }
        }
        $replies = Reply::where('department_id', $did)->orderBy('created_at', 'ASC')->get();
        if (count($replies) > 0){
            foreach ($replies as $r){
                $u = User::find($r->user_id);
                $r['user_name'] = $u->name;
                $r['user_image'] = $u->image;
            }
        }
        return view('tasks/departmentDetailsEmployee', compact('did','tasks', 'project', 'dependencies', 'departments', 'comments', 'replies', 'assigns', 'users'));
    }















    public function destroy(Department $department)
    {
        //
    }
}
