<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Leavedate;
use App\Leavetype;
use App\Pension;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LeaveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function application()
    {
        if (Auth::user()->can('l_application')) {
            $p = Pension::find(1);
            $maxLeavePerType = $p->max_leave_per_type;
            $user = Auth::user();
            $job = $user->job()->first();
            $leaves = Leave::where('user_id', $user->id)->where('year', date("Y"))->get();
            // leave can be null
            if (count($leaves) > 0) {
                foreach ($leaves as $l) {
                    $lt = Leavetype::find($l->leavetype_id);
                    $l['type'] = $lt->type;
                }
            }
            $leaveOldDates = Leavedate::where('user_id', $user->id)->orderBy('date', 'desc')->get();
            if (count($leaveOldDates) > 0) {
                foreach ($leaveOldDates as $ll) {
                    $l = Leavetype::find($ll->leavetype_id);
                    $ll['type'] = $l->type;
                }
            }
            $lts = Leavetype::all();
            // can not order by these lts. It will hamper another function applicationSubmit() //////////
            return view('leave.application', compact('user', 'job', 'leaves', 'maxLeavePerType', 'leaveOldDates', 'lts'));
        } else {
            abort(403);
        }
    }


    public function applicationSubmit(Request $request, $uid)
    {
        if (Auth::user()->can('l_application')) {
            $this->validate($request, [
                'fromDate' => 'required|date|after_or_equal:today',
                'toDate' => 'required|date',
                'days' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $dbOldDates = Leavedate::select('date')->where('user_id', $uid)->get();
                $oldDates = [];
                if (count($dbOldDates) > 0) {
                    foreach ($dbOldDates as $value) {
                        array_push($oldDates, $value->date);
                    }
                }
                $leaveTypes = Leavetype::all();
                $newDates = [];
                $saveDates = [];
                $IiI = 0;
//        dd($request->days);
//        array:3 [
//          0 => null
//          1 => "2"
//          2 => null
//        ]
                // from here we can understand foreach leaveType we need to take the 2nd lt
                $p = Pension::find(1);
                $maxLeavePerType = $p->max_leave_per_type;
                foreach ($request->days as $i => $d) {
                    if ($d != null) {
                        // here i is the nth number leavetype
                        if (($d * 1) <= 0) {
                            Session::flash('MESS', "Please Do Not Mess With The Original Code !!!");
                            return redirect()->back();
                        }
                        foreach ($leaveTypes as $ii => $lt) {
                            if ($i == $ii) {
                                // here we can use the $lt->id
                                $leave = Leave::where('user_id', $uid)->where('leavetype_id', $lt->id)->where('year', date("Y"))->first();
                                if ((($lt->id * 1) != 1) && $leave && (($maxLeavePerType * 1) < (($leave->accepted_days * 1) + ($d * 1)))) {
                                    Session::flash('MESS', "Please Do Not Mess With The Original Code !!!");
                                    return redirect()->back();
                                } elseif ((($lt->id * 1) != 1) && (($maxLeavePerType * 1) < (($d * 1)))){
                                    Session::flash('MESS', "Please Do Not Mess With The Original Code !!!");
                                    return redirect()->back();
                                }
                                for ($x = 1; $x <= $d; $x++) {
                                    $a = date('Y-m-d', strtotime($request->fromDate . '+' . $IiI . ' days'));
                                    $newDates[] = $a;
                                    $saveDates[] = ["$lt->id", $a];
                                    $IiI++;
                                }
                            }
                        }
                    }
                }
                foreach ($newDates as $value) {
                    if (in_array($value, $oldDates)) {
                        Session::flash('ApplyUnsuccess', "Applied dates clashed with already applied dates.");
                        return redirect()->back();
                    }
                }
                foreach ($saveDates as $sd) {
                    $ll = new Leavedate;
                    $ll->branch_id = Auth::user()->branch_id;
                    $ll->user_id = $uid;
                    $ll->leavetype_id = $sd[0];
                    $ll->date = $sd[1];
                    $ll->save();
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('ApplySuccess', "Successfully applied for the leave.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }

    public function appliedLeaveDateDelete($lid)
    {
        if (Auth::user()->can('l_application')) {
            Leavedate::find($lid)->delete();
            return redirect()->back()->with('LeaveDeleteSuccess', 'Pending leave date has been deleted successfully');
        } else {
            abort(403);
        }
    }


    public function applicationView($uid)
    {
        if (Auth::user()->can('l_HR')) {
            $bid = Auth::user()->branch_id;
            // HR sidebar click / Or name click on view will come here [sidebar $uid = 0]
            $appliedUsers = Leavedate::select('user_id')->where('approveHR', '0')->where('rejectHR', '0')->where('branch_id', $bid)->distinct()->get();
            $users = [];
            foreach ($appliedUsers as $au) {
                $a = User::find($au);
                array_push($users, $a);
            }
            // users[] is for all users
            $userLeavedays = Leavedate::where('user_id', $uid)->where('date', '>=', Carbon::today())->where('approveHR', '0')->where('rejectHR', '0')->where('branch_id', $bid)->get();
            // $userLeavedays for a particular (imputed) user
            $user = User::find($uid);
            return view('leave/applicationViewHR', compact('users', 'userLeavedays', 'user'));
        } else {
            abort(403);
        }
    }


    public function applicationRejectHR($lid)
    {
        if (Auth::user()->can('l_HR')) {
            $ld = Leavedate::find($lid);
            $ld->rejectHR = 1;
            $ld->update();
            Session::flash('success', 'Leave application rejected.');
            return redirect()->back();
        } else {
            abort(403);
        }
    }

    public function applicationForward(Request $request)
    {
        if (Auth::user()->can('l_HR')) {
            $this->validate($request, [
                'leaveDates' => 'required',
            ]);
            foreach ($request->leaveDates as $ldid) {
                $l = Leavedate::find($ldid);
                $l->approveHR = 1;
                $l->update();
            }
            Session::flash('ForwardSuccess', "Selected dates have been successfully forwarded to department head.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function applicationViewDH($uid)
    {
        if (Auth::user()->can('l_supervisor')) {
            $bid = Auth::user()->branch_id;
            $appliedUsers = Leavedate::where('approveHR', 1)->where('approveDH', 0)->where('rejectDH', 0)->select('user_id')->where('branch_id', $bid)->distinct()->get();
            $users = [];
            foreach ($appliedUsers as $au) {
                $a = User::find($au);
                array_push($users, $a);
            }
            $userLeavedays = Leavedate::where('user_id', $uid)->where('date', '>=', Carbon::today())->where('approveHR', 1)->where('rejectDH', 0)->where('approveDH', '!=', 1)->where('branch_id', $bid)->get();
            $user = User::find($uid);
            $_users = User::where('branch_id', $bid)->get();
            $leaveTypes = Leavetype::all();
            return view('leave/applicationViewDH', compact('users', 'userLeavedays', 'user', '_users', 'leaveTypes'));
        } else {
            abort(403);
        }
    }


    public function applicationRejectDH($lid)
    {
        if (Auth::user()->can('l_supervisor')) {
            $ld = Leavedate::find($lid);
            $ld->rejectDH = 1;
            $ld->update();
            Session::flash('success', 'Leave application rejected.');
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function applicationApprove(Request $request)
    {
        if (Auth::user()->can('l_supervisor')) {
            $this->validate($request, [
                'leaveDates' => 'required',
            ]);
            $yearNow = date("Y");
            DB::beginTransaction();
            try {
                foreach ($request->leaveDates as $ldid) {
                    $l = Leavedate::find($ldid);
                    $l->approveDH = 1;
                    $l->update();
                    $leave = Leave::where('user_id', $l->user_id)->where('leavetype_id', $l->leavetype_id)->where('year', $yearNow)->first();
                    if ($leave) {
                        $L = $leave;
                    } else {
                        $L = new Leave;
                        $L->user_id = $l->user_id;
                        $L->leavetype_id = $l->leavetype_id;
                        $L->accepted_days = 0;
                        $L->year = $yearNow;
                        $L->save();
                    }
                    $L->accepted_days = $L->accepted_days + 1;
                    $L->update();
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('ApproveSuccess', "Selected dates have been successfully Approved.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function leaveEntryDH(Request $request)
    {
        if (Auth::user()->can('l_supervisor')) {
            $this->validate($request, [
                'name' => 'required',
                'fromDate' => 'required|date',
            ]);
            $dbOldDates = Leavedate::select('date')->where('user_id', $request->name)->get();
            $oldDates = [];
            if (count($dbOldDates) > 0) {
                foreach ($dbOldDates as $value) {
                    $oldDates[] = $value->date;
                }
            }
            $leaveDays = [];
            foreach ($request->days as $type_id => $days) {
                if (isset($type_id) && !empty($days)) {
                    $leaveDays[$type_id] = $days;
                }
            }
            $leaveDates = [];
            if (count($leaveDays) > 0) {
                foreach ($leaveDays as $key => $value) {
                    if (count($leaveDates) > 0) {
                        $leaveDatesLastItem = end($leaveDates);
                        $leaveDatesLastItemLastValue = end($leaveDatesLastItem);
                        for ($i = 1; $i <= $value; $i++) {
                            $newDate = date("Y-m-d", strtotime("+$i day", strtotime($leaveDatesLastItemLastValue)));
                            if (in_array($newDate, $oldDates)) {
                                Session::flash('error', "Applied dates clashed with already applied dates.");
                                return redirect()->back();
                            } else {
                                $leaveDates[$key][] = $newDate;
                            }
                        }
                    } else {
                        for ($i = 0; $i < $value; $i++) {
                            $NewDate = date("Y-m-d", strtotime("+$i day", strtotime($request->fromDate)));
                            if (in_array($NewDate, $oldDates)) {
                                Session::flash('error', "Applied dates clashed with already applied dates.");
                                return redirect()->back();
                            } else {
                                $leaveDates[$key][] = $NewDate;
                            }
                        }
                    }
                }
            }
            if (count($leaveDates) > 0) {
                DB::beginTransaction();
                try {
                    foreach ($leaveDates as $key1 => $value1) {
                        if (is_array($value1)) {
                            foreach ($value1 as $key2 => $value2) {
                                $ld = new Leavedate;
                                $ld->user_id = $request->name;
                                $ld->branch_id = User::find($request->name)->branch_id;
                                $ld->leavetype_id = $key1;
                                $ld->date = $value2;
                                $ld->approveHR = 1;
                                $ld->approveDH = 1;
                                $ld->save();
                                $leave = Leave::where('user_id', $ld->user_id)->where('leavetype_id', $ld->leavetype_id)->where('year', date("Y"))->first();
                                if ($leave) {
                                    $L = $leave;
                                } else {
                                    $L = new Leave;
                                    $L->user_id = $ld->user_id;
                                    $L->leavetype_id = $ld->leavetype_id;
                                    $L->accepted_days = 0;
                                    $L->year = date("Y");
                                    $L->save();
                                }
                                $L->accepted_days = $L->accepted_days + 1;
                                $L->update();
                            }
                        }
                    }
                    DB::commit();
                    $success = true;
                } catch (\Exception $e) {
                    $success = false;
                    DB::rollback();
                }
                if ($success) {
                    Session::flash('success', "Leave dates has been successfully saved.");
                    return redirect()->back();
                } else {
                    Session::flash('unsuccess', "Something went wrong :(");
                    return redirect()->back();
                }
            } else {
                Session::flash('error', "Please input at least one leave days");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


}