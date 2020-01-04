<?php
namespace App\Http\Controllers;
use App\Employee;
use App\Incrementpolicy;
use App\Job;
use App\Kpi;
use App\Kpisetup;
use App\Payscale;
use App\Promotion;
use App\User;
use App\Userpay;
use App\Increment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class IncrementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('increment')){
            $isetup = Incrementpolicy::find(1);
            $ksetup = Kpisetup::find(1);
            if (($isetup->is_kpi * 1) == 1){
                // get only user with kpi score
                $ks = Kpi::all();
                $employees = [];
                foreach ($ks as $k){
                    $employees[] = Employee::where('user_id', $k->user_id)->first();
                }
                foreach ($employees as $e){
                    $kpi = Kpi::where('user_id', $e->user_id)->first();
                    $kpiscoreP = (($kpi->attendance - $ksetup->attendanceTarget) * 100 / $ksetup->attendanceTarget)
                                    + (($kpi->attitude - $ksetup->attitudeTarget) * 100 / $ksetup->attitudeTarget)
                                    + (($kpi->performance - $ksetup->performanceTarget) * 100 / $ksetup->performanceTarget);
                    if ($kpiscoreP < ($isetup->below * -1)){
                        $e['max'] = 0;
                    } elseif (($kpiscoreP >= ($isetup->below * -1)) && ($kpiscoreP < 0)) {
                        $e['max'] = $isetup->increment_1;
                    } elseif (($kpiscoreP >= 0) && ($kpiscoreP < $isetup->above_1)){
                        $e['max'] = $isetup->increment_2;
                    } elseif (($kpiscoreP >= $isetup->above_1) && ($kpiscoreP < $isetup->above_2)){
                        $e['max'] = $isetup->increment_3;
                    } elseif ($kpiscoreP >= $isetup->above_2) {
                        $e['max'] = $isetup->increment_max;
                    }
                    $user = User::find($e->user_id);
                    $up = Userpay::where('user_id', $e->user_id)->first();
                    if ($up){
                        $e['pay'] = $up;
                    }else {
                        $e['pay'] = Payscale::find(Job::find($user->job_id)->payscale_id);
                    }
                    $e['name'] = $user->name;
                }
            }else {
                $employees = Employee::all();
                foreach ($employees as $e){
                    $e['max'] = $isetup->increment_max;
                    $user = User::find($e->user_id);
                    $up = Userpay::where('user_id', $e->user_id)->first();
                    if ($up){
                        $e['pay'] = $up;
                    }else {
                        $e['pay'] = Payscale::find(Job::find($user->job_id)->payscale_id);
                    }
                    $e['name'] = $user->name;
                }
            }
            $designations = Job::all();
            return view('increment.index', compact('employees', 'designations'));
        } else {
            abort(403);
        }
    }




    public function incrementEmployee(Request $request, $eid)
    {
        if (Auth::user()->can('increment')){
            $request->validate([
                'increment' => 'required|numeric|min:0|max:100',
            ]);
            $employee = Employee::find($eid);
            // validation start
            $isetup = Incrementpolicy::find(1);
            if (($isetup->is_kpi * 1) == 1) {
                $ksetup = Kpisetup::find(1);
                $kpi = Kpi::where('user_id', $employee->user_id)->first();
                $kpiscoreP = (($kpi->attendance - $ksetup->attendanceTarget) * 100 / $ksetup->attendanceTarget)
                    + (($kpi->attitude - $ksetup->attitudeTarget) * 100 / $ksetup->attitudeTarget)
                    + (($kpi->performance - $ksetup->performanceTarget) * 100 / $ksetup->performanceTarget);
                if ($kpiscoreP < ($isetup->below * -1)) {
                    $max = 0;
                } elseif (($kpiscoreP >= ($isetup->below * -1)) && ($kpiscoreP < 0)) {
                    $max = $isetup->increment_1;
                } elseif (($kpiscoreP >= 0) && ($kpiscoreP < $isetup->above_1)) {
                    $max = $isetup->increment_2;
                } elseif (($kpiscoreP >= $isetup->above_1) && ($kpiscoreP < $isetup->above_2)) {
                    $max = $isetup->increment_3;
                } elseif ($kpiscoreP >= $isetup->above_2) {
                    $max = $isetup->increment_max;
                }
            } else {
                $max = $isetup->increment_max;
            }
            if (($request->increment) > $max){
                Session::flash('mess', 'Please Do Not Mess With The Original Code !!!');
                return redirect()->back();
            }
            // validation end
            DB::beginTransaction();
            try {
                $up = Userpay::where('user_id', $employee->user_id)->first();
                if ($up){
                    $pay = $up;
                } else {
                    $up = new Userpay;
                    $up->user_id = $employee->user_id;
                    $pay = Payscale::find(Job::find(User::find($employee->user_id)->job_id)->payscale_id);
                }
                $up->pay = $pay->pay + ($pay->pay * $request->increment / 100);
                $up->compensation = $pay->compensation + ($pay->compensation * $request->increment / 100);
                $up->benefit = $pay->benefit + ($pay->benefit * $request->increment / 100);
                $up->benefit_detail = $pay->benefit_detail;
                $up->family_support = $pay->family_support + ($pay->family_support * $request->increment / 100);
                $up->family_support_detail = $pay->family_support_detail;
                $up->save();
                $p = new Promotion;
                $p->user_id = $employee->user_id;
                $p->job_id = User::find($employee->user_id)->job_id;
                $p->pay = $pay->pay + ($pay->pay * $request->increment / 100);
                $p->compensation = $pay->compensation + ($pay->compensation * $request->increment / 100);
                $p->benefit = $pay->benefit + ($pay->benefit * $request->increment / 100);
                $p->family_support = $pay->family_support + ($pay->family_support * $request->increment / 100);
                $p->changed_by = Auth::id();
                $p->save();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('success', 'The Employee has successfully got the increment.');
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }



    public function promote(Request $request)
    {
        if (Auth::user()->can('increment')){
            $request->validate([
                'employee' => 'required',
                'designation' => 'required',
            ]);
            $promotion = Kpisetup::find(1)->promotion;
            $job = Job::find(User::find(Employee::find($request->employee)->user_id)->job_id);
            if (($job->supervisor_id) == ($request->designation)){
                $jobs = Job::where('supervisor_id', $request->designation)->get();
                $numberOfEmployees = 0;
                foreach ($jobs as $j){
                    $us = User::where('job_id', $j->id)->get();
                    foreach ($us as $u){
                        $e = Employee::where('user_id', $u->id)->first();
                        if ($e){
                            $numberOfEmployees++;
                        }
                    }
                }
                $numberOfSupervisors = 0;
                $us = User::where('job_id', $request->designation)->get();
                foreach ($us as $u){
                    $e = Employee::where('user_id', $u->id)->first();
                    if ($e){
                        $numberOfSupervisors++;
                    }
                }
                if ($numberOfSupervisors >  ($numberOfEmployees * $promotion / 100)){
                    Session::flash('CanNotPromote', "Can not Promote to $job->title because the position is already overcrowded.");
                    return redirect()->back();
                }
            }
            DB::beginTransaction();
            try {
                $u = User::find(Employee::find($request->employee)->user_id);
                $u->job_id = $request->designation;
                $u->update();
                Userpay::where('user_id', $u->id)->delete();
                $p = new Promotion;
                $p->user_id = $u->id;
                $p->job_id = $request->designation;
                $p->changed_by = Auth::id();
                $p->save();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                if (Auth::id() == $u->id){
                    Storage::disk('local')->delete('job_title');
                    Storage::disk('local')->put('job_title', Job::find(Auth::user()->job_id)->title);
                }
                Session::flash('PromoteSuccess', "The Employee has been promoted successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->route('users');
            }
        } else {
            abort(403);
        }
    }





    public function selectPersons()
    {
        if (Auth::user()->can('increment')){
            $bid = Auth::user()->branch_id;
            $i_users = Increment::where('approveHR', 0)->where('approveCEO', 0)->where('branch_id', $bid)->get(); // increment user if exist
            if ($i_users->count() > 0) {
                $users = $i_users;
                $edit = true;
            } else {
                $users = User::where('branch_id', $bid)->get();
                $edit = false;
            }
            $i_users_2 = Increment::where('approveHR', 1)->where('approveCEO', 0)->where('branch_id', $bid)->get();
            $pending = ($i_users_2->count() > 0) ? true : false;
            return view('increment.selectPersons', compact('users', 'edit', 'pending'));
        } else {
            abort(403);
        }
    }


    public function selectedPersons(Request $request)
    {
        if (Auth::user()->can('increment')){
            $newData = [];
            foreach ($request->remark as $user_id => $remark) {
                if ($remark == null) {
                    Session::flash('error', 'Please do not edit original code.');
                    return redirect()->back();
                } else {
                    $newData[$user_id] = $remark;
                }
            }
            if (count($newData) > 0) {
                if ($request->filled('edit') && $request->edit == 1) {
                    foreach ($newData as $u_id => $r) {
                        $_increment = Increment::where('user_id', $u_id)->where('approveHR', 0)->where('approveCEO', 0)->first();
                        $_increment->remark = $r;
                        $_increment->update();
                    }
                } else {
                    foreach ($newData as $u_id => $r) {
                        $increment = new Increment();
                        $increment->user_id = $u_id;
                        $increment->branch_id = Auth::user()->branch_id;
                        $increment->remark = $r;
                        $increment->save();
                    }
                }
            }
            Session::flash('success', 'Increment info saved successfully');
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function showInHR()
    {
        if (Auth::user()->can('increment')){
            $incrementsData = Increment::where('approveHR', 0)->where('approveCEO', 0)->where('branch_id', Auth::user()->branch_id)->get();
            foreach ($incrementsData as $key => $value) {
                $u = User::find($value->user_id);
                $value['user_name'] = $u->name;
            }
            return view('increment.infoShowHR', compact('incrementsData'));
        } else {
            abort(403);
        }
    }


    public function storeHR(Request $request)
    {
        if (Auth::user()->can('increment')){
            $newData = [];
            foreach ($request->incrementPercent as $user_id => $increment) {
                if ($increment == null) {
                    Session::flash('error', 'Please fill out all fields.');
                    return redirect()->back();
                } else {
                    $newData[$user_id] = $increment;
                }
            }
            if (count($newData) > 0) {
                foreach ($newData as $u_id => $inc) {
                    $i = Increment::where('user_id', $u_id)->where('approveHR', 0)->first();
                    $i->approveHR = 1;
                    $i->increment_percent = $inc;
                    $i->save();
                }
            }
            Session::flash('success', 'Increment info saved successfully.');
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function showCEO()
    {
        if (Auth::user()->can('increment')){
            $incrementsData = Increment::where('approveHR', 1)->where('approveCEO', 0)->where('branch_id', Auth::user()->branch_id)->get();
            foreach ($incrementsData as $key => $value) {
                $u = User::find($value->user_id);
                $value['user_name'] = $u->name;
            }
            return view('increment.infoShowCEO', compact('incrementsData'));
        } else {
            abort(403);
        }
    }


    public function acceptCEO(Request $request)
    {
        if (Auth::user()->can('increment')){
            $newData = [];
            foreach ($request->incrementPercent as $key => $value) {
                if ($value == null) {
                    Session::flash('error', 'Please fill out all fields.');
                    return redirect()->back();
                } else {
                    $newData[$key] = $value;
                }
            }
            if (count($newData) > 0) {
                foreach ($newData as $u_id => $inc) {
                    $i = Increment::where('user_id', $u_id)->where('approveCEO', 0)->first();
                    $i->increment_percent = $inc;
                    $i->approveCEO = 1;
                    $i->update();
                    $up = Userpay::where('user_id', $u_id)->first();
                    if (isset($up->pay)) {
                        $new_pay = ($up->pay * $inc) / 100;
                        $up->pay = $up->pay + $new_pay;
                        $new_tax = ($up->tax * $inc) / 100;
                        $up->tax = $up->tax + $new_tax;
                        $up->update();
                    }
                }
            }
            Session::flash('success', 'Increment info accepted.');
            return redirect()->back();
        } else {
            abort(403);
        }
    }
}