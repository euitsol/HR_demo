<?php

namespace App\Http\Controllers;

use App\Job;
use App\Kpisetup;
use App\Kpivote;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KpivoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $u = Auth::user();
        if (($u->kpiVoting * 1) == 1){
            $users = User::where('branch_id', $u->branch_id)->where('id', '!=', $u->id)->get();
            $juniorUsers = [];
            $jobs = Job::where('supervisor_id', $u->job_id)->get();
            if (count($jobs) > 0){
                foreach ($jobs as $j){
                    $us = User::where('branch_id', $u->branch_id)->where('job_id', $j->id)->where('id', '!=', $u->id)->get();
                    if (count($us) > 0){
                        foreach ($us as $uu){
                            $juniorUsers[] = $uu;
                        }
                    }
                }
            }
            return view('kpi.vote.index', compact('users', 'juniorUsers'));
        }else {
            abort(403);
        }
    }



    public function store(Request $request)
    {
        $u = Auth::user();
        if (($u->kpiVoting * 1) == 1){
            DB::beginTransaction();
            try {
                foreach ($request->allu as $i => $au){
                    // here i is the user_id
                    $vu = Kpivote::where('user_id', $i)->first();
                    if (!$vu){
                        $vu = new Kpivote;
                        $vu->user_id = $i;
                        $vu->attitude = 0;
                        $vu->attitudeCount = 0;
                        $vu->performance = 0;
                        $vu->performanceCount = 0;
                    }
                    $ta = ($vu->attitude * $vu->attitudeCount) + $au;
                    $vu->attitudeCount = $vu->attitudeCount + 1;
                    $vu->attitude = $ta / $vu->attitudeCount;
                    $vu->save();
                }
                $chain = Kpisetup::find(1)->chain;
                foreach ($request->jus as $i => $ju){
                    $pu = Kpivote::where('user_id', $i)->first();
                    $tp = ($pu->performance * $pu->performanceCount) + $ju;
                    $pu->performanceCount = $pu->performanceCount + 1;
                    $pu->performance = $tp / $pu->performanceCount;
                    $pu->update();
                    if ((($ju * 1) < 8) && (($chain * 1) > 0)){
                        $sid = Job::find(User::find($i)->job_id)->supervisor_id;
                        $users = User::where('branch_id', $u->branch_id)->where('job_id', $sid)->get();
                        if (count($users) > 0){
                            foreach ($users as $uu){
                                $this->calculation($uu->id, $ju, $chain);
                                $ssid = Job::find($uu->job_id)->supervisor_id;
                                $uusers = User::where('branch_id', $u->branch_id)->where('job_id', $ssid)->get();
                                if (count($uusers) > 0){
                                    $nchain = $chain * $chain / 100;
                                    foreach ($uusers as $uuu){
                                        $this->calculation($uuu->id, $ju, $nchain);
                                    }
                                }
                            }
                        }
                    }
                }
                $u->kpiVoting = 0;
                $u->update();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('KpiVoteSuccess', "You have voted successfully.");
                return redirect()->route('home');
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        }else {
            abort(403);
        }
    }


    private function calculation($uid, $ju, $chain)
    {
        $puu = Kpivote::where('user_id', $uid)->first();
        if (!$puu){
            $puu = new Kpivote;
            $puu->user_id = $uid;
            $puu->attitude = 0;
            $puu->attitudeCount = 0;
            $puu->performance = 0;
            $puu->performanceCount = 0;
        }
        if ($puu->performance > $ju){
            $add = $puu->performance - (($puu->performance - $ju) * $chain / 100);
        }else {
            if ($puu->performance < 1){
                $add = $ju;
            } else {
                $add = $puu->performance + (($ju - $puu->performance) * $chain / 100);
            }
        }
        $puu->performance = (($puu->performance * $puu->performanceCount) + $add) / ($puu->performanceCount + 1);
        if (($puu->performanceCount * 1) < 1){
            $puu->performanceCount = 1;
        }
        $puu->save();
    }


    public function create()
    {
        //
    }



    public function show(Kpivote $kpivote)
    {
        //
    }


    public function edit(Kpivote $kpivote)
    {
        //
    }


    public function update(Request $request, Kpivote $kpivote)
    {
        //
    }


    public function destroy(Kpivote $kpivote)
    {
        //
    }
}
