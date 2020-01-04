<?php

namespace App\Http\Controllers;

use App\Pension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PensionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->can('pension')){
            $p = Pension::find(1);
            return view('pension/index', compact('p'));
        } else {
            abort(403);
        }
    }

    public function pensionIsActiveChange()
    {
        if (Auth::user()->can('pension')){
            $p = Pension::find(1);
            if (($p->is_active * 1) == 0) {
                // not active, make active
                $p->is_active = 1;
                $p->save();
                Session::flash('PensionActiveSuccess', "Pension System has been Activated Successfully !");
                return redirect()->back();
            } else {
                // active, need to deactivate
                $p->is_active = 0;
                $p->save();
                Session::flash('PensionDEActiveSuccess', "Pension System has been Deactivated Successfully !");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function pensionIsBoth()
    {
        if (Auth::user()->can('pension')){
            $p = Pension::find(1);
            if (($p->is_both * 1) == 0) {
                // not active, make active
                $p->is_both = 1;
                $p->save();
                Session::flash('PensionBothSuccess', "Now Company will cut salary for Pension !");
                return redirect()->back();
            } else {
                // active, need to deactivate
                $p->is_both = 0;
                $p->save();
                Session::flash('PensionDEBothSuccess', "Now Company will no longer cut salary for Pension !");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function isGrossAjax()
    {
        if (Auth::user()->can('pension')){
            $p = Pension::find(1);
            if (($p->is_gross_salary * 1) == 0) {
                // not active, make active
                $p->is_gross_salary = 1;
                $p->save();
                $a = 'Gross';
                return $a;
            } else {
                // active, need to deactivate
                $p->is_gross_salary = 0;
                $p->save();
                $a = 'Total';
                return $a;
            }
        } else {
            abort(403);
        }
    }


//    public function isGrossTextAjax()
//    {
//        if (Auth::user()->can('pension')){
//            $p = Pension::find(1);
//            if (($p->is_gross_salary * 1) == 0){
//                $a = 'Total';
//                return $a;
//            }else {
//                $a = 'Gross';
//                return $a;
//            }
//        } else {
//            abort(403);
//        }
//    }


    public function update(Request $request)
    {
        if (Auth::user()->can('pension')){
            $this->validate($request, [
                'totalPay' => 'required|numeric|min:0',
                'salaryPercentage' => 'required|numeric|min:0|max:100',
                'maxWithdrawal' => 'required|numeric|min:0|max:100',
                'perMonthWithdrawal' => 'required|numeric|min:0|max:100',
//            'companyPay' => 'required|numeric|min:0|max:100',
            ]);
            $p = Pension::find(1);
            $p->total_pay_months = $request->totalPay;
            $p->salary_percentage = $request->salaryPercentage;
            $p->max_withdraw_percentage = $request->maxWithdrawal;
            $p->per_month_withdraw_percentage = $request->perMonthWithdrawal;
            if ($request->filled('companyPay')){
                $p->company_pay_percentage = $request->companyPay;
            }
            $p->update();
            Session::flash('PensionUpdateSuccess', "Pension System has been updated successfully !");
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
        //
    }


    public function show(Pension $pension)
    {
        //
    }


    public function edit(Pension $pension)
    {
        //
    }

    public function destroy(Pension $pension)
    {
        //
    }
}
