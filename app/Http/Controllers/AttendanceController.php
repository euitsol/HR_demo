<?php
namespace App\Http\Controllers;

use App\Pension;
use App\User;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $currentMonthAttendances = DB::table('attendances')->where('user_id', Auth::id())
            ->whereRaw('MONTH(date) = ?', [date('m')])
            ->where('branch_id', Auth::user()->branch_id)
            ->orderBy('date', 'desc')->get();
        $todayAttendanceExist = Attendance::where('user_id', Auth::id())->where('date', date('Y-m-d'))->where('branch_id', Auth::user()->branch_id)->first();
        $inExist = false;
        $outExist = false;
        if ($todayAttendanceExist) {
            if (isset($todayAttendanceExist->time_in)) {
                $inExist = true;
            }
            if (isset($todayAttendanceExist->time_out)) {
                $outExist = true;
            }
        }
        return view('attendance.attendanceReceive', compact('currentMonthAttendances', 'inExist', 'outExist'));
    }


    public function attendanceIN_Store(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        // Start Time should come from setup //////////////////////////////////////////////////////////////////////////////
        $setTime = strtotime(date('Y-m-d H:i:s', strtotime('22:30:00')));
        if (strtotime(date('Y-m-d H:i:s')) <= $setTime) {
            $timeInExist = Attendance::where('user_id', Auth::id())->where('date', date('Y-m-d'))->first();
            if ($timeInExist) {
                return redirect()->back()->with('error', 'Sorry! Duplicate Entry');
            } else {
                // ip address from user info table //////////////////////////////////////////////////////////////////////////
                if ($request->ip() == Auth::user()->ip_address) {
                    $a = new Attendance;
                    $a->branch_id = Auth::user()->branch_id;
                    $a->user_id = Auth::id();
                    $a->date = date('Y-m-d');
                    $a->time_in = date('Y-m-d H:i:s');
                    $a->save();
                    return redirect()->back();
                } else {
                    return redirect()->back()->with('error', 'Unauthorized computer');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Can not enter time in after 12:30');
        }
    }


    public function attendanceOUT_Store(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $timeInExist = Attendance::where('user_id', Auth::id())->where('date', date('Y-m-d'))->first();
        if (isset($timeInExist->time_in) && !empty($timeInExist->time_in)) {
            if (empty($timeInExist->time_out)) {
                $time_in = strtotime($timeInExist->time_in);
                if (time() > $time_in) {
                    // ip address from user info table //////////////////////////////////////////////////////////////////////////
                    if ($request->ip() == Auth::user()->ip_address) {
                        $timeInExist->time_out = date('Y-m-d H:i:s');
                        $timeInExist->update();
                        return redirect()->back();
                    } else {
                        return redirect()->back()->with('error', 'Unauthorized computer');
                    }
                } else {
                    return redirect()->back()->with('error', 'Present time small than time IN');
                }
            } else {
                return redirect()->back()->with('error', "You have already clicked time out.");
            }
        } else {
            return redirect()->back()->with('error', "Please click time in first.");
        }
    }


    public function attendanceShow()
    {
        if (Auth::user()->can('attendance_edit')){
            return view('attendance.attendanceShowAdmin', [
                'users' => User::where('branch_id', Auth::user()->branch_id)->get()
            ]);
        } else {
            abort(403);
        }
    }


    public function currentAttendanceDateAjax($uid)
    {
        if (Auth::user()->can('attendance_edit')){
            $timeExist = Attendance::where('user_id', $uid)
                ->whereRaw('MONTH(date) = ?', [date('m')])
                ->latest()->get();
            $output = '
            <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">IN <small>Time</small></th>
                    <th class="text-center">OUT <small>Time</small></th>
                    <th class="text-center">Total <small>Time</small></th>
                    <th class="text-center">Under <small>Time</small></th>
                    <th class="text-center">Over <small>Time</small></th>
                    <th class="text-center">Action</th>
                </tr>
        ';
            if ($timeExist->count() > 0) {
                $workingTimes = [];
                $underTimes = [];
                $overTimes = [];
                foreach ($timeExist as $key => $value) {
                    if (isset($value->time_out)) {
                        $total_hours = $this->date_time_difference($value->time_in, $value->time_out);
                        $workingTimes[] = $total_hours;
                    } else {
                        $total_hours = null;
                    }
                    $workingTime = Pension::find(1)->pdwh;
                    $workingTime = $this->decimal_to_hour($workingTime);
                    if (strtotime($total_hours) > strtotime($workingTime)) {
                        $over_time = $this->date_time_difference($total_hours, $workingTime);
                        $overTimes[] = $over_time;
                    } else {
                        $over_time = '---';
                    }
                    if (strtotime($total_hours) < strtotime($workingTime)) {
                        $under_time = $this->date_time_difference($total_hours, $workingTime);
                        $underTimes[] = $under_time;
                    } else {
                        $under_time = '---';
                    }
                    $output .= '
                    <tr>
                        <td>'.($key + 1).'</td>
                        <td>'.date('d M, Y', strtotime($value->date)).'</td>
                        <td>'.date('h : i : s A', strtotime($value->time_in)).'</td>
                        <td>'.date('h : i : s A', strtotime($value->time_out)).'</td>
                        <td>'.$total_hours.'</td>
                        <td>'.$under_time.'</td>
                        <td>'.$over_time.'</td>
                        <td> 
                            <a href="'.route('attendance.edit', $value->id).'" class="btn btn-success btn-sm">
                               <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                ';
                }
                if (count($underTimes) > 0) {
                    $totalOverTime1 = strtotime($this->sum_times($overTimes)) - strtotime($this->sum_times($underTimes));
                    $totalOverTime2 = $totalOverTime1 / 3600;
                    $totalOverTime = number_format($totalOverTime2, 2);
                } else {
                    $totalOverTime = $this->sum_times($overTimes);
                }
                $output .= '
                </table></div>
                <div class="clearfix">
                    <div class="float-right">
                        <table class="table table-borderless">
                            <tr>
                                <th>Total Working Time</th>
                                <td>:</td>
                                <td>'.$this->sum_times($workingTimes).'</td>
                            </tr>
                            <tr>
                                <th>Total Over Time</th>
                                <td>:</td>
                                <td>'.$totalOverTime.' hours</td>
                            </tr>
                        </table>
                    </div>
                </div>
            ';
            } else {
                $output .= '
                <tr>
                    <td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td>
                </tr>
            ';
                $output .= '</table></div>';
            }
            return $output;
        } else {
            abort(403);
        }
    }


    public function attendanceEdit($aid)
    {
        if (Auth::user()->can('attendance_edit')){
            return view('attendance.attendanceEditAdmin', [
                'attendance' => Attendance::find($aid)
            ]);
        } else {
            abort(403);
        }
    }


    public function attendanceUpdate(Request $request)
    {
        if (Auth::user()->can('attendance_edit')){
            $this->validate($request, [
                'id' => 'required',
            ]);
            $attendance = Attendance::find($request->id);
            if ((!empty($request->time_in) && !empty($request->time_out)) && (strtotime($request->time_out) < strtotime($request->time_in))) {
                return redirect()->back()->with('error', 'Time out small');
            } elseif ((empty($request->time_in) && !empty($request->time_out)) && (strtotime($request->time_out) < strtotime($attendance->time_in))) {
                return redirect()->back()->with('error', 'Time out small');
            }
            if (!empty($request->time_in)) {
                $attendance->time_in = date('Y-m-d H:i:s', strtotime($request->time_in));
            } elseif (!empty($request->time_out)) {
                $attendance->time_out = date('Y-m-d H:i:s', strtotime($request->time_out));
            }
            $attendance->update();
            return redirect()->back()->with('success', 'Attendance has been successfully updated');
        } else {
            abort(403);
        }
    }




}