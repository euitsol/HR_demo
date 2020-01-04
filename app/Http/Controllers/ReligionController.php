<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReligionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('religion')){
            $rs = Religion::all();
            return view('religion.index', compact('rs'));
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
        if (Auth::user()->can('religion')){
            $this->validate($request, [
                'name' => 'required|unique:religions,name',
            ]);
            $r = new Religion;
            $r->name = $request->name;
            $r->save();
            Session::flash('ReligionCreateSuccess', "Religion '$r->name' has been successfully entered.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function show(Religion $religion)
    {
        //
    }


    public function edit($rid)
    {
        if (Auth::user()->can('religion')){
            $redit = Religion::find($rid);
            $rs = Religion::all();
            return view('religion.edit', compact('rs', 'redit'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $rid)
    {
        if (Auth::user()->can('religion')){
            $this->validate($request, [
                'name' => 'required|unique:religions,name',
            ]);
            $r = Religion::find($rid);
            $r->name = $request->name;
            $r->save();
            Session::flash('ReligionUpdateSuccess', "Religion '$r->name' has been updated successfully.");
            return redirect()->route('religion');
        } else {
            abort(403);
        }
    }


    public function destroy($rid)
    {
        if (Auth::user()->can('religion')){
            $user = Employee::where('religion_id', $rid)->count();
            if ($user > 0) {
                Session::flash('error', 'Sorry, Religion has assigned user.');
                return redirect()->route('religion');
            } else {
                Religion::find($rid)->delete();
                Session::flash('success', 'Religion name has been deleted successfully');
                return redirect()->route('religion');
            }
        } else {
            abort(403);
        }
    }
}
