<?php

namespace App\Http\Controllers;

use App\User;
use App\Userinfo;
//use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class UserinfoController extends Controller
{

    public function userInfoSearch()
    {
        if (Auth::user()->hasRole('info_user')) {
            return view('userinfo/search');
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
        if ($uu->hasRole('admin')) {
            $u = User::where('email', $request->email)->first();
        } else {
            $u = User::where('email', $request->email)->where('branch_id', $uu->branch_id)->first();
        }
        if ($u) {
            return redirect()->route('userInfoShow', $u->id);
        } else {
            $e = $request->email;
            Session::flash('NoSuchUser', "No User with email id '$e' exist.");
            return redirect()->back();
        }
    }

    public function userInfoShow($uid)
    {
        $u = User::find($uid);
        $userinfo = null;
        if ($u) {
            $userinfo = $u->userinfo()->first();
        }
        return view('userinfo/index', compact('userinfo', 'u'));
    }


    public function create()
    {
        //
    }


    public function storeAndUpdate(Request $request, $uid)
    {
        $this->validate($request, [
            'dob' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'EC' => 'required',
            'AS' => 'required',
            'bloodGroup' => 'required',
            'reference' => 'required',
        ]);
        $userinfo = Userinfo::where('user_id', $uid)->first();
        if ($userinfo) {
            $u = $userinfo;
        } else {
            $u = new Userinfo;
            $u->user_id = $uid;
        }
        $u->dob = $request->dob;
        $u->mobile = $request->mobile;
        $u->address = $request->address;
        $u->emergency_contract = $request->EC;
        $u->academic_skills = $request->AS;
        $u->blood_group = $request->bloodGroup;
        $u->reference = $request->reference;
        $u->save();
        // check if image uploaded
        $uu = User::find($uid);
        if ($request->hasFile('image')) {
            // first check image already given or not
            if ($uu->image) {
                unlink($uu->image);
            }
            $img = $request->image;
            $img_name = time() . $img->getClientOriginalName();
//            $a = $img->move('uploads/images', $img_name);

            // save will auto move the image but will not auto create the folder
            ini_set('memory_limit', '256M');
            Image::make($img)->resize(100, 100)->save('uploads/images/' . $img_name);


            $d = 'uploads/images/' . $img_name;
            $uu->image = $d;
            $uu->save();
        }
        $userinfo = Userinfo::where('user_id', $uid)->first();
        $uu->userinfo_id = $userinfo->id;
        $uu->update();
        Session::flash('UserUpdateSuccess', "User's General Info has been updated successfully.");
        return redirect()->route('userinfosearch');
//        return redirect()->back();
    }


    public function show(Userinfo $userinfo)
    {
        //
    }


    public function edit(Userinfo $userinfo)
    {
        //
    }


    public function update(Request $request, Userinfo $userinfo)
    {
        //
    }


    public function destroy(Userinfo $userinfo)
    {
        //
    }




    /////////////////////////////////////////////////
    ///
    public function cv($id)
    {
        $userInfo = UserInfo::where('user_id', $id)->first();
        $user = $userInfo->user;
        return \PDF::loadView('userinfo.cv', [
            'image' => $user->image,
            'name' => $user->name,
            'jobTitle' => $user->job->title,
            'email' => $user->email,
            'mobile' => $userInfo->mobile,
            'dob' => $userInfo->dob,
            'blood_group' => $userInfo->blood_group,
            'emergency_contract' => $userInfo->emergency_contract,
            'address' => $userInfo->address,
            'academic_skills' => $userInfo->academic_skills,
            'reference' => $userInfo->reference
        ])->setPaper('a4', 'portrait')->stream('cv.pdf');
    }


}
