<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Branch;
use App\EmployeeType;
use App\Job;
use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('circular')) {
            $jobs = Job::all();
            $notices = Notice::all();
            $branches = Branch::all();
            $es = EmployeeType::all();
            if (count($notices) > 0) {
                foreach ($notices as $n) {
                    $n['jobTitle'] = Job::find($n->job_id)->title;
                    $n['branchTitle'] = Branch::find($n->branch_id)->title;
                    $n['type'] = EmployeeType::find($n->employeeType_id)->type;
                }
            }
            return view('notice.index', compact('notices', 'jobs', 'branches', 'es'));
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
        if (Auth::user()->can('circular')) {
            $this->validate($request, [
                'job' => 'required',
                'publish' => 'required',
                'details' => 'required',
//                'branch' => 'required',
                'employeeType' => 'required',
            ]);
            $n = new Notice;
            $n->job_id = $request->job;
            $n->branch_id = Auth::user()->branch_id;
            $n->employeeType_id = $request->employeeType;
            $n->publish = $request->publish;
            $n->notice = $request->details;
            $n->save();
            Session::flash('NoticeCreateSuccess', "The Notice has been created successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function unpublish($nid)
    {
        if (Auth::user()->can('circular')) {
            $n = Notice::find($nid);
            $n->publish = 0;
            $n->update();
            $j = Job::find($n->job_id);
            $t = $j->title;
            Session::flash('NoticeUnpublishSuccess', "The Notice of '$t' has been Unpublished successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function publish($nid)
    {
        if (Auth::user()->can('circular')) {
            $n = Notice::find($nid);
            $n->publish = 1;
            $n->update();
            $j = Job::find($n->job_id);
            $t = $j->title;
            Session::flash('NoticePublishSuccess', "The Notice of '$t' has been Published successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function view($nid)
    {
        if (Auth::user()->can('circular')) {
            $n = Notice::find($nid);
            $n['title'] = Job::find($n->job_id)->title;
            $n['branchTitle'] = Branch::find($n->branch_id)->title;
            $n['type'] = EmployeeType::find($n->employeeType_id)->type;
            return view('notice/view', compact('n'));
        } else {
            abort(403);
        }
    }





    public function edit($nid)
    {
        if (Auth::user()->can('circular')) {
            $nedit = Notice::find($nid);
            $nedit['branchTitle'] = Branch::find($nedit->branch_id)->title;
            $nedit['ett'] = EmployeeType::find($nedit->employeeType_id)->type;
            $j = Job::find($nedit->job_id);
            $t = $j->title;
            $notices = Notice::all();
            $jobs = Job::all();
            $branches = Branch::all();
            if (count($notices) > 0) {
                foreach ($notices as $n) {
                    $n['jobTitle'] = Job::find($n->job_id)->title;
                    $n['branchTitle'] = Branch::find($n->branch_id)->title;
                }
            }
            $es = EmployeeType::all();
            return view('notice/edit', compact('notices', 'nedit', 'jobs', 't', 'branches', 'es'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $nid)
    {
        if (Auth::user()->can('circular')) {
            $this->validate($request, [
                'job' => 'required',
                'publish' => 'required',
                'details' => 'required',
//                'branch' => 'required',
                'employeeType' => 'required',
            ]);
            $n = Notice::find($nid);
            $n->job_id = $request->job;
//            $n->branch_id = $request->branch;
            $n->employeeType_id = $request->employeeType;
            $n->publish = $request->publish;
            $n->notice = $request->details;
            $n->update();
            Session::flash('NoticeUpdateSuccess', "The Notice has been updated successfully.");
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function noticeApplicantView($nid)
    {
        if (Auth::user()->can('circular')) {
            $n = Notice::find($nid);
            $applicants = $n->applicants()->get();
            if (count($applicants) > 0) {
                $j = Job::find($n->job_id);
                $jobtitle = $j->title;
                return view('notice.applicantsList', compact('applicants', 'jobtitle', 'nid'));
            } else {
                Session::flash('NoApplicant', "No Applicant for the job yet.");
                return redirect()->route('circular');
            }
        } else {
            abort(403);
        }

    }


    public function selectApplicant($aid)
    {
        if (Auth::user()->can('circular')) {
            $a = Applicant::find($aid);
            $a->is_shortlisted = 1;
            $a->update();
            return redirect()->back();
        } else {
            abort(403);
        }
    }


    public function unSelectApplicant($aid)
    {
        if (Auth::user()->can('circular')) {
            $a = Applicant::find($aid);
            $a->is_shortlisted = 0;
            $a->update();
            return redirect()->back();
        } else {
            abort(403);
        }
    }

    public function totalAppliedUser($nid)
    {
        $notice = Notice::find($nid);
        $applicants = $notice->applicants()->get();
        return count($applicants );
    }

    public function noticeDelete($nid)
    {
        if (Auth::user()->can('circular')) {
            DB::beginTransaction();
            try {
                $n = Notice::find($nid);
                $n->applicants()->detach();
                $n->delete();
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('success', "Notice has been forcefully deleted.");
                return redirect()->route('circular');
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->route('circular');
            }
        } else {
            abort(403);
        }
    }

    public function applicantView($aid)
    {
        if (Auth::user()->can('circular')) {
            $a = Applicant::find($aid);
            return view('notice.applicantView', compact('a'));
        } else {
            abort(403);
        }
    }


    public function downloadApplicantCV($aid)
    {
        if (Auth::user()->can('circular')) {
            $a = Applicant::find($aid);
            $ext = pathinfo($a->cv, PATHINFO_EXTENSION);
            $s = addslashes($a->name);
            $name = "$s's_resume." . $ext;
            return response()->download($a->cv, $name);
        } else {
            abort(403);
        }
    }

}