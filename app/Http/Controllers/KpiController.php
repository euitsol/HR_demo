<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\Job;
use App\Kpi;
use App\Kpisetup;
use App\Kpivote;
use App\Leave;
use App\Payscale;
use App\Pension;
use App\Task;
use App\User;
use App\Userassign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KpiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('kpi')){
            $employes = Employee::all();
            $counter = 0;
            foreach ($employes as $employee){
                $KV = Kpivote::where('user_id', $employee->user_id)->first();
                if (!$KV || ($KV && (($KV->attitude * 1) == 0 || ($KV->performance * 1) == 0))){
                    $counter = $counter + 1;
                }
            }
            $kpis = Kpi::all();
            foreach ($kpis as $k){
                $k['name'] = User::find($k->user_id)->name;
            }
            $kS = Kpisetup::find(1);
            return view('kpi.index', compact('counter', 'kpis', 'kS'));
        } else {
            abort(403);
        }
    }


    public function calculate()
    {
        if (Auth::user()->can('kpi')){
            $setup = Kpisetup::find(1);
            $year = Carbon::now()->year;
            $employees = Employee::all();
            DB::beginTransaction();
            try {
                foreach ($employees as $e){
                    $user = User::find($e->user_id);
                    $kpivote = Kpivote::where('user_id', $user->id)->first();

                    $kpi = Kpi::where('user_id', $user->id)->first();
                    if (!$kpi){
                        $kpi = new Kpi;
                        $kpi->user_id = $user->id;
                    }

                    $attendance = $setup->attendance;
                    $lwp = Leave::where('user_id', $e->user_id)->where('leavetype_id', '1')->where('year', $year)->first();
                    if ($lwp){
                        $attendance = $attendance - ($lwp->accepted_days * $setup->attendance / 100);
                    }
                    $as = Attendance::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->where('user_id', $user->id)->get();
                    if (count($as) > 0){
                        $workingTimes = [];
                        $underTimes = [];
                        $overTimes = [];
                        foreach ($as as $a){
                            if (isset($a->time_out)) {
                                $total_hours = $this->date_time_difference($a->time_in, $a->time_out);
                                $workingTimes[] = $total_hours;
                            } else {
                                $total_hours = null;
                            }
                            $workingTime = Pension::find(1)->pdwh;
                            $workingTime = $this->decimal_to_hour($workingTime);
                            if (strtotime($total_hours) > strtotime($workingTime)) {
                                $over_time = $this->date_time_difference($total_hours, $workingTime);
                                $overTimes[] = $over_time;
                            }
                            if (strtotime($total_hours) < strtotime($workingTime)) {
                                $under_time = $this->date_time_difference($total_hours, $workingTime);
                                $underTimes[] = $under_time;
                            }
                        }
                        if (count($underTimes) > 0) {
                            $totalOverTime1 = strtotime($this->sum_times($overTimes)) - strtotime($this->sum_times($underTimes));
                            $totalOverTime2 = $totalOverTime1 / 3600;
                            $totalOverTime = number_format($totalOverTime2, 2);
                        } else {
                            $totalOverTime = $this->sum_times($overTimes);
                        }
                        $jid = $user->job_id;
                        $pid = Job::find($jid)->payscale_id;
                        $maxPay = Payscale::max('pay');
                        $minPay = Payscale::min('pay');
                        $pay = Payscale::find($pid)->pay;
                        $pp = $pay / ($maxPay - $minPay);
                        $attendance = $attendance + ($totalOverTime * $setup->attendance / 100 * 0.5 * $pp);
                    }
                    if ($attendance < 0){
                        $kpi->attendance = 0;
                    } elseif ($attendance > $setup->attendance){
                        $kpi->attendance = $setup->attendance;
                    } else {
                        $kpi->attendance = $attendance;
                    }

                    $attitude = $setup->attitude;
                    if ($kpivote && (($kpivote->attitude * 1) > 0)){
                        $attitude = $attitude * $kpivote->attitude / 10;
                    }
                    $warning = $user->fatal_warning;
                    if (($warning * 1) > 0){
                        $attitude = $attitude - ($setup->attitude * (20 * $warning) / 100);
                    }
                    if ($attitude < 0){
                        $kpi->attitude = 0;
                    } elseif ($attitude > $setup->attitude){
                        $kpi->attitude = $setup->attitude;
                    } else {
                        $kpi->attitude = $attitude;
                    }

                    $performance = $setup->performance;
                    if ($kpivote && (($kpivote->performance * 1) > 0)){
                        $performance = $performance * $kpivote->performance / 10;
                    }
                    $uas = Userassign::where('user_id', $user->id)->get();
                    foreach ($uas as $ua){
                        $task = Task::find($ua->task_id);
                        if (((Carbon::today()->format('Y-m-d')) < $task->deadline) && (($task->submit_accept * 1) == 0)){
                            $performance = $performance - ($setup->performance * 0.1);
                        }
                    }
                    if ($performance < 0){
                        $kpi->performance = 0;
                    } elseif ($performance > $setup->performance){
                        $kpi->performance = $setup->performance;
                    } else {
                        $kpi->performance = $performance;
                    }

                    // Judgement
                        // resign (has to b calculated after account close) ///////////////////////////////////////////////////////////////////
                        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $judgement = $setup->judgementTarget;
                    $kpi->judgement = $judgement;
                    $kpi->save();
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('KpiSuccess', "The KPI has been successfully calculated.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Kpi $kpi)
    {
        //
    }


    public function edit(Kpi $kpi)
    {
        //
    }


    public function update(Request $request, Kpi $kpi)
    {
        //
    }


    public function destroy(Kpi $kpi)
    {
        //
    }
}
