<?php

namespace App\Http\Controllers;

use App\Job;
use App\Payscale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->can('designation')) {
            $jobs = Job::all();
            foreach ($jobs as $j) {
                $j['supervisor'] = Job::find($j->supervisor_id)->title;
                $j['is_supervisor'] = 0;
                $a = Job::where('supervisor_id', $j->id)->get();
                if (count($a) > 0) {
                    $j['is_supervisor'] = 1;
                }
            }
            $ps = Payscale::all();
            return view('job/index', compact('jobs', 'ps'));
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
        if (Auth::user()->can('designation')) {
            $this->validate($request, [
                'title' => 'required|unique:jobs,title',
                'maxLoan' => 'required|numeric|min:0|max:100',
                'provident' => 'required|numeric|min:0|max:100',
                'supervisor' => 'required',
                'payScale' => 'required',
            ]);
            $j = new Job;
            $j->title = $request->title;
            $j->maxLoanInPercentage = $request->maxLoan;
            $j->provident = $request->provident;
            $j->supervisor_id = $request->supervisor;
            $j->payscale_id = $request->payScale;
            $j->save();
            Session::flash('JobCreateSuccess', "Job '$j->title' has been created successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function show(Job $job)
    {
        //
    }


    public function edit($jid)
    {
        if (Auth::user()->can('designation')) {
            $jedit = Job::find($jid);
            $jedit['supervisor'] = Job::find($jedit->supervisor_id);
            $jedit['ps'] = Payscale::find($jedit->payscale_id);
            $jobs = Job::all();
            foreach ($jobs as $j) {
                $j['supervisor'] = Job::find($j->supervisor_id)->title;
                $j['is_supervisor'] = 0;
                $a = Job::where('supervisor_id', $j->id)->get();
                if (count($a) > 0) {
                    $j['is_supervisor'] = 1;
                }
            }
            $ps = Payscale::all();
            return view('job.edit', compact('jobs', 'jedit', 'ps'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $jid)
    {
        if (Auth::user()->can('designation')) {
            $this->validate($request, [
                'title' => 'required',
                'maxLoan' => 'required|numeric|min:0|max:100',
                'provident' => 'required|numeric|min:0|max:100',
                'supervisor' => 'required',
                'payScale' => 'required',
            ]);
            $j = Job::find($jid);
            if ($request->title != $j->title) {
                $this->validate($request, [
                    'title' => 'unique:jobs,title',
                ]);
            }
            $j->title = $request->title;
            $j->maxLoanInPercentage = $request->maxLoan;
            $j->provident = $request->provident;
            $j->supervisor_id = $request->supervisor;
            $j->payscale_id = $request->payScale;
            $j->update();
            Session::flash('JobUpdateSuccess', "Job '$j->title' has been updated successfully.");
            return redirect()->route('designation');
        } else {
            abort(403);
        }
    }


    public function destroy($jid)
    {
        if (Auth::user()->can('designation')) {
            $j = Job::find($jid);
            $a = Job::where('supervisor_id', $j->id)->get();
            if (count($a) > 0) {
                Session::flash('JobDeleteUnSuccessS', "Please Do Not change URL to Delete a Designation, Thanks !");
                return redirect()->back();
            }
            $users = $j->users()->get();
            if (count($users) > 0) {
                Session::flash('JobDeleteUnSuccess', "Can not delete Job '$j->title' as it has assigned employee.");
                return redirect()->back();
            } else {
                $j->delete();
                Session::flash('JobDeleteSuccess', "Job '$j->title' has been deleted successfully.");
                return redirect()->route('designation');
            }
        } else {
            abort(403);
        }
    }
}
