<?php

namespace App\Http\Controllers;

use App\Loantype;
use App\Userloan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoantypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('loan')){
            $loantypes = Loantype::all();
            return view('loan_type/index', compact('loantypes'));
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
        if (Auth::user()->can('loan')){
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


    public function show(Loantype $loantype)
    {
        //
    }


    public function edit($ltid)
    {
        if (Auth::user()->can('loan')){
            $ltedit = Loantype::find($ltid);
            $loantypes = Loantype::all();
            return view('loan_type/edit', compact('loantypes', 'ltedit'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $ltid)
    {
        if (Auth::user()->can('loan')){
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
        if (Auth::user()->can('loan')){
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



    public function destroy(Loantype $loantype)
    {
        //
    }
}
