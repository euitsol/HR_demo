<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Branch;
use App\EmployeeType;
use App\Job;
use App\Notice;
use App\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{

    public function show()
    {
        $this->redirectBackBack();
        $jobs = [];
        $applicantName = null;
        if (Auth::guard('applicant')->id() != null){
            $a = Applicant::find(Auth::guard('applicant')->id());
            $applicantName = $a->name;
            $jobs = $a->notices()->get();
        }
        $notices = Notice::where('publish', 1)->get();
        foreach ($notices as $n) {
            $n['jobTitle'] = Job::find($n->job_id)->title;
            $n['branchTitle'] = Branch::find($n->branch_id)->title;
            $n['type'] = EmployeeType::find($n->employeeType_id)->type;
            $n['is_applied'] = 0;
            foreach ($jobs as $j){
                if ($j->id == $n->id){
                    $n['is_applied'] = 1;
                    break;
                }
            }
        }
        Storage::disk('local')->put('office', Office::find(1));
        return view('notice.showNoAuth', compact('notices', 'applicantName'));
    }


    public function view($nid)
    {
        $this->redirectBackBack();
        $jobs = [];
        $applicantName = null;
        if (Auth::guard('applicant')->id() != null){
            $a = Applicant::find(Auth::guard('applicant')->id());
            $applicantName = $a->name;
            $jobs = $a->notices()->get();
        }
        $n = Notice::find($nid);
        $n['branchTitle'] = Branch::find($n->branch_id)->title;
        $n['type'] = EmployeeType::find($n->employeeType_id)->type;
        $n['is_applied'] = 0;
        foreach ($jobs as $j){
            if ($j->id == $n->id){
                $n['is_applied'] = 1;
                break;
            }
        }
        $t = Job::find($n->job_id)->title;
        return view('notice.viewNoAuth', compact('n', 't', 'applicantName'));
    }

    public function apply($nid)
    {
        if (Auth::guard('applicant')->id() != null){
            // already logged in
            $n = Notice::find($nid);
            return redirect()->route('applicant.dummy.1', ['aid' => Auth::guard('applicant')->id(), 'nid' => $n->id]);
        } else {
            $n = Notice::find($nid);
            $j = Job::find($n->job_id);
            $j['et'] = EmployeeType::find($n->employeeType_id)->type;
            return view('notice.loginApplicant', compact('n', 'j'));
        }


    }

    public function register()
    {
        return view('notice.registerApplicant');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users,email|unique:applicants,email',
            'password' => 'required|confirmed',
            'name' => 'required',
            'dateOfBirth' => 'required',
        ]);
        $a = new Applicant;
        $a->email = $request->email;
        $a->password = bcrypt($request->password);
        $a->name = $request->name;
        $a->dob = $request->dateOfBirth;
        $a->save();
        Auth::guard('applicant')->loginUsingId($a->id);
        return redirect()->route('show-notices');
    }


    public function dummyOne($aid, $nid)
    {
        $a = Applicant::find($aid);
        $n = Notice::find($nid);
        $j = Job::find($n->job_id);
        $j['et'] = EmployeeType::find($n->employeeType_id)->type;
        $applicantName = $a->name;
        return view('notice.applyFormNoAuth', compact('a', 'n', 'j', 'applicantName'));
    }


    public function applySubmit(Request $request, $aid, $nid)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'fathersName' => 'required',
            'mothersName' => 'required',
            'dateOfBirth' => 'required',
            'mobile' => 'required',
            'nationality' => 'required',
            'aboutMe' => 'required',
            'address' => 'required',
            'education' => 'required',
            'employment' => 'required',
            'skills' => 'required',
            'languagess' => 'required',
            'reference' => 'required',
            'image' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $a = Applicant::find($aid);
            if ($a->email != $request->email) {
                $this->validate($request, [
                    'email' => 'unique:users,email|unique:applicants,email',
                ]);
                $a->email = $request->email;
            }
            $a->name = $request->name;
            $a->FathersName = $request->fathersName;
            $a->MothersName = $request->mothersName;
            $a->dob = $request->dateOfBirth;
            $a->mobile = $request->mobile;
            $a->nationality = $request->nationality;
            $a->about_me = $request->aboutMe;
            $a->address = $request->address;
            $a->education = $request->education;
            $a->employment = $request->employment;
            $a->skills = $request->skills;
            $a->languages = $request->languagess;
            $a->reference = $request->reference;
            $img = $request->image;
            $img_name = time() . $img->getClientOriginalName();
            $aa = $img->move('uploads/Applicants/Photo', $img_name);
            $d = 'uploads/Applicants/Photo/' . $img_name;
            $a->image = $d;
            if ($request->hasFile('cv')) {
                $img = $request->cv;
                $img_name = time() . $img->getClientOriginalName();
                $aa = $img->move('uploads/Applicants/cv', $img_name);
                $d = 'uploads/Applicants/cv/' . $img_name;
                $a->cv = $d;
            }
            $a->update();
            $a->notices()->attach($nid);
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }
        if ($success) {
            Session::flash('ApplySuccess', "You have successfully applied for the job.");
            return redirect()->route('notice.view.noAuth', ['nid' => $nid]);
        } else {
            Session::flash('unsuccess', "Something went wrong :(");
            return redirect()->back();
        }
    }

    public function back()
    {
        return redirect()->back();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function edit(Applicant $applicant)
    {
        //
    }


    public function update(Request $request, Applicant $applicant)
    {
        //
    }


    public function destroy(Applicant $applicant)
    {
        //
    }

}
