<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Comment;
use App\Commentg;
use App\Commentt;
use App\Increment;
use App\Job;
use App\Leave;
use App\Leavedate;
use App\Pension;
use App\PrivateMessage;
use App\Promotion;
use App\Provident;
use App\Reply;
use App\Replyg;
use App\Replyt;
use App\Role;
use App\Salary;
use App\Tagcg;
use App\Termination;
use App\User;
use App\Userassign;
use App\Userinfo;
use App\Userjobinfo;
use App\Userloan;
use App\Userpay;
use App\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TerminationController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('account_close')){
            // It will take data from employee table ////////////////////////////////////////////////////////////////////////
            $users = User::all();
            return view('Termination/index', compact('users'));
        } else {
            abort(403);
        }
    }


    public function ac(Request $request){
        $this->validate($request, [
            'user' => 'required',
            'reason' => 'required',
        ]);
        $t = new Termination;
        $t->reason = $request->reason;
        if ($request->hasFile('file')) {
            $img = $request->file;
            $img_name = time() . $img->getClientOriginalName();
            $a = $img->move('uploads/ac', $img_name);
            $d = 'uploads/ac/' . $img_name;
            $t->document = $d;
        }
        $u = User::find($request->user);
        $rs = Role::all();
        foreach ($rs as $r){
            $u->detachRole($r);
        }
        $t->name = $u->name;
        $t->email = $u->email;
        $ui = Userinfo::where('user_id', $request->user)->first();
        if ($ui){
            $t->dob = $ui->dob;
            $t->address = $ui->address;
            $t->mobile = $ui->mobile;
        }
        $uji = Userjobinfo::where('user_id', $request->user)->first();
        if ($uji){
            $j = Job::find($uji->job_id);
            $t->job_title = $j->title;
        }
        $t->loan_due = Userloan::where('user_id', $request->user)->sum('due');
        $provident = Salary::where('user_id', $request->user)->sum('total_provident_fund');
        $t->pf = $provident;
        $t->due_pf = $provident;
        $pension = Salary::where('user_id', $request->user)->sum('total_pension');
        $t->pension = $pension;
        $t->due_pension = $pension;
        $p = Pension::find(1);
        $t->pension_per_month = ($pension * 1) * ($p->per_month_withdraw_percentage * 1) / 100;
        $t->save();
        Attendance::where('user_id', $request->user)->delete();
        Commentg::where('user_id', $request->user)->delete();
        Comment::where('user_id', $request->user)->delete();
        Commentt::where('user_id', $request->user)->delete();
        Increment::where('user_id', $request->user)->delete();
        Leavedate::where('user_id', $request->user)->delete();
        Leave::where('user_id', $request->user)->delete();
        PrivateMessage::where('sender_id', $request->user)->orWhere('receiver_id', $request->user)->delete();
        Promotion::where('user_id', $request->user)->delete();
        Provident::where('user_id', $request->user)->delete();
        Reply::where('user_id', $request->user)->delete();
        Replyg::where('user_id', $request->user)->delete();
        Replyt::where('user_id', $request->user)->delete();
        Salary::where('user_id', $request->user)->delete();
        Tagcg::where('user_id', $request->user)->delete();
        Userassign::where('user_id', $request->user)->delete();
        $ui->delete();
        $uji->delete();
        Userloan::where('user_id', $request->user)->delete();
        Userpay::where('user_id', $request->user)->delete();
        Warning::where('user_id', $request->user)->delete();
        $u->delete();
        Session::flash('AccountCloseSuccess', "User's Account has been closed successfully.");
        return redirect()->back();
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        //
    }


    public function edit()
    {
        //
    }


    public function update(Request $request)
    {
        //
    }


    public function destroy()
    {
        //
    }
}
