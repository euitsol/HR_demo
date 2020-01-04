<?php

namespace App\Http\Controllers;

use App\Job;
use App\Loantype;
use App\Pay;
use App\User;
use App\Userloan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserloanController extends Controller
{

    public function userInfoSearch()
    {
        if (Auth::user()->hasRole('info_user_loan')){
            return view('userLoanInfo/search');
        } else {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
        $uu = Auth::user();
        if ($uu->hasRole('admin')){
            $u = User::where('email', $request->email)->first();
        } else {
            $u = User::where('email', $request->email)->where('branch_id', $uu->branch_id)->first();
        }
        if ($u) {
            $j = $u->job()->first();
            if ($j && (($j->id) * 1) != 1) {
                return redirect()->route('userLoanInfoShow', ['uid' => $u->id]);
            } else {
                Session::flash('NoUserJob', "'$u->name' is not assigned to a job.");
                return redirect()->back();
            }
        } else {
            $e = $request->email;
            Session::flash('NoSuchUser', "No User with email id '$e' exist.");
            return redirect()->back();
        }
    }


    public function userLoanInfoShow($uid)
    {
        $data = $this->get_mppm($uid);
        $user = $data['user'];
        $userLoans = $data['userLoans'];
        if ($data['mppm'] == null){
            $job = Job::find($user->job_id);
            Session::flash('NoPayForJob', "Job '$job->title' has no pay in setup !!!");
            return redirect()->route('userLoanInfoSearch');
        }else {
            $mppm = $data['mppm'];
        }
        $loanTypes = Loantype::all();
        if ($userLoans) {
            foreach ($userLoans as $ul) {
                $a = Loantype::find($ul->loantype_id);
                $ul['loanType'] = $a->type;
            }
        }
        return view('userLoanInfo/index', compact('user', 'userLoans', 'loanTypes', 'mppm'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request, $uid)
    {
        $this->validate($request, [
            'loanType' => 'required',
            'totalAmount' => 'required|numeric|min:0',
            'monthNumber' => 'required|numeric|min:0',
            'payPerMonth' => 'required|numeric|min:0',
        ]);
        $data = $this->get_mppm($uid);
        $mppm = $data['mppm'];
        if ((($request->payPerMonth) * 1) > (($mppm) * 1)) {
            Session::flash('mppm', "Please Do Not Mess With The Original Code !!!");
            return redirect()->back();
        } else {
            $ul = new Userloan;
            $ul->user_id = $uid;
            $ul->loantype_id = $request->loanType;
            $ul->total_amount = $request->totalAmount;
            $ul->due = $request->totalAmount;
            $ul->pay_per_month = $request->payPerMonth;
            $ul->save();
            Session::flash('LoanStoreSuccess', "The Loan has been saved Successfully.");
            return redirect()->back();
        }
    }


    private function get_mppm($uid)
    {
        $data = [];
        $user = User::find($uid);
        $data['user'] = $user;
        $userLoans = Userloan::where('user_id', $uid)->where('is_paid', 0)->get();
        $data['userLoans'] = $userLoans;
        $td = 0;
        if ($userLoans) {
            foreach ($userLoans as $ul) {
                $td = $td + $ul->pay_per_month;
            }
        }
        $payGlobal = Pay::where('job_id', $user->job_id)->first();
        $job = Job::find($user->job_id);
        if ($payGlobal == null){
            $data['mppm'] = null;
        } else {
            $data['mppm'] = (($job->maxLoanInPercentage / 100) * ($payGlobal->pay - $payGlobal->tax + $payGlobal->compensation + $payGlobal->benefit + $payGlobal->family_support)) - $td;
        }
        return $data;
    }


    public function show(Userloan $userloan)
    {
        //
    }


    public function edit($lid)
    {
        $data = $this->get_mppmL($lid);
        $user = $data['user'];
        $mppm = $data['mppm'];
        $loan = $data['ul'];
        $ll = Loantype::find($loan->loantype_id);
        $loan['type'] = $ll->type;
        $loanTypes = Loantype::all();
        return view('userLoanInfo/edit', compact('loan', 'user', 'mppm', 'loanTypes'));
    }


    public function update(Request $request, $lid)
    {
        $this->validate($request, [
            'loanType' => 'required',
            'totalAmount' => 'required|numeric|min:0',
            'monthNumber' => 'required|numeric|min:0',
            'payPerMonth' => 'required|numeric|min:0',
            'AlreadyPaid' => 'required|numeric|min:0',
        ]);
        $data = $this->get_mppmL($lid);
        $ul = $data['ul'];
        $mppm = $data['mppm'];
        $ap = ($ul->total_amount *1) - ($ul->due *1);
        if ((($request->payPerMonth) * 1) > (($mppm) * 1) || (($request->totalAmount * 1) < $ap)) {
            Session::flash('mppm', "Please Do Not Mess With The Original Code !!!");
            return redirect()->back();
        } else {
            $ul->loantype_id = $request->loanType;
            $ul->total_amount = $request->totalAmount;
            $ul->due = ($request->totalAmount * 1) - $ap;
            $ul->pay_per_month = $request->payPerMonth;
            $ul->update();
            Session::flash('LoanUpdateSuccess', "The Loan has been saved Successfully.");
            return redirect()->back();
        }
    }


    private function get_mppmL($lid){
        $data = [];
        $ul = Userloan::find($lid);
        $data['ul'] = $ul;
        $user = User::find($ul->user_id);
        $data['user'] = $user;
        $userLoans = Userloan::where('user_id', $user->id)->where('is_paid', 0)->where('id', '!=', $lid)->get();
        $td = 0;
        if ($userLoans) {
            foreach ($userLoans as $ul) {
                $td = $td + $ul->pay_per_month;
            }
        }
        $payGlobal = Pay::where('job_id', $user->job_id)->first();
        $job = Job::find($user->job_id);
        $mppm = (($job->maxLoanInPercentage / 100) * ($payGlobal->pay - $payGlobal->tax + $payGlobal->compensation + $payGlobal->benefit + $payGlobal->family_support)) - $td;
        $data['mppm'] = $mppm;
        return $data;
    }




    public function destroy(Userloan $userloan)
    {
        //
    }
}
