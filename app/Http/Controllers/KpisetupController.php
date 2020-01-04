<?php

namespace App\Http\Controllers;

use App\Kpisetup;
use App\Kpivote;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KpisetupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('kpi')){
            $setup = Kpisetup::find(1);
            return view('kpi.setup.index', compact('setup'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request)
    {
        if (Auth::user()->can('kpi')){
            $request->validate([
                'attendanceTotal' => 'required|numeric|min:0',
                'attendanceTarget' => 'required|numeric|min:0',
                'attitudeTotal' => 'required|numeric|min:0',
                'attitudeTarget' => 'required|numeric|min:0',
                'projectTotal' => 'required|numeric|min:0',
                'projectTarget' => 'required|numeric|min:0',
                'judgementTotal' => 'required|numeric|min:0',
                'judgementTarget' => 'required|numeric|min:0',
                'promotion' => 'required|numeric|min:1|max:100',
                'chain' => 'required|numeric|min:0|max:100',
            ]);
            $s = Kpisetup::find(1);
            $s->attendance = $request->attendanceTotal;
            $s->attendanceTarget = $request->attendanceTarget;
            $s->attitude = $request->attitudeTotal;
            $s->attitudeTarget = $request->attitudeTarget;
            $s->project = $request->projectTotal;
            $s->projectTarget = $request->projectTarget;
            $s->judgement = $request->judgementTotal;
            $s->judgementTarget = $request->judgementTarget;
            $s->promotion = $request->promotion;
            $s->chain = $request->chain;
            $s->update();
            Session::flash('updateSuccess', "KPI Setup has been updated successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function kpiVotingOn(){
        if (Auth::user()->can('kpi')){
            DB::beginTransaction();
            try {
                Kpivote::query()->update(['attitude' => 0, 'attitudeCount' => 0, 'performance' => 0, 'performanceCount' => 0,]);
                User::query()->update(['kpiVoting' => 1]);
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('kpiVotingOn', "KPI voting System has been turned on successfully.");
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


    public function show(Kpisetup $kpisetup)
    {
        //
    }


    public function edit(Kpisetup $kpisetup)
    {
        //
    }


    public function destroy(Kpisetup $kpisetup)
    {
        //
    }
}
