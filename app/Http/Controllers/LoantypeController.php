<?php

namespace App\Http\Controllers;

use App\Job;
use App\Loantype;
use App\Payscale;
use App\User;
use App\Userloan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoantypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('loan')) {
            $loantypes = Loantype::all();
            $users = [];
            $us = User::where('job_id', '!=', null)->where('branch_id', Auth::user()->branch_id)->get();
            foreach ($us as $u) {
                $ul = Userloan::where('user_id', $u->id)->first();
                if ($ul && (($ul->due * 1) > 0)) {
                    //
                } else {
                    $users[] = $u;
                }
            }
            $loanUsers = [];
            $lus = Userloan::where('due', '>', 0)->get();
            foreach ($lus as $l) {
                $u = User::find($l->user_id);
                if ($u->branch_id == Auth::user()->branch_id) {
                    $loanUsers[] = $l;
                }
            }
            if (count($loanUsers) > 0) {
                foreach ($loanUsers as $lu) {
                    $lu['name'] = User::find($lu->user_id)->name;
                    $lu['loanType'] = Loantype::find($lu->loantype_id)->type;
                }
            }
            return view('loan_type.index', compact('loantypes', 'users', 'loanUsers'));
        } else {
            abort(403);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('loan')) {
            $this->validate($request, [
                'type' => 'required|unique:loantypes,type',
            ]);
            $lt = new Loantype;
            $lt->type = $request->type;
            $lt->save();
            Session::flash('LoanTypeCreateSuccess', "Loan Type '$lt->type' has been created successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function edit($ltid)
    {
        if (Auth::user()->can('loan')) {
            $ltedit = Loantype::find($ltid);
            $loantypes = Loantype::all();
            return view('loan_type/edit', compact('loantypes', 'ltedit'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $ltid)
    {
        if (Auth::user()->can('loan')) {
            $this->validate($request, [
                'type' => 'required|unique:loantypes,type',
            ]);
            $lt = Loantype::find($ltid);
            $lt->type = $request->type;
            $lt->update();
            Session::flash('LoanTypeUpdateSuccess', "Loan Type '$lt->type' has been created successfully.");
            return redirect()->route('loan.type');
        } else {
            abort(403);
        }
    }


    public function delete($ltid)
    {
        if (Auth::user()->can('loan')) {
            $user_loans = Userloan::where('loantype_id', $ltid)->count();
            if ($user_loans > 0) {
                Session::flash('error', 'Sorry, Loan type already used.');
                return redirect()->route('loan.type');
            } else {
                Loantype::find($ltid)->delete();
                Session::flash('success', 'Loan type has been deleted successfully');
                return redirect()->route('loan.type');
            }
        } else {
            abort(403);
        }
    }


    public function userLoan(Request $request)
    {
        if (Auth::user()->can('loan')) {
            $request->validate([
                'userId' => 'required',
            ]);
            return redirect()->route('user.loan.dummy', ['uid' => $request->userId]);
        } else {
            abort(403);
        }
    }


    public function userLoanDummy($uid)
    {
        if (Auth::user()->can('loan')) {
            $users = [];
            $us = User::where('job_id', '!=', null)->where('branch_id', Auth::user()->branch_id)->get();
            foreach ($us as $u) {
                $ul = Userloan::where('user_id', $u->id)->first();
                if ($ul && (($ul->due * 1) > 0)) {
                    //
                } else {
                    $users[] = $u;
                }
            }
            $user = User::find($uid);
            $j = Job::find($user->job_id);
            $user['maxLoanPerMonth'] = (Payscale::find($j->payscale_id)->pay) * ($j->maxLoanInPercentage) / 100;
            $loantypes = Loantype::all();
            return view('loan_type.userLoan', compact('users', 'user', 'loantypes'));
        } else {
            abort(403);
        }
    }


    public function userLoanStore(Request $request, $uid)
    {
        if (Auth::user()->can('loan')) {
            $request->validate([
                'loanAmount' => 'required',
                'months' => 'required',
                'loanType' => 'required',
            ]);
            $user = User::find($uid);
            $j = Job::find($user->job_id);
            $maxLoanPerMonth = (Payscale::find($j->payscale_id)->pay) * ($j->maxLoanInPercentage) / 100;
            if ($request->loanAmount > $maxLoanPerMonth) {
                Session::flash('unsuccess', 'Please do not mess with the original code :(');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
                Userloan::where('user_id', $uid)->delete();
                $u = new Userloan;
                $u->user_id = $uid;
                $u->loantype_id = $request->loanType;
                $u->total_amount = ($request->loanAmount * 1) * ($request->months * 1);
                $u->due = ($request->loanAmount * 1) * ($request->months * 1);
                $u->pay_per_month = $request->loanAmount;
                $u->save();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('success', "The Loan has been issued successfully.");
                return redirect()->route('loan.type');
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function userLoanEdit($lid)
    {
        if (Auth::user()->can('loan')) {
            $userLoan = Userloan::find($lid);
            $user = User::find($userLoan->user_id);
            $j = Job::find($user->job_id);
            $maxLoanPerMonth = (Payscale::find($j->payscale_id)->pay) * ($j->maxLoanInPercentage) / 100;
            return view('loan_type.userLoanEdit', compact('userLoan', 'user', 'maxLoanPerMonth'));
        } else {
            abort(403);
        }
    }


    public function userLoanUpdate(Request $request, $lid)
    {
        if (Auth::user()->can('loan')) {
            $request->validate([
                'loanAmount' => 'required',
                'months' => 'required',
            ]);
            $lt = Userloan::find($lid);
            $user = User::find($lt->user_id);
            $j = Job::find($user->job_id);
            $maxLoanPerMonth = (Payscale::find($j->payscale_id)->pay) * ($j->maxLoanInPercentage) / 100;
            if ($request->loanAmount > $maxLoanPerMonth) {
                Session::flash('unsuccess', 'Please do not mess with the original code :(');
                return redirect()->back();
            }
            $lt->total_amount = (($lt->total_amount * 1) - ($lt->due * 1)) + ($request->loanAmount * 1) * ($request->months * 1);
            $lt->due = ($request->loanAmount * 1) * ($request->months * 1);
            $lt->pay_per_month = $request->loanAmount;
            $lt->update();
            Session::flash('success', "The Loan has been updated successfully.");
            return redirect()->route('loan.type');
        } else {
            abort(403);
        }
    }


}
