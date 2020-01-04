<?php

namespace App\Http\Controllers;

use App\Bonus;
use App\Employee;
use App\Religion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BonusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('bonus')) {
            $religions = Religion::all();
            $employees = Employee::where('is_bonus', '1')->get();
            $users = [];
            foreach ($employees as $e){
                $users[] = User::find($e->user_id);
            }
            $bonus = Bonus::find(1);
            return view('bonus.setup', compact('bonus', 'religions', 'users', 'bonus'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request)
    {
        if (Auth::user()->can('bonus')) {
            $request->validate([
                'salaryPercentage' => 'required|numeric|min:1|max:100',
                'religion' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $b = Bonus::find(1);
                $b->percentage = $request->salaryPercentage;
                if ($request->isGross != null){
                   $b->is_gross = 1;
                } else {
                    $b->is_gross = 0;
                }
                $b->update();
                if ($request->religion == 'all'){
                    Employee::query()->update(['is_bonus' => 1]);
                }else {
                    Employee::query()->update(['is_bonus' => 0]);
                    DB::table('employees')->where('religion_id', $request->religion)->update(['is_bonus' => 1]);
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('BonusUpdateSuccess', "The Bonus Setup has been updated successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function reset()
    {
        if (Auth::user()->can('bonus')) {
            Employee::query()->update(['is_bonus' => 0]);
            Session::flash('BonusResetSuccess', "The Bonus Setup has been reset successfully.");
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


    public function show(Bonus $bonus)
    {
        //
    }


    public function edit(Bonus $bonus)
    {
        //
    }



    public function destroy(Bonus $bonus)
    {
        //
    }
}
