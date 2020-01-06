<?php

namespace App\Http\Controllers;

use App\Job;
use App\Menu;
use App\Office;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        Storage::disk('local')->put('menu', Menu::all());
        Storage::disk('local')->put('office', Office::where('branch_id', Auth::user()->branch_id)->first());
        if (Auth::user()->job_id && Job::find(Auth::user()->job_id)){
            Storage::disk('local')->put('job_title', Job::find(Auth::user()->job_id)->title);
        } else {
            Storage::disk('local')->put('job_title', 'General User');
        }

        return view('index');
//        $totalNotice = Notice::count();
//        $totalApplicants = Applicant::count();
//        $onGoingProject = Project::count();
//        $totalEmployee = User::where('job_id', '!=', null)->count();
//        $branches = Branch::all();
//        foreach ($branches as $b) {
//            $totalU = 0;
//            $array = [];
//            $designations = Job::all();
//            foreach ($designations as $d) {
//                $u = User::where('branch_id', $b->id)->where('job_id', $d->id)->count();
//                array_push($array, ['designation' => $d->title, 'users' => $u]);
//                $b['second'] = $array;
//                $totalU = $totalU + $u;
//            }
//            $b['count'] = $totalU;
//            $users = User::where('branch_id', $b->id)->get();
//            $tle = 0;
//            $tlo = 0;
//            $tppf = 0;
//            $tw = 0;
//            foreach ($users as $u) {
//                $leaves = Leave::where('user_id', $u->id)->sum('accepted_days');
//                $loans = Userloan::where('user_id', $u->id)->sum('due');
//                $pf = Salary::where('user_id', $u->id)->sum('total_provident_fund');
//                $p = Salary::where('user_id', $u->id)->sum('total_pension');
//                $tle = $tle + $leaves;
//                $tlo = $tlo + $loans;
//                $tppf = $tppf + $pf + $p;
//                $tw = $tw + $u->fatal_warning;
//            }
//            $b['totalLeave'] = $tle;
//            $b['totalLoan'] = $tlo;
//            $b['tppf'] = $tppf;
//            $b['totalWarning'] = $tw;
//        }
//        $projects = Project::all()->groupBy('branch_id');
//        foreach ($projects as $p) {
//            $p[0]['branch_title'] = Branch::find($p[0]->branch_id)->title;
//        }
//        return view('index', compact('totalNotice', 'totalApplicants', 'onGoingProject', 'totalEmployee', 'branches', 'projects'));
    }


    public function users()
    {
        if (Auth::user()->can('user_create')) {
            $users = User::all();
            $role = Role::where('name', 'general_user')->first();
            return view('users.index', compact('users', 'role'));
        } else {
            abort(403);
        }
    }


    public function storeUser(Request $request)
    {
        if (Auth::user()->can('user_create')) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users,email|unique:applicants,email',
                'password' => 'required|confirmed',
                'role' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $u = new User;
                $u->name = $request->name;
                $u->email = $request->email;
                $u->password = bcrypt($request->password);
                $u->save();
                $u->attachRole($request->role);
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('UserCreateSuccess', "The User '$request->name' has been created successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function edit($uid)
    {
        if (Auth::user()->can('user_create') && ($uid * 1) > 2) {
            $uedit = User::find($uid);
            $users = User::all();
            $role = Role::where('name', 'general_user')->first();
            return view('users.edit', compact('users', 'uedit', 'role'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $uid)
    {
        if (Auth::user()->can('user_create') && ($uid * 1) > 2) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'role' => 'required',
            ]);
            $u = User::find($uid);
            if ($u->email != $request->email) {
                $this->validate($request, [
                    'email' => 'unique:users,email',
                ]);
            }
            if ($request->filled('password') || $request->filled('password_confirmation')) {
                $this->validate($request, [
                    'password' => 'required|confirmed',
                ]);
                $u->password = bcrypt($request->password);
            }
            DB::beginTransaction();
            try {
                $u->name = $request->name;
                $u->email = $request->email;
                $u->update();
                $u->syncRoles([$request->role]);
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('UserUpdateSuccess', "The User '$request->name' has been updated successfully.");
                return redirect()->route('users');
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->route('users');
            }
        } else {
            abort(403);
        }
    }


    public function userSearchRole()
    {
        if (Auth::user()->hasRole('info_user_role')) {
            return view('userRole.search');
        } else {
            abort(403);
        }
    }


    public function userRole(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
        $uu = Auth::user();
        if ($uu->hasRole('admin')) {
            $u = User::where('email', $request->email)->first();
        } else {
            $u = User::where('email', $request->email)->where('branch_id', $uu->branch_id)->first();
        }
        if ($u && ($u->id != 1) && ($u->job_id != null)) {
            return redirect()->route('userRoleShow', $u->id);
        } elseif ($u && ($u->job_id == null || $u->job_id == '1')) {
            Session::flash('NoUserJob', "$u->name is not assigned to a job !!!");
            return redirect()->back();
        } else {
            Session::flash('NoSuchUser', "No User with email id '$request->email' exist.");
            return redirect()->back();
        }
    }


    public function userRoleShow($uid)
    {
        if (Auth::user()->hasRole('info_user_role')) {
            $u = User::find($uid);
            $jrs = [];
            if ($u) {
                $jrs = $u->roles()->get();
            }
            return view('userRole/index', compact('jrs', 'u'));
        } else {
            abort(403);
        }
    }


    public function RoleStoreAndUpdate(Request $request, $uid)
    {
        $this->validate($request, [
            'role' => 'required',
        ]);
        $uu = User::find($uid);
        $roleids = [];
        foreach ($request->role as $r) {
            $roleids[] = Role::where('name', $r)->first()->id;
        }
        $uu->syncRoles($roleids);
        Session::flash('UserUpdateSuccess', "User's Role has been updated successfully.");
        return redirect()->route('user.search.role');
    }


    public function test(Request $request)
    {
        dd($request->assign);
        return view('test');
    }
}
