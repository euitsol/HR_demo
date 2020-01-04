<?php

namespace App\Http\Controllers;

use App\Incrementpolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IncrementpolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('increment_policy')) {
            $ip = Incrementpolicy::find(1);
            return view('increment.policy', compact('ip'));
        } else {
            abort(403);
        }
    }



    public function update(Request $request)
    {
        if (Auth::user()->can('increment_policy')) {
            $request->validate([
                'below' => 'required|numeric|min:1|max:100',
                'increment_1' => 'required|numeric|min:1|max:100',
                'above_1' => 'required|numeric|min:1|max:100',
                'increment_2' => 'required|numeric|min:1|max:100',
                'above_2' => 'required|numeric|min:1|max:100',
                'increment_3' => 'required|numeric|min:1|max:100',
                'increment_max' => 'required|numeric|min:1|max:100',
            ]);
            if (($request->above_1 * 1) >= ($request->above_2 * 1)){
                Session::flash('mess', "Please Do Not Mess With The Original Code !!!");
                return redirect()->back();
            }
            $ip = Incrementpolicy::find(1);
            $ip->below = $request->below;
            $ip->increment_1 = $request->increment_1;
            $ip->above_1 = $request->above_1;
            $ip->increment_2 = $request->increment_2;
            $ip->above_2 = $request->above_2;
            $ip->increment_3 = $request->increment_3;
            $ip->increment_max = $request->increment_max;
            if ($request->is_KPI != null){
                $ip->is_kpi = 1;
            } else {
                $ip->is_kpi = 0;
            }
            $ip->update();
            Session::flash('success', "Increment Policy Has been Updated successfully");
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


    public function show(Incrementpolicy $incrementpolicy)
    {
        //
    }


    public function edit(Incrementpolicy $incrementpolicy)
    {
        //
    }


    public function destroy(Incrementpolicy $incrementpolicy)
    {
        //
    }
}
