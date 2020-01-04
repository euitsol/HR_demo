<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->can('menu')){
            $ms = Menu::all();
            return view('menu.index', compact('ms'));
        } else {
            abort(403);
        }
    }


    public function edit($mid)
    {
        if (Auth::user()->can('menu')){
            $medit = Menu::find($mid);
            $ms = Menu::all();
            return view('menu.edit', compact('ms', 'medit'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $mid)
    {
        if (Auth::user()->can('menu')){
            $this->validate($request, [
                'displayName' => 'required',
                'description' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $m = Menu::find($mid);
                $m->display_name = $request->displayName;
                $m->description = $request->description;
                $m->update();
                $p = Permission::where('is_menu', 1)->where('menu_id', $mid)->first();
                if ($p){
                    $p->display_name = $request->displayName;
                    $p->update();
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                // session()->forget('menu');
                // session(['menu' => Menu::all()]);
                Storage::disk('local')->delete('menu');
                Storage::disk('local')->put('menu', Menu::all());
                Session::flash('menuUpdateSuccess', "The Menu Name has been updated successfully.");
                return redirect()->route('menu.setup');
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
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


    public function show(Menu $menu)
    {
        //
    }



    public function destroy(Menu $menu)
    {
        //
    }
}
