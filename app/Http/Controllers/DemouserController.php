<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DemouserController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email|unique:applicants,email',
            'password' => 'required|confirmed',
            'name' => 'required',
        ]);
        DB::beginTransaction();
        try {
            // create branch with same name
            $b = new Branch;
            $b->title = $request->email;
            $b->save();
            // create demo user
            $u = new User;
            $u->name = $request->name;
            $u->email = $request->email;
            $u->password = bcrypt($request->password);
            $u->branch_id = $b->id;
            $u->save();
            $u->attachRole(1);
            // make the user loggedin
            Auth::login($u, true);
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }
        if ($success) {
            Session::flash('success', "The User '$request->name' has been updated successfully.");
            return redirect()->route('home');
        } else {
            Session::flash('unsuccess', "Something went wrong :(");
            return redirect()->route('users');
        }
    }


    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
