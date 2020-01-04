<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Job;
use App\User;
use App\Userjobinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserjobinfoController extends Controller
{

    public function userInfoSearch()
    {
        if (Auth::user()->hasRole('info_user_job')){
            return view('userJobInfo/search');
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
        if ($u && $u->id != '1'){
            return redirect()->route('userJobInfoShow', $u->id);
        } else {
            $e = $request->email;
            Session::flash('NoSuchUser', "No User with email id '$e' exist.");
            return redirect()->back();
        }
    }


    public function userJobInfoShow($uid)
    {
        $userJobInfo = null;
        $job = null;
        $contract = null;
        $u = User::find($uid);
        $userJobInfo = $u->userjobinfo()->first();
        if ($userJobInfo){
            $job = Job::find($userJobInfo->job_id);
            $contract = Contract::find($userJobInfo->contract_id);
        }
        $jobs = Job::all();
        $contracts = Contract::all();
        return view('userJobInfo/index', compact('userJobInfo', 'u', 'jobs', 'contracts', 'job', 'contract'));
    }


    public function create()
    {
        //
    }


    public function storeAndUpdate(Request $request, $uid)
    {
        if ($uid != 1){
            $this->validate($request, [
                'job' => 'required',
                'description' => 'required',
                'contract' => 'required',
                'CL' => 'required',
            ]);
            $userJobInfo = Userjobinfo::where('user_id', $uid)->first();
            if ($userJobInfo) {
                $u = $userJobInfo;

            } else {
                $u = new Userjobinfo;
                $u->user_id = $uid;
            }
            $u->job_id = $request->job;
            $u->contract_id = $request->contract;
            $u->job_description = $request->description;
            $u->contract_length = $request->CL;
            $u->save();
            if ($request->hasFile('offerLetter')) {
                if (!$u->offer_letter) {
                    $img = $request->offerLetter;
                    $img_name = time() . $img->getClientOriginalName();
                    $a = $img->move('uploads/offerLetters', $img_name);
                    $d = 'uploads/offerLetters/' . $img_name;
                    $u->offer_letter = $d;
                    $u->update();
                } else {
                    unlink($u->offer_letter);
                    $img = $request->offerLetter;
                    $img_name = time() . $img->getClientOriginalName();
                    $a = $img->move('uploads/offerLetters', $img_name);
                    $d = 'uploads/offerLetters/' . $img_name;
                    $u->offer_letter = $d;
                    $u->update();
                }
            }
            if ($request->hasFile('resume')) {
                if (!$u->resume) {
                    $img = $request->resume;
                    $img_name = time() . $img->getClientOriginalName();
                    $a = $img->move('uploads/Resumes', $img_name);
                    $d = 'uploads/Resumes/' . $img_name;
                    $u->resume = $d;
                    $u->update();
                } else {
                    unlink($u->resume);
                    $img = $request->resume;
                    $img_name = time() . $img->getClientOriginalName();
                    $a = $img->move('uploads/Resumes', $img_name);
                    $d = 'uploads/Resumes/' . $img_name;
                    $u->resume = $d;
                    $u->update();
                }
            }
            $uu = User::find($uid);
            if ($uu->job_id != $request->job){
                $job = Job::find($request->job);
                $roles = $job->roles()->get();
                $uu->syncRoles($roles);
            }
            $uu->userjobinfo_id = $u->id;
            $uu->job_id = $request->job;
            $uu->update();
            Session::flash('UserUpdateSuccess', "User's Job Info has been updated successfully.");
            return redirect()->route('userJobInfoSearch');
        } else {
            dd('Do not mess with the original code !!!');
        }

    }


    public function show(Userjobinfo $userjobinfo)
    {
        //
    }


    public function edit(Userjobinfo $userjobinfo)
    {
        //
    }


    public function update(Request $request, Userjobinfo $userjobinfo)
    {
        //
    }


    public function destroy(Userjobinfo $userjobinfo)
    {
        //
    }
}
