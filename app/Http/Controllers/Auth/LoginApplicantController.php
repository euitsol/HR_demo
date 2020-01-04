<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notice;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginApplicantController extends Controller
{

    use AuthenticatesUsers;

    protected $guard = 'applicant';

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginFormShow()
    {
        $this->redirectBackBack();
        return view('notice.loginFormNoAuth');
    }

    public function login(Request $request){
        if (auth()->guard('applicant')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $a = auth()->guard('applicant')->user();
            if ($request->nid != 0){
                $n = Notice::find($request->nid);
                return redirect()->route('applicant.dummy.1', ['aid' => $a->id, 'nid' => $n->id]);
            } else {
//                return redirect()->route('show-notices');
                return redirect(session('links')[1]);
            }
        }
        Session::flash('error', "Email or password are wrong.");
        return redirect()->back();
    }



    public function logout()
    {
        Auth::guard('applicant')->logout();
        return redirect('/');
    }

}
