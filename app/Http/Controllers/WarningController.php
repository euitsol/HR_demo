<?php

namespace App\Http\Controllers;

use App\User;
use App\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class WarningController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $users = User::where('branch_id', Auth::user()->branch_id)->get();
        return view('warning.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'warningDescription' => 'required'
        ]);
        $warning = new Warning;
        $warning->branch_id = Auth::user()->branch_id;
        $warning->disputer = Auth::id();
        $warning->user_id = $request->name;
        $warning->department_id = null;
        $warning->description = $request->warningDescription;
        $warning->save();
        Session::flash('ComplainSuccess', "Your Complain has been sent to the Department Head");
        return redirect()->back();
    }

    public function warningShowDH()
    {
        if (Auth::user()->can('warningDH')) {
            $bid = Auth::user()->branch_id;
            $warnings = Warning::where('approveDH', '0')->where('hearing_type', '0')->where('branch_id', $bid)->get();
            $users = User::where('branch_id', $bid)->get();
            return view('warning.warningViewDH', compact('warnings', 'users'));
        } else {
            abort(403);
        }
    }

    public function warningDH_Store(Request $request)
    {
        if (Auth::user()->can('warningDH')) {
            $request->validate([
                'name' => 'required',
                'warningDescription' => 'required'
            ]);
            $warning = new Warning();
            $warning->branch_id = Auth::user()->branch_id;
            $warning->disputer = Auth::id();
            $warning->user_id = $request->name;
            $warning->department_id = null;
            $warning->description = $request->warningDescription;
            $warning->approveDH = 1;
            $warning->save();
            Session::flash('ComplainSuccess', "Your Complain has been sent successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function delete($wid)
    {
        if ((Auth::user()->can('warningDH')) || (Auth::user()->can('warningHR'))) {
            Warning::find($wid)->delete();
            return redirect()->back();
        } else {
            abort(403);
        }
    }

    public function warningForward($wid)
    {
        if (Auth::user()->can('warningDH')) {
            $warning = Warning::find($wid);
            $warning->approveDH = 1;
            $warning->save();
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function appealCreate()
    {
        return view('warning.appealCreate', [
            'warnings' => Warning::where('user_id', Auth::id())->where('approveDH', 1)->get()
        ]);
//        return view('test', [
//            'warnings' => Warning::where('user_id', Auth::id())->where('approveDH', 1)->get()
//        ]);
    }


    public function appealStore(Request $request)
    {
        $request->validate(['appeal' => 'required']);
        $warning = Warning::find($request->warning_id);
        $warning->appeal = $request->appeal;
        $warning->save();
        return redirect()->back();
    }


    public function warningShowHR()
    {
        if (Auth::user()->can('warningHR')) {
            $warnings = Warning::where('approveDH', 1)->where('hearing_type', '0')->where('branch_id', Auth::user()->branch_id)->get();
            return view('warning.warningViewHR', compact('warnings'));
        } else {
            abort(403);
        }
    }


    public function appealShow($wid)
    {
        if (Auth::user()->can('warningHR')) {
            return view('warning.appealView', [
                'appeal' => Warning::find($wid)
            ]);
        } else {
            abort(403);
        }
    }

    public function appealAccept($wid)
    {
        if (Auth::user()->can('warningHR')) {
            Warning::find($wid)->delete();
            return redirect()->route('warning.showHR');
        } else {
            abort(403);
        }
    }

    public function appealRejectHearing($wid)
    {
        if (Auth::user()->can('warningHR')) {
            return view('warning.appealRejectHearing', ['wid' => $wid]);
        } else {
            abort(403);
        }
    }

    public function verbalHearingCreate($wid)
    {
        if (Auth::user()->can('warningHR')) {
            return view('warning.verbalHearingCreate', ['wid' => $wid]);
        } else {
            abort(403);
        }
    }

    public function verbalHearingStore(Request $request)
    {
        if (Auth::user()->can('warningHR')) {
            $this->validate($request, [
                'hearing_message' => 'required',
            ]);
            $warning = Warning::find($request->warning_id);
            $warning->hearing_type = 'verbal';
            $warning->hearing_message = $request->hearing_message;
            $warning->save();
            return redirect()->route('warning.showHR');
        } else {
            abort(403);
        }
    }

    public function writtenHearingCreate($wid)
    {
        if (Auth::user()->can('warningHR')) {
            return view('warning.writtenHearingCreate', ['wid' => $wid]);
        } else {
            abort(403);
        }
    }

    public function writtenHearingStore(Request $request)
    {
        if (Auth::user()->can('warningHR')) {
            $this->validate($request, [
                'hearing_message' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $warning = Warning::find($request->warning_id);
                $warning->hearing_type = 'written';
                $warning->hearing_message = $request->hearing_message;
                $warning->save();
                $user = User::find($warning->user_id);
                $user->fatal_warning = $user->fatal_warning + 1;
                $user->save();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                return redirect()->route('warning.showHR');
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }

}
