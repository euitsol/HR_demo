<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AclController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('role')) {
            $roles = Role::all();
            $menus = Menu::all();
            $permissions = Permission::where('is_menu', 1)->get();
            foreach ($menus as $m){
                $m['permission'] = 0;
                foreach ($permissions as $p){
                    if ($p->menu_id == $m->id){
                        $m['permission'] = 1;
                        break;
                    }
                }
            }
            $sps = Permission::where('is_menu', 0)->get();
            return view('role.index', compact('roles', 'menus', 'permissions', 'sps'));
        } else {
            abort(403);
        }
    }


    public function permission()
    {
        if (Auth::user()->can('permission')) {
            $ps = Permission::where('is_menu', 0)->get();
            return view('permission.index', compact('ps'));
        } else {
            abort(403);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('role')) {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'displayName' => 'required',
                'permission' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $r = new Role;
                $r->name = $request->name;
                $r->display_name = $request->displayName;
                $r->save();
                foreach ($request->permission as $m){
                    $p[] = Permission::where('menu_id', $m)->first()->id;
                }
                $r->attachPermissions($p);
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('roleCreateSuccess', "The role has been created successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($rid)
    {
        if (Auth::user()->can('role') && ($rid * 1) > 2) {
            $redit = Role::find($rid);
            $roles = Role::all();
            $menus = Menu::all();
            $permissions = Permission::where('is_menu', 1)->get();
            foreach ($menus as $m){
                $m['pid'] = null;
                $m['permission'] = 0;
                foreach ($permissions as $p){
                    if ($p->menu_id == $m->id){
                        $m['permission'] = 1;
                        $m['pid'] = $p->id;
                        break;
                    }
                }
            }
            $sps = Permission::where('is_menu', 0)->get();
            $pedits = $redit->permissions()->get();
            return view('role.edit', compact('redit', 'roles', 'permissions', 'pedits', 'menus', 'sps'));
        } else {
            abort(403);
        }
    }


    public function permissionEdit($pid)
    {
        if (Auth::user()->can('permission')) {
            $pedit = Permission::find($pid);
            $ps = Permission::where('is_menu', 0)->get();
            return view('permission.edit', compact('ps', 'pedit'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $rid)
    {
        if (Auth::user()->can('role') && ($rid * 1) > 2) {
            $this->validate($request, [
                'name' => 'required',
                'displayName' => 'required',
                'permission' => 'required',
            ]);
            $r = Role::find($rid);
            if ($r->name != $request->name) {
                $this->validate($request, [
                    'name' => 'unique:roles,name',
                ]);
            }
            DB::beginTransaction();
            try {
                $r->name = $request->name;
                $r->display_name = $request->displayName;
                $r->update();
                foreach ($request->permission as $m){
                    $p[] = Permission::where('menu_id', $m)->first()->id;
                }
                $r->syncPermissions($p);
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('roleUpdateSuccess', "The role has been updated successfully.");
                return redirect()->route('role');
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->route('role');
            }

        } else {
            abort(403);
        }
    }


    public function permissionUpdate(Request $request, $pid)
    {
        if (Auth::user()->can('permission')) {
            $this->validate($request, [
                'displayName' => 'required',
                'description' => 'required',
            ]);
            $p = Permission::find($pid);
            $p->display_name = $request->displayName;
            $p->description = $request->description;
            $p->update();
            Session::flash('permissionUpdateSuccess', "The Permission has been updated successfully.");
            return redirect()->route('permission');
        } else {
            abort(403);
        }
    }

    public function destroy($rid)
    {
        if (Auth::user()->can('role') && ($rid * 1) > 2) {
            $r = Role::find($rid);
            $a = User::whereRoleIs([$r->name])->get();
            if (count($a) > 0) {
                Session::flash('canNoteDelete', "Can not delete Role with assigned users !");
                return redirect()->back();
            } else {
                $r->delete();
                Session::flash('DeleteSuccess', "The Role has bees deleted successfully");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }
}
