<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Pension;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function setup()
    {
        if (Auth::user()->can('tax')){
            $branches = Branch::all();
            $taxes = Tax::orderBy('branch_id')->orderBy('from')->get();
            $p = Pension::find(1);
            $isGross = $p->tax_is_gross;
            $max_tax = $p->max_tax;
            $default_tax = $p->default_tax;
            foreach ($taxes as $t){
                $t['title'] = Branch::find($t->branch_id)->title;
            }
            return view('tax.setup', compact('branches', 'taxes', 'isGross', 'max_tax', 'default_tax'));
        } else {
            abort(403);
        }
    }


    public function isGross(Request $request)
    {
        if (Auth::user()->can('tax')){
            $p = Pension::find(1);
            if ($request->tax_is_gross != null){
                $p->tax_is_gross = 0;
            } else {
                $p->tax_is_gross = 1;
            }
            $p->update();
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('tax')){
            $request->validate([
                'branch' => 'required',
                'from' => 'required|min:1',
                'to' => 'required|gt:from',
                'tax' => 'required|numeric|min:0|max:100',
            ]);
            $taxes = Tax::where('branch_id', $request->branch)->get();
            foreach ($taxes as $ta){
                if ((($ta->to * 1) >= ($request->from * 1)) && (($ta->from * 1) <= ($request->to * 1))){
                    Session::flash('TaxCreateUnsuccess', "The Tax niche is clashed with other niche.");
                    return redirect()->back()->withInput();
                }
            }
            $t = new Tax;
            $t->branch_id = $request->branch;
            $t->from = $request->from;
            $t->to = $request->to;
            $t->tax = $request->tax;
            $t->save();
            Session::flash('TaxCreateSuccess', "The Tax niche has been created successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function defaultUpdate(Request $request)
    {
        if (Auth::user()->can('tax')){
            $request->validate([
                'maxTax' => 'required|numeric|min:1|max:100',
                'defaultTax' => 'required|numeric|min:0|max:100',
            ]);
            $p = Pension::find(1);
            $p->max_tax = $request->maxTax;
            $p->default_tax = $request->defaultTax;
            $p->update();
            Session::flash('TaxDefaultUpdate', "The Default Tax has been updated successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function edit($tid)
    {
        if (Auth::user()->can('tax')){
            $tedit = Tax::find($tid);
            $tedit['title'] = Branch::find($tedit->branch_id)->title;
            $branches = Branch::all();
            $taxes = Tax::orderBy('branch_id')->orderBy('from')->get();
            $p = Pension::find(1);
            $isGross = $p->tax_is_gross;
            $max_tax = $p->max_tax;
            $default_tax = $p->default_tax;
            foreach ($taxes as $t){
                $t['title'] = Branch::find($t->branch_id)->title;
            }
            return view('tax.edit', compact('branches', 'taxes', 'tedit', 'isGross', 'max_tax', 'default_tax'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $tid)
    {
        if (Auth::user()->can('tax')){
            $request->validate([
                'branch' => 'required',
                'from' => 'required|min:1',
                'to' => 'required|gt:from',
                'tax' => 'required|numeric|min:0|max:100',
            ]);
            $taxes = Tax::where('branch_id', $request->branch)->where('id', '!=', $tid)->get();
            foreach ($taxes as $ta){
                if ((($ta->to * 1) >= ($request->from * 1)) && (($ta->from * 1) <= ($request->to * 1))){
                    Session::flash('TaxUpdateUnsuccess', "The Tax niche is clashed with other niche.");
                    return redirect()->back();
                }
            }
            $t = Tax::find($tid);
            $t->branch_id = $request->branch;
            $t->from = $request->from;
            $t->to = $request->to;
            $t->tax = $request->tax;
            $t->update();
            Session::flash('TaxUpdateSuccess', "The Tax niche has been updated successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function destroy($tid)
    {
        if (Auth::user()->can('tax')){
            Tax::find($tid)->delete();
            Session::flash('TaxDeleteSuccess', "The Tax niche has been deleted successfully.");
            return redirect()->back();
        } else {
            abort(403);
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


    public function show(Tax $tax)
    {
        //
    }



}
