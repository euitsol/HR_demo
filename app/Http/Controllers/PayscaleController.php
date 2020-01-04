<?php

namespace App\Http\Controllers;

use App\Job;
use App\Payscale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PayscaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('pay_scale')) {
            $ps = Payscale::all();
            return view('payscale.index', compact('ps'));
        } else {
            abort(403);
        }
    }


    public function create()
    {
        if (Auth::user()->can('pay_scale')) {
            return view('payscale.create');
        } else {
            abort(403);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('pay_scale')) {
            $this->validate($request, [
                'title' => 'required',
                'pay' => 'required|min:0',
                'compensation' => 'required|min:0',
                'benefit' => 'required|min:0',
                'BenefitDetails' => 'required',
                'familySupport' => 'required|min:0',
                'familySupportDetails' => 'required',
            ]);
            $p = new Payscale;
            $p->title = $request->title;
            $p->pay = $request->pay;
            $p->compensation = $request->compensation;
            $p->benefit = $request->benefit;
            $p->benefit_detail = $request->BenefitDetails;
            $p->family_support = $request->familySupport;
            $p->family_support_detail = $request->familySupportDetails;
            $p->save();
            Session::flash('PayScaleCreateSuccess', "Pay System has been created successfully.");
            return redirect()->route('payScale');
        } else {
            abort(403);
        }
    }


    public function show(Payscale $payscale)
    {
        //
    }


    public function edit($pid)
    {
        if (Auth::user()->can('pay_scale')) {
            $p = Payscale::find($pid);
            return view('payscale.edit', compact('p'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $pid)
    {
        if (Auth::user()->can('pay_scale')) {
            $this->validate($request, [
                'title' => 'required',
                'pay' => 'required|min:0',
                'compensation' => 'required|min:0',
                'benefit' => 'required|min:0',
                'BenefitDetails' => 'required',
                'familySupport' => 'required|min:0',
                'familySupportDetails' => 'required',
            ]);
            $p = Payscale::find($pid);
            $p->title = $request->title;
            $p->pay = $request->pay;
            $p->compensation = $request->compensation;
            $p->benefit = $request->benefit;
            $p->benefit_detail = $request->BenefitDetails;
            $p->family_support = $request->familySupport;
            $p->family_support_detail = $request->familySupportDetails;
            $p->update();
            Session::flash('PayScaleUpdateSuccess', "Pay System has been updated successfully.");
            return redirect()->route('payScale');
        } else {
            abort(403);
        }
    }


    public function destroy($pid)
    {
        if (Auth::user()->can('pay_scale')){
            $j = Job::where('payscale_id', $pid)->count();
            if ($j > 0) {
                Session::flash('error', 'Sorry, This Pay Scale has assigned jobs.');
                return redirect()->route('payScale');
            } else {
                Payscale::find($pid)->delete();
                Session::flash('success', 'Pay Scale has been deleted successfully');
                return redirect()->route('payScale');
            }
        } else {
            abort(403);
        }
    }
}
