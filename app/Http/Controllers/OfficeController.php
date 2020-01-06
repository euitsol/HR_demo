<?php

namespace App\Http\Controllers;

use App\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('office_setup')){
            $office = Office::where('branch_id', Auth::user()->branch_id)->first();
            return view('office.index', compact('office'));
        } else {
            abort(403);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('office_setup')){
            DB::beginTransaction();
            try {
                $os = Office::where('branch_id', Auth::user()->branch_id)->first();
                if (!$os){
                    $os = new Office;
                    $os->branch_id = Auth::user()->branch_id;
                }
                if ($request->filled('footerText')) {
                    $os->footer = $request->footerText;
                }
                if ($request->hasFile('logo')) {
                    if ($os->logo) {
                        unlink($os->logo);
                    }
                    $img = $request->logo;
                    $img_name = time() . $img->getClientOriginalName();
                    $img->move('uploads/Office', $img_name);
                    $d = 'uploads/Office/' . $img_name;
                    $os->logo = $d;
                }
                if ($request->filled('logoBG')) {
                    $os->logo_bg = $request->logoBG;
                }
                $os->save();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Storage::disk('local')->delete('office');
                Storage::disk('local')->put('office', Office::where('branch_id', Auth::user()->branch_id)->first());
                Session::flash('OfficeUpdateSuccess', "The Office Setup has been updated successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }



}
