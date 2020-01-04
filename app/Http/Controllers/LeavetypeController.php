<?php

namespace App\Http\Controllers;

use App\Leavetype;
use App\Leave;
use App\Leavedate;
use App\Pension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LeavetypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('leave')){
            $p = Pension::find(1);
            $maxLeavePerType = $p->max_leave_per_type;
            $lts = Leavetype::all();
            return view('leave/index', compact('maxLeavePerType', 'lts'));
        } else {
            abort(403);
        }
    }


    public function updatemlpt(Request $request)
    {
        if (Auth::user()->can('leave')){
            $this->validate($request, [
                'maxLeavePerType' => 'required|numeric|min:0',
            ]);
            $p = Pension::find(1);
            $p->max_leave_per_type = $request->maxLeavePerType;
            $p->update();
            Session::flash('mlptUpdateSuccess', "Max Leave Per Type has been updated successfully.");
            return redirect()->back();
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
        if (Auth::user()->can('leave')){
            $this->validate($request, [
                'type' => 'required|unique:leavetypes,type',
            ]);
            $lt = new Leavetype;
            $lt->type = $request->type;
            $lt->save();
            Session::flash('LTStoreSuccess', "Loan Type has been stored successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function show(Leavetype $leavetype)
    {
        //
    }


    public function edit($ltid)
    {
        if (Auth::user()->can('leave')){
            $p = Pension::find(1);
            $maxLeavePerType = $p->max_leave_per_type;
            $lts = Leavetype::all();
            $ltEdit = Leavetype::find($ltid);
            return view('leave/edit', compact('maxLeavePerType', 'lts', 'ltEdit'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $ltid)
    {
        if (Auth::user()->can('leave')){
            $this->validate($request, [
                'type' => 'required|unique:leavetypes,type',
            ]);
            $lt = Leavetype::find($ltid);
            $lt->type = $request->type;
            $lt->update();
            Session::flash('LTUpdateSuccess', "Loan Type has been updated successfully.");
            return redirect()->route('leave.setup');
        } else {
            abort(403);
        }
    }


    public function delete($ltid)
    {
        if (Auth::user()->can('leave')){
            $leave_date = Leavedate::where('leavetype_id', $ltid)->count();
            $leave = Leave::where('leavetype_id', $ltid)->count();
            if (($leave_date > 0) || ($leave > 0)) {
                Session::flash('error', 'Sorry, Leave type already used.');
                return redirect()->back();
            } else {
                Leavetype::find($ltid)->delete();
                Session::flash('success', 'Leave type has been deleted successfully');
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }

    public function destroy(Leavetype $leavetype)
    {
        //
    }
}
