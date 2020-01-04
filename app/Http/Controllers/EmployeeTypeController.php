<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmployeeTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('employee_type')){
            $etypes = EmployeeType::all();
            return view('employee_type.index', compact('etypes'));
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
        if (Auth::user()->can('employee_type')){
            $this->validate($request, [
                'type' => 'required|unique:employee_types,type',
            ]);
            $e = new EmployeeType;
            $e->type = $request->type;
            $e->save();
            Session::flash('EmployeeTypeCreateSuccess', "Loan Type '$e->type' has been created successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }

    public function show(EmployeeType $employeeType)
    {
        //
    }


    public function edit($etid)
    {
        if (Auth::user()->can('employee_type')){
            $etedit = EmployeeType::find($etid);
            $etypes = EmployeeType::all();
            return view('employee_type.edit', compact('etypes', 'etedit'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $etid)
    {
        if (Auth::user()->can('employee_type')){
            $this->validate($request, [
                'type' => 'required|unique:employee_types,type',
            ]);
            $e = EmployeeType::find($etid);
            $e->type = $request->type;
            $e->update();
            Session::flash('EmployeeTypeUpdateSuccess', "Employee Type '$e->type' has been updated successfully.");
            return redirect()->route('employee.type');
        } else {
            abort(403);
        }
    }


    public function destroy($etid)
    {
        if (Auth::user()->can('employee_type')){
            $e = Employee::where('employeeType_id', $etid)->count();
            if ($e > 0) {
                Session::flash('error', 'Sorry, Employee Type has assigned user.');
                return redirect()->route('employee.type');
            } else {
                EmployeeType::find($etid)->delete();
                Session::flash('success', 'Employee Type has been deleted successfully');
                return redirect()->route('employee.type');
            }
        } else {
            abort(403);
        }
    }
}
