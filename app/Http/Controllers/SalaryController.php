<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Bonus;
use App\Branch;
use App\Employee;
use App\Job;
use App\Leavedate;
use App\Payscale;
use App\Pension;
use App\Provident;
use App\Salary;
use App\Tax;
use App\User;
use App\Userloan;
use App\Userpay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('salary_generate')) {
            $lastMonth = Carbon::now()->subMonth()->format('F'); // June
//            $salaries = Salary::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->where('branch_id', Auth::user()->branch_id)->get();
            $salaries = Salary::whereMonth('created_at', '=', Carbon::now()->month)->where('branch_id', Auth::user()->branch_id)->get();
            if (count($salaries) > 0) {
                foreach ($salaries as $s) {
                    $s['user_name'] = User::find($s->user_id)->name;
                    $s['branch'] = Branch::find($s->branch_id)->title;
                }
            }
            $pension = Pension::find(1);
            return view('salary/index', compact('lastMonth', 'salaries', 'pension'));
        } else {
            abort(403);
        }
    }


    public function generate($is_over, $is_pay_over)
    {
        // right now $is_over will be always be 1
        if (Auth::user()->can('salary_generate')) {
            $employees = Employee::all();
            $p = Pension::find(1);
            $provident = Provident::find(1);
            DB::beginTransaction();
            try {
                foreach ($employees as $uwj) {
                    $user = User::find($uwj->user_id);
                    $job = Job::find($user->job_id);
                    $up = Userpay::where('user_id', $uwj->user_id)->first();
                    if (!$up) {
                        $up = Payscale::find($job->payscale_id);
                    }
                    $s = new Salary;
                    $s->user_id = $uwj->user_id;
                    $s->branch_id = $user->branch_id;
                    // overtime calculation start //
                    // get last month all row from attendance table
                    $attendances = Attendance::where('user_id', $uwj->user_id)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();
//                         dd($attendances);
                    $overTimes = [];
                    $underTimes = [];
                    // count total over time of everyday attendant
                    if (count($attendances) > 0) {
                        foreach ($attendances as $a) {
                            $workingTime = $p->pdwh;
                            $workingTime = $this->decimal_to_hour($workingTime);
                            $total_hours = $this->date_time_difference($a->time_in, $a->time_out);
                            if (strtotime($total_hours) > strtotime($workingTime)) {
                                $over_time = $this->date_time_difference($total_hours, $workingTime);
                                $overTimes[] = $over_time;
                            }
                            if (strtotime($total_hours) < strtotime($workingTime)) {
                                $under_time = $this->date_time_difference($total_hours, $workingTime);
                                $underTimes[] = $under_time;
                            }
                        }
                        $totalOverTime1 = strtotime($this->sum_times($overTimes)) - strtotime($this->sum_times($underTimes));
                        $totalOverTime2 = $totalOverTime1 / 3600;
                        $lwop = Leavedate::where('user_id', $uwj->user_id)->where('leavetype_id', '1')->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();
                        $totalOverTime = number_format($totalOverTime2, 2) - (count($lwop) * $p->pdwh);
//                        dd($totalOverTime);
                        $s->over_time_hour = $totalOverTime;
                        if (($p->wh * 1) == 1) {
                            $awh = 26 * ($p->pdwh);
                        } else {
                            $awh = 22 * ($p->pdwh);
                        }
                        $sp = ($totalOverTime * 1) / $awh;
                        // overtime calculation end //
                        if (($is_pay_over * 1) == 1) {
                            $s->pay = $up->pay + (($up->pay * 1) * $sp);
                        } else {
                            $s->pay = $up->pay;
                        }
                        // Tax Calculation
                        if (($p->tax_is_gross * 1) == 1) {
                            $salary = $up->pay * 12;
                            $tax = Tax::where('from', '<=', $salary)->where('to', '>=', $salary)->where('branch_id', User::find($uwj->user_id)->branch_id)->first();
                            if ($tax) {
                                $s->tax = $up->pay * $tax->tax / 100;
                            } elseif (($salary * 1) > (Tax::where('branch_id', User::find($uwj->user_id)->branch_id)->max('to') * 1)) {
                                $s->tax = $up->pay * $p->max_tax / 100;
                            } else {
                                $s->tax = $up->pay * $p->default_tax / 100;
                            }
                        } else {
                            $salary = ($up->pay + $up->compensation + $up->benefit + $up->family_support) * 12;
                            $tax = Tax::where('from', '<=', $salary)->where('to', '>=', $salary)->where('branch_id', User::find($uwj->user_id)->branch_id)->first();
                            if ($tax) {
                                $s->tax = ($up->pay + $up->compensation + $up->benefit + $up->family_support) * $tax->tax / 100;
                            } elseif (($salary * 1) > (Tax::where('branch_id', User::find($uwj->user_id)->branch_id)->max('to') * 1)) {
                                $s->tax = ($up->pay + $up->compensation + $up->benefit + $up->family_support) * $p->max_tax / 100;
                            } else {
                                $s->tax = ($up->pay + $up->compensation + $up->benefit + $up->family_support) * $p->default_tax / 100;
                            }
                        }
                        $s->compensation = $up->compensation;
                        $s->benefit = $up->benefit;
                        $s->family_support = $up->family_support;
                        $s->bonus = 0;
                        if (($uwj->is_bonus * 1) == 1) {
                            $uwj->is_bonus = 0;
                            $uwj->update();
                            $bonus = Bonus::find(1);
                            if (($bonus->is_gross * 1) == 1) {
                                $s->bonus = $up->pay * $bonus->percentage / 100;
                            } else {
                                $s->bonus = ($up->pay + $up->compensation + $up->benefit + $up->family_support) * $bonus->percentage / 100;
                            }
                        }
                        $td = 0;
                        $ls = Userloan::where('user_id', $uwj->user_id)->get();
                        foreach ($ls as $l) {
                            if (($l->due * 1) >= ($l->pay_per_month * 1)) {
                                $td = $td + $l->pay_per_month;
                                $l->due = $l->due - $l->pay_per_month;
                                $l->update();
                            } else {
                                $td = $td + $l->due;
                                $l->due = 0;
                                $l->update();
                            }
                        }
                        $s->loan = $td;
                        if (($provident->is_gross * 1) == 1) {
                            $salary = $up->pay;
                        } else {
                            $salary = $up->pay + $up->compensation + $up->benefit + $up->family_support;
                        }
                        $cf = $job->provident;
                        $s->pf_user = ($salary * 1) * ($provident->from_user * 1) / 100 * ($cf * 1) / 100;
                        $s->pf_company = ($salary * 1) * ($provident->from_employer * 1) / 100 * ($cf * 1) / 100;
                        $s->total_provident_fund = $s->pf_user + $s->pf_company;
                        $s->pension_user = 0;
                        $s->pension_company = 0;
                        $s->total_pension = 0;
                        // check for pension
                        if (($p->is_active * 1) == 1) {
                            if (($p->is_both * 1) == 1) {
                                // cut salary
                                if (($p->is_gross_salary * 1) == 1) {
                                    // only gross salary
                                    $s->pension_user = ($up->pay * 1) * ($p->salary_percentage * 1) / 100 * (100 - ($p->company_pay_percentage)) / 100;
                                    $s->pension_company = ($up->pay * 1) * ($p->salary_percentage * 1) / 100 * ($p->company_pay_percentage) / 100;
                                    $s->total_pension = $s->pension_user + $s->pension_company;
                                } else {
                                    // total salary
                                    $s->pension_user = (($up->pay * 1) + ($up->compensation * 1) + ($up->benefit * 1) + ($up->family_support * 1)) * ($p->salary_percentage * 1) / 100 * (100 - ($p->company_pay_percentage)) / 100;
                                    $s->pension_company = (($up->pay * 1) + ($up->compensation * 1) + ($up->benefit * 1) + ($up->family_support * 1)) * ($p->salary_percentage * 1) / 100 * ($p->company_pay_percentage) / 100;
                                    $s->total_pension = $s->pension_user + $s->pension_company;
                                }
                            } else {
                                // do not cut salary
                                if (($p->is_gross_salary * 1) == 1) {
                                    // only gross salary (but only company pay)
                                    $s->pension_company = ($up->pay * 1) * ($p->salary_percentage * 1) / 100;
                                    $s->total_pension = $s->pension_user + $s->pension_company;
                                } else {
                                    // total salary  (but only company pay)
                                    $s->pension_company = (($up->pay * 1) + ($up->compensation * 1) + ($up->benefit * 1) + ($up->family_support * 1)) * ($p->salary_percentage * 1) / 100;
                                    $s->total_pension = $s->pension_user + $s->pension_company;
                                }
                            }
                        }
                    } else {
                        $s->pay = 0;
                        $s->tax = 0;
                        $s->compensation = 0;
                        $s->benefit = 0;
                        $s->family_support = 0;
                        $s->bonus = 0;
                        $s->loan = 0;
                        $s->pf_user = 0;
                        $s->pf_company = 0;
                        $s->total_provident_fund = 0;
                        $s->pension_user = 0;
                        $s->pension_company = 0;
                        $s->total_pension = 0;
                    }
                    // save in salary
                    // calculate + - actual pay
                    $s->salary = $s->pay - $s->tax + $s->compensation + $s->benefit + $s->family_support + $s->bonus - $s->loan - $s->pf_user - $s->pension_user;
                    $s->save();
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('SalaryCreateSuccess', "Salary has been created successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function edit($sid)
    {
        if (Auth::user()->can('salary_generate')) {
            $s = Salary::find($sid);
            $s['user_name'] = User::find($s->user_id)->name;
            $s['branch'] = Branch::find($s->branch_id)->title;
            $pension = Pension::find(1);
            return view('salary.edit', compact('s', 'pension'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $sid)
    {
        if (Auth::user()->can('salary_generate')) {
            $request->validate([
                'basicSalary' => 'required|min:0',
                'tax' => 'required|min:0',
                'compensation' => 'required|min:0',
                'benefit' => 'required|min:0',
                'familySupport' => 'required|min:0',
                'bonus' => 'required|min:0',
                'loan' => 'required|min:0',
                'providentFundUser' => 'required|min:0',
                'providentFundEmployer' => 'required|min:0',
                'pensionUser' => 'required|min:0',
                'pensionEmployer' => 'required|min:0',
                'totalSalary' => 'required|min:0',
                'overtime' => 'required|min:0',
            ]);
            $s = Salary::find($sid);
            $s->pay = $request->basicSalary;
            $s->tax = $request->tax;
            $s->compensation = $request->compensation;
            $s->benefit = $request->benefit;
            $s->family_support = $request->familySupport;
            $s->bonus = $request->bonus;
            $s->loan = $request->loan;
            $s->pf_user = $request->providentFundUser;
            $s->pf_company = $request->providentFundEmployer;
            $s->total_provident_fund = $request->providentFundUser + $request->providentFundEmployer;
            $s->pension_user = $request->pensionUser;
            $s->pension_company = $request->pensionEmployer;
            $s->total_pension = $request->pensionUser + $request->pensionEmployer;
            $s->salary = $request->totalSalary;
            $s->over_time_hour = $request->overtime;
            $s->update();
            Session::flash('SalaryUpdateSuccess', "The Salary has been updated successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function generalSetup()
    {
        if (Auth::user()->can('general')) {
            $p = Pension::find(1);
            return view('salary.setup', compact('p'));
        } else {
            abort(403);
        }
    }


    public function generalUpdate(Request $request)
    {
        if (Auth::user()->can('general')) {
            $this->validate($request, [
                'hour' => 'required|numeric|min:1|max:16',
                'weeklyHoliday' => 'required',
                'salaryType' => 'required',
            ]);
            $p = Pension::find(1);
            $p->pdwh = $request->hour;
            $p->wh = $request->weeklyHoliday;
            $p->st_is_over = $request->salaryType;
            $p->update();
            Session::flash('SalaryUpdateSuccess', "General Information has been updated successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function salaryCsvDownload()
    {
        $salaries = Salary::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->where('branch_id', Auth::user()->branch_id)->get();
//        $salaries = Salary::whereMonth('created_at', '=', Carbon::now()->month)->where('branch_id', Auth::user()->branch_id)->get();
        foreach ($salaries as $s) {
            $u = User::find($s->user_id);
            $s['user_name'] = $u->name;
        }
        $filename = "xl.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('Employee', 'Basic Salary', 'Tax', 'Compensation', 'Benefit', 'Family Support', 'Loan Paid', 'Provident Fund', 'Total Salary', 'Overtime (hours)'));
        foreach ($salaries as $row) {
            fputcsv($handle, array($row['user_name'], $row['pay'], $row['tax'], $row['compensation'], $row['benefit'], $row['family_support'], $row['loan'], $row['total_provident_fund'], $row['salary'], $row['over_time_hour']));
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'xl.csv', $headers);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Salary $salary)
    {
        //
    }


    public function destroy(Salary $salary)
    {
        //
    }
}
