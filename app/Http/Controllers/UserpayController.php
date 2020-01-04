<?php

namespace App\Http\Controllers;

use App\Pay;
use App\User;
use App\Userpay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserpayController extends Controller
{
    public function userInfoSearch()
    {
        if (Auth::user()->hasRole('info_user_pay')){
            return view('userPayInfo/search');
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
        if ($u){
            return redirect()->route('userPayInfoShow', $u->id);
        } else {
            $e = $request->email;
            Session::flash('NoSuchUser', "No User with email id '$e' exist.");
            return redirect()->back();
        }
    }
    public function userPayInfoShow($uid)
    {
        $u = User::find($uid);
        $userPayInfo = $u->userpay()->first();
        $pay = null;
        if ($userPayInfo == null){
            $jid = $u->job_id;
            if ($jid){
                $pay = Pay::where('job_id', $jid)->first();
            }
        }
        return view('userPayInfo/index', compact('userPayInfo', 'u', 'pay'));
    }


    public function create()
    {
        //
    }


    public function storeAndUpdate(Request $request, $uid)
    {
        $this->validate($request, [
            'pay' => 'required|min:0',
            'tax' => 'required|min:0',
            'compensation' => 'required|min:0',
            'benefit' => 'required|min:0',
            'BDetails' => 'required',
            'CFS' => 'required|min:0',
            'SDetails' => 'required',
        ]);
        $userPayInfo = Userpay::where('user_id', $uid)->first();
        if ($userPayInfo) {
            $u = $userPayInfo;
        } else {
            $u = new Userpay;
            $u->user_id = $uid;
        }
        $u->pay = $request->pay;
        $u->tax = $request->tax;
        $u->compensation = $request->compensation;
        $u->benefit = $request->benefit;
        $u->benefit_detail = $request->BDetails;
        $u->family_support = $request->CFS;
        $u->family_support_detail = $request->SDetails;
        $u->save();
        $u = Userpay::where('user_id', $uid)->first();
        $uu = User::find($uid);
        $uu->userpay_id = $u->id;
        $uu->update();
        Session::flash('UserUpdateSuccess', "User's Pay Info has been updated successfully.");
        return redirect()->route('userPayInfoSearch');
    }


    public function show(Userpay $userpay)
    {
        //
    }


    public function edit(Userpay $userpay)
    {
        //
    }


    public function update(Request $request, Userpay $userpay)
    {
        //
    }


    public function destroy(Userpay $userpay)
    {
        //
    }
}
