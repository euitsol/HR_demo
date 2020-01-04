<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Employee;
use App\Job;
use App\Role;
use App\Tax;
use App\User;
use App\Userassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BranchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('branch_setup')){
            $bs = Branch::all();
            return view('branch.index', compact('bs'));
        } else {
            abort(403);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('branch_setup')){
            $this->validate($request, [
                'title' => 'required|unique:branches,title',
            ]);
            DB::beginTransaction();
            try {
                $b = new Branch;
                $b->title = $request->title;
                $b->save();
                $taxes = [0 => [1, 250000, 0], 1 => [250001, 400000, 10], 2 => [400001, 500000, 15], 3 => [500001, 600000, 20], 4 => [600001, 3000000, 25]];
                foreach ($taxes as $t){
                    $tt = new Tax;
                    $tt->branch_id = $b->id;
                    $tt->from = $t[0];
                    $tt->to = $t[1];
                    $tt->tax = $t[2];
                    $tt->save();
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('BStoreSuccess', "Branch '$request->title' has been created successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->route('users');
            }
        } else {
            abort(403);
        }

    }


    public function edit($bid)
    {
        if (Auth::user()->can('branch_setup')){
            $bs = Branch::all();
            $branch = Branch::find($bid);
            return view('branch.edit', compact('bs', 'branch'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $bid)
    {
        if (Auth::user()->can('branch_setup')){
            $this->validate($request, [
                'title' => 'required|unique:branches,title',
            ]);
            $b = Branch::find($bid);
            $b->title = $request->title;
            $b->update();
            Session::flash('BUpdateSuccess', "Branch '$request->title' has been updated successfully.");
            return redirect()->route('branch.setup');
        } else {
            abort(403);
        }
    }


    public function destroy($bid)
    {
        if (Auth::user()->can('branch_setup')){
            $u = User::where('branch_id', $bid)->get();
            $e = Employee::where('branch_id', $bid)->get();
            if ((count($u) > 0) || (count($e) > 0)){
                Session::flash('Cannotdelete', "This Branch has assigned user, Can not Delete !!!");
                return redirect()->back();
            } else {
                Branch::find($bid)->delete();
                Tax::where('branch_id', $bid)->delete();
                Session::flash('DeleteSuccess', "This Branch has been deleted successfully.");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function transferRelease()
    {
        if (Auth::user()->can('transfer')){
            $es = Employee::where('branch_id', null)->get();
            foreach ($es as $e){
                $e['name'] = User::find($e->user_id)->name;
            }
            $bs = Branch::all();
            return view('transfer.index', compact('es', 'bs'));
        } else {
            abort(403);
        }
    }

    public function transferReleaseSubmit(Request $request)
    {
        if (Auth::user()->can('transfer')){
            $this->validate($request, [
                'employee' => 'required',
                'branch' => 'required',
            ]);
            $e = Employee::find($request->employee);
            $u = User::find($e->user_id);
            if (($u->branch_id) == $request->branch){
                Session::flash('error', "User is already in the same branch.");
                return redirect()->back();
            } else {
                DB::beginTransaction();
                try {
                    $e->branch_id = $request->branch;
                    $e->update();
                    $u->branch_id = 0;
                    $u->update();
                    $u->syncRoles([3]);
                    Userassign::where('user_id', $u->id)->delete();
                    DB::commit();
                    $success = true;
                } catch (\Exception $e) {
                    $success = false;
                    DB::rollback();
                }
                if ($success) {
                    Session::flash('success', "User has been successfully selected to transfer.");
                    return redirect()->back();
                } else {
                    Session::flash('unsuccess', "Something went wrong :(");
                    return redirect()->back();
                }
            }
        } else {
            abort(403);
        }
    }

    public function transferJoin()
    {
        if (Auth::user()->can('transfer')){
            $es = Employee::where('branch_id', '!=', null)->get();
            foreach ($es as $e){
                $u = User::find($e->user_id);
                $e['name'] = $u->name;
                $e['branch'] = Branch::find($e->branch_id)->title;
                $e['job'] = Job::find($u->job_id)->title;
            }
            $rs = Role::all();
            return view('transfer.join', compact('es', 'rs'));
        } else {
            abort(403);
        }
    }


    public function joinSubmit(Request $request, $eid)
    {
        if (Auth::user()->can('transfer')){
            $this->validate($request, [
                'role' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $e = Employee::find($eid);
                $u = User::find($e->user_id);
                $u->branch_id = $e->branch_id;
                $u->update();
                $u->syncRoles([$request->role]);
                $e->branch_id = null;
                $e->update();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('success', "User has been successfully Joined to new branch.");
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
