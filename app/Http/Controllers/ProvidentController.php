<?php

namespace App\Http\Controllers;

use App\Provident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProvidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->can('provident_fund')) {
            $p = Provident::find(1);
            return view('provident.index', compact('p'));
        } else {
            abort(403);
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->can('provident_fund')) {
            $this->validate($request, [
                'usersShare' => 'required|numeric|min:0|max:100',
                'companysShare' => 'required|numeric|min:0|max:100',
            ]);
            $p = Provident::find(1);
            $p->from_user = $request->usersShare;
            $p->from_employer = $request->companysShare;
            if ($request->is_gross) {
                $p->is_gross = 1;
            } else {
                $p->is_gross = 0;
            }
            $p->update();
            Session::flash('ProvidentUpdateSuccess', "Provident Fund has been updated successfully !");
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


    public function show(Provident $provident)
    {
        //
    }


    public function edit(Provident $provident)
    {
        //
    }


    public function destroy(Provident $provident)
    {
        //
    }
}
