<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Branch;
use App\Employee;
use App\EmployeeType;
use App\Job;
use App\Notice;
use App\Religion;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        //
    }


    public function create()
    {
        if (Auth::user()->can('employee_create')) {
            $bs = Branch::all();
            $jobs = Job::all();
            $rs = Role::all();
            $ets = EmployeeType::all();
            $rss = Religion::all();
            $users = User::all();
            foreach ($users as $i => $u) {
                $e = Employee::where('user_id', $u->id)->first();
                if ($e) {
                    $users->forget($i);
                }
            }
            return view('employee.create', compact('bs', 'jobs', 'rs', 'ets', 'rss', 'users'));
        } else {
            abort(403);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('employee_create')) {
            $request->validate([
                'branch' => 'required',
                'email' => 'required',
                'designation' => 'required',
                'role' => 'required',
                'employeeType' => 'required',
                'name' => 'required',
                'fathersName' => 'required',
                'mothersName' => 'required',
                'dateOfBirth' => 'required',
                'religion' => 'required',
                'mobile' => 'required',
                'nationality' => 'required',
                'aboutMe' => 'required',
                'address' => 'required',
                'education' => 'required',
                'employment' => 'required',
                'skills' => 'required',
                'languagess' => 'required',
                'reference' => 'required',
                'image' => 'required',
            ]);
            if ($request->is_user == "0") {
                $request->validate([
                    'password' => 'required|confirmed',
                    'email' => 'unique:users,email|unique:applicants,email',
                ]);
            } elseif ($request->is_user == "1") {
                $u = User::find($request->uid);
                if ($u->email != $request->email) {
                    $request->validate([
                        'email' => 'unique:users,email|unique:applicants,email',
                    ]);
                }
            }
            DB::beginTransaction();
            try {
                if ($request->is_user == "0") {
                    $u = new User;
                    $u->password = bcrypt($request->password);
                }
                $u->branch_id = $request->branch;
                $u->name = $request->name;
                $u->email = $request->email;
                $u->job_id = $request->designation;
                $img = $request->image;
                $img_name = time() . $img->getClientOriginalName();
                $aa = $img->move('uploads/Users/Photo', $img_name);
                $d = 'uploads/Users/Photo/' . $img_name;
                $u->image = $d;
                $u->save();
                if ($request->is_user == "0") {
                    $u->attachRole($request->role);
                } elseif ($request->is_user == "1") {
                    $u->syncRoles([$request->role]);
                }
                $e = new Employee;
                $e->user_id = $u->id;
                $e->employeeType_id = $request->employeeType;
                $e->religion_id = $request->religion;
                $e->dob = $request->dateOfBirth;
                $e->FathersName = $request->fathersName;
                $e->MothersName = $request->mothersName;
                $e->mobile = $request->mobile;
                $e->nationality = $request->nationality;
                $e->about_me = $request->aboutMe;
                $e->address = $request->address;
                $e->education = $request->education;
                $e->employment = $request->employment;
                $e->skills = $request->skills;
                $e->languages = $request->languagess;
                $e->reference = $request->reference;
                if ($request->hasFile('cv')) {
                    $img = $request->cv;
                    $img_name = time() . $img->getClientOriginalName();
                    $aa = $img->move('uploads/Users/cv', $img_name);
                    $d = 'uploads/Users/cv/' . $img_name;
                    $e->cv = $d;
                }
                $e->save();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('EmployeeCreateSuccess', "The Employee '$request->name' has been created successfully.");
                return redirect()->route('employee.create');
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function createFromUser(Request $request)
    {
        if (Auth::user()->can('employee_create')) {
            $uid = $request->user_id;
            return redirect()->route('employee.create.fromUser.dummy', ['uid' => $uid]);
        } else {
            abort(403);
        }
    }

    public function createFromUserDummy($uid)
    {
        if (Auth::user()->can('employee_create')) {
            $user = User::find($uid);
            $bs = Branch::all();
            $jobs = Job::all();
            $rs = Role::all();
            $ets = EmployeeType::all();
            $rss = Religion::all();
            $users = User::all();
            foreach ($users as $i => $u) {
                $e = Employee::where('user_id', $u->id)->first();
                if ($e) {
                    $users->forget($i);
                }
            }
            return view('employee.createFromUser', compact('user', 'users', 'bs', 'jobs', 'rs', 'ets', 'rss'));
        } else {
            abort(403);
        }
    }


    public function show(Employee $employee)
    {
        //
    }


    public function edit()
    {
        if (Auth::user()->can('employee_edit')) {
            $es = Employee::all();
            foreach ($es as $e) {
                $e['name'] = User::find($e->user_id)->name;
            }
            return view('employee.edit', compact('es'));
        } else {
            abort(403);
        }
    }


    public function editOne(Request $request)
    {
        if (Auth::user()->can('employee_edit')) {
            $eid = $request->employee_id;
            return redirect()->route('employee.edit.dummy', ['eid' => $eid]);
        } else {
            abort(403);
        }
    }


    public function editForm($eid)
    {
        if (Auth::user()->can('employee_edit')) {
            $es = Employee::all();
            foreach ($es as $e) {
                $e['name'] = User::find($e->user_id)->name;
            }
            $e = Employee::find($eid);
            $eu = User::find($e->user_id);
            $e['name'] = $eu->name;
            $e['email'] = $eu->email;
            $e['employeeType'] = EmployeeType::find($e->employeeType_id)->type;
            $e['religion'] = Religion::find($e->religion_id)->name;
            $e['role'] = $eu->roles()->first();
            $rs = Role::all();
            $ets = EmployeeType::all();
            $rss = Religion::all();
//            dd($e->role->id);
            return view('employee.editForm', compact('es', 'e', 'rs', 'ets', 'rss', 'eu'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $eid)
    {
        if (Auth::user()->can('employee_edit')) {
            $request->validate([
                'email' => 'required',
                'role' => 'required',
                'employeeType' => 'required',
                'name' => 'required',
                'fathersName' => 'required',
                'mothersName' => 'required',
                'dateOfBirth' => 'required',
                'religion' => 'required',
                'mobile' => 'required',
                'nationality' => 'required',
                'aboutMe' => 'required',
                'address' => 'required',
                'education' => 'required',
                'employment' => 'required',
                'skills' => 'required',
                'languagess' => 'required',
                'reference' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $e = Employee::find($eid);
                $u = User::find($e->user_id);
                if ($u->email != $request->email) {
                    $request->validate([
                        'email' => 'unique:users,email|unique:applicants,email',
                    ]);
                }
                $u->name = $request->name;
                $u->email = $request->email;
                if ($request->hasFile('image')){
                    if ($u->image){
                        unlink($u->image);
                    }
                    $img = $request->image;
                    $img_name = time() . $img->getClientOriginalName();
                    $aa = $img->move('uploads/Users/Photo', $img_name);
                    $d = 'uploads/Users/Photo/' . $img_name;
                    $u->image = $d;
                }
                $u->update();
                $u->syncRoles([$request->role]);
                $e->employeeType_id = $request->employeeType;
                $e->religion_id = $request->religion;
                $e->dob = $request->dateOfBirth;
                $e->FathersName = $request->fathersName;
                $e->MothersName = $request->mothersName;
                $e->mobile = $request->mobile;
                $e->nationality = $request->nationality;
                $e->about_me = $request->aboutMe;
                $e->address = $request->address;
                $e->education = $request->education;
                $e->employment = $request->employment;
                $e->skills = $request->skills;
                $e->languages = $request->languagess;
                $e->reference = $request->reference;
                if ($request->hasFile('cv')) {
                    $img = $request->cv;
                    $img_name = time() . $img->getClientOriginalName();
                    $aa = $img->move('uploads/Users/cv', $img_name);
                    $d = 'uploads/Users/cv/' . $img_name;
                    $e->cv = $d;
                }
                $e->update();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('EmployeeUpdateSuccess', "The Employee '$request->name' has been updated successfully.");
                return redirect()->route('employee.edit.dummy', ['eid' => $eid]);
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function applicantEmployee($aid, $nid)
    {
        if (Auth::user()->can('circular')){
            $a = Applicant::find($aid);
            $rs = Role::all();
            $ets = EmployeeType::all();
            $rss = Religion::all();
            return view('employee.selectApplicant', compact('a', 'rs', 'ets', 'rss', 'nid'));
        } else {
            abort(403);
        }
    }


    public function applicantEmployeeStore(Request $request, $aid, $nid)
    {
        if (Auth::user()->can('circular')) {
            $request->validate([
                'email' => 'required|unique:users,email',
                'role' => 'required',
                'name' => 'required',
                'fathersName' => 'required',
                'mothersName' => 'required',
                'dateOfBirth' => 'required',
                'religion' => 'required',
                'mobile' => 'required',
                'nationality' => 'required',
                'aboutMe' => 'required',
                'address' => 'required',
                'education' => 'required',
                'employment' => 'required',
                'skills' => 'required',
                'languagess' => 'required',
                'reference' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $a = Applicant::find($aid);
                $n = Notice::find($nid);
                $u = new User;
                $u->name = $request->name;
                $u->email = $request->email;
                $u->password = $a->password;
                $u->image = $a->image;
                $u->branch_id = $n->branch_id;
                $u->job_id = $n->job_id;
                $u->save();
                $u->attachRole($request->role);
                $e = new Employee;
                $e->user_id = $u->id;
                $e->employeeType_id = $n->employeeType_id;
                $e->religion_id = $request->religion;
                $e->dob = $request->dateOfBirth;
                $e->FathersName = $request->fathersName;
                $e->MothersName = $request->mothersName;
                $e->mobile = $request->mobile;
                $e->nationality = $request->nationality;
                $e->about_me = $request->aboutMe;
                $e->address = $request->address;
                $e->education = $request->education;
                $e->employment = $request->employment;
                $e->skills = $request->skills;
                $e->languages = $request->languagess;
                $e->reference = $request->reference;
                $e->save();
                $a->delete();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('EmployeeSelectSuccess', "The Applicant has been successfully selected for the job.");
                return redirect()->route('notice.applicant.view', ['nid' => $nid]);
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function destroy(Employee $employee)
    {
        //
    }
}
