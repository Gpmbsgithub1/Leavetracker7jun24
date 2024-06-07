<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Employee;
use App\Company;
use App\Group;
use App\GroupMember;
use App\LeaveRequest;
use App\Document;
use App\Doc_file;
use App\Leave_file;
use App\Salary;
use App\SalarySlip;
use App\Award;
use App\Holiday;
use Validator;
use DateTime;
use Auth;
use Carbon\Carbon;
use DateInterval;
use Mail;
use App\LeaveDateSplit;

class EmployeeController extends Controller
{
    public function index()
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $date = date('d/m/Y');
        $day = Carbon::createFromFormat('d/m/Y', $date)->format('l');
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $hr = User::where('id', '=', $user->hr_id)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $g = GroupMember::orderBy('created_at', 'DESC')->where('employee_id', '=', $user->id)->whereNull('manager')->orWhere('manager', '<>', 1)->first();
        $gm='';
		$patu='';
		if(isset($g)){
        $gr = GroupMember::where('group_id', '=', $g->group_id)->where('manager', '=', 1)->first();
        $gm = User::where('id', '=', $gr->employee_id)->first();
        // dd($gm);
        // exit();
        }
        $jmonth = date('m', strtotime($user->joining_date));
        $jyear = date('Y', strtotime($user->joining_date));
        if($jyear==date('Y') && $jmonth>01){
            $tcas = (12-$jmonth)+1;

        } else {
            $tcas = 12;
        }
        $lea = LeaveRequest::where('user_id', '=', Auth::user()->id)->where('leave_type', '=', 'casual_leave')->where('approve', '=', 1)->sum('days');
        $r = 12-date('m');
        $casu = $lea;
        $rem = ($tcas - $r)-$casu;

        // dd($gm);
        $medu = 5-$user->medical_leave;
        $beru = 5-$user->bereavement_leave;
        if($user->gender=='M'){
            $patu = 3-$user->paternity_leave;
        } elseif($user->gender=='F') {
            $patu = 60-$user->maternity_leave;
        }

        $fdate = $user->joining_date;
        $tdate = date('Y-m-d');
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');//now do whatever you like with $days
        // dd($days);

        $start_date = new DateTime();
        $end_date = (new $start_date)->add(new DateInterval("P{$days}D") );
        $dd = date_diff($start_date,$end_date);
        $time_at_company = $dd->y." Years ".$dd->m." Months ".$dd->d." Days";

        $loss = LeaveRequest::where('user_id', '=', Auth::user()->id)->where('leave_type', '=', 'loss_of_pay')->where('approve', '=', 1)->sum('days');
        // dd($loss);
        $award = Award::where('employee', '=', Auth::user()->id)->get();

        $senl = $dd->y;
        $senu = $senl-$user->seniority_leave;

    	return view('employee.home', compact('user', 'grp', 'company', 'day', 'hr', 'g', 'gm', 'rem', 'medu', 'beru', 'casu', 'patu', 'time_at_company', 'tcas', 'loss', 'award', 'senl','senu'));
    }

    public function leaves()
    {
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
    	$leave = LeaveRequest::where('user_id', '=', Auth::user()->id)->whereNull('approve')->paginate(20);
    	foreach ($leave as $key => $leaves) {
    		$user = User::where('id', '=', $leaves->user_id)->first();
    	}
    	return view('employee.leave', compact('leave', 'grp', 'company'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function approved_leaves()
    {
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $leave = LeaveRequest::where('user_id', '=', Auth::user()->id)->where('approve', '=', 1)->paginate(20);
        foreach ($leave as $key => $leaves) {
            $user = User::where('id', '=', $leaves->user_id)->first();
        }
        return view('employee.approved_leave', compact('leave', 'grp', 'company'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function reject_leaves()
    {
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $leave = LeaveRequest::where('user_id', '=', Auth::user()->id)->where('approve', '=', 0)->paginate(20);
        foreach ($leave as $key => $leaves) {
            $user = User::where('id', '=', $leaves->user_id)->first();
        }
        return view('employee.reject_leave', compact('leave', 'grp', 'company'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function request_leave()
    {
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $holiday = Holiday::orderBy('dt', 'ASC')->pluck('dt');
        // dd($holiday);
        $lr = LeaveDateSplit::where('employee_id', '=', Auth::user()->employee_id)->pluck('date');
        // dd($lr);
        $user = User::where('id', '=', Auth::user()->id)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
    	return view('employee.request_leave', compact('grp', 'company', 'user', 'holiday','lr'));
    }

    public function leave_store(Request $request)
    {
    	$request->validate([
            'employee_id' => 'required|string|max:10',
            'dates' => 'required',
            'days' => 'required',
            'leave_type' => 'required',
            'leave_reason' => 'required',
        ]);

        if($request->input('leave_type')=='medical_leave'){
            $messages = [
            'medical.required' => 'Please upload medical certificate to continue',
            'medical.mimes' => 'The file must be of type: pdf, docx, doc, jpg, png, jpeg, gif.'
            ];
            $request->validate([
                'medical' => 'required|mimes:pdf,docx,doc,jpg,png,jpeg,gif',
            ],$messages);
        }

        if($request->input('leave_type')=='paternity_leave'){
            $messages = [
            'paternity.required' => 'Please upload medical certificate to continue',
            'paternity.mimes' => 'The file must be of type: pdf, docx, doc, jpg, png, jpeg, gif.'
            ];
            $request->validate([
                'paternity' => 'required|mimes:pdf,docx,doc,jpg,png,jpeg,gif',
            ],$messages);
        }

        if($request->input('leave_type')=='maternity_leave'){
            $messages = [
            'maternity.required' => 'Please upload medical certificate to continue',
            'maternity.mimes' => 'The file must be of type: pdf, docx, doc, jpg, png, jpeg, gif.'
            ];
            $request->validate([
                'maternity' => 'required|mimes:pdf,docx,doc,jpg,png,jpeg,gif',
            ],$messages);
        }

        if($request->input('leave_type')=='bereavement_leave'){
            $messages = [
            'bereavement.required' => 'Please upload document to continue',
            'bereavement.mimes' => 'The file must be of type: pdf, docx, doc, jpg, png, jpeg, gif.'
            ];
            $request->validate([
                'bereavement' => 'required|mimes:pdf,docx,doc,jpg,png,jpeg,gif',
            ],$messages);
        }

        if($request->input('leave_type')=='comp_off'){
            $messages = [
            'comp.required' => 'Please upload document to continue',
            'comp.mimes' => 'The file must be of type: pdf, docx, doc, jpg, png, jpeg, gif.'
            ];
            $request->validate([
                'comp' => 'required|mimes:pdf,docx,doc,jpg,png,jpeg,gif',
            ],$messages);
        }

        if($request->input('days')>2 && $request->input('leave_type')=='casual_leave'){
            $messages = [
            'cas.required' => 'Please upload document to continue',
            'cas.mimes' => 'The file must be of type: pdf, docx, doc, jpg, png, jpeg, gif.'
            ];
            $request->validate([
                'cas' => 'required|mimes:pdf,docx,doc,jpg,png,jpeg,gif',
            ],$messages);
        }

    	$leave = new LeaveRequest;
    	$leave->employee_id = $request->input('employee_id');
    	$leave->user_id = Auth::user()->id;
        $lr = LeaveRequest::where('employee_id', '=', Auth::user()->employee_id)->whereNull('approve')->orWhere('approve', '<>', 0)->pluck('dates');
        // dd($lr);
        // exit;
        // foreach ($lr as $key => $lrs) {
        //     // dd("Yes");
        //     if(($date_from>=$lrs->from_date && $date_from<=$lrs->to_date) || ($date_to>=$lrs->from_date && $date_to<=$lrs->to_date)){
        //         // dd("Yes");
        //         return redirect()->route('employee.request_leave')->with('error', 'Leaves already requested on selected dates');
        //     }
        // }
        // $mfrom = date('m', strtotime($request->input('from_date')));
        // $mto = date('m', strtotime($request->input('to_date')));
    	$leave->dates = $request->input('dates');
        // $leave->fmonth = $mfrom;
        // $leave->tmonth = $mto;
	    // 	$fdate = $request->input('from_date');
		// 	$tdate = $request->input('to_date');
		// 	$datetime1 = new DateTime($fdate);
		// 	$datetime2 = new DateTime($tdate);
		// 	$interval = $datetime1->diff($datetime2);
		$days = $request->input('days');
        if($request->input('leave_type')=='half_day'){
            $leave->days = 0.5;
        } else {
		    $leave->days = $days;
        }
    	$leave->leave_type = $request->input('leave_type');
    	$leave->leave_reason = $request->input('leave_reason');
        $leave->hr_id = Auth::user()->hr_id;
        $mem = GroupMember::where('employee_id', '=', Auth()->user()->id)->where('manager', '=', 1)->count();
        if($mem>0){
            $leave->manager = 1;
        }
        $memb = GroupMember::where('employee_id', '=', Auth()->user()->id)->count();
        if($memb==0){
            $leave->no_group = 1;
        }

    	$leave->save();

        if ($request->hasFile('medical')) {
        $image = $request->file('medical');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/leave_files');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Leave_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'medical';
        $profile_file->user_id = auth()->user()->id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->leave_id = $leave->id;
        $profile_file->save();
        }

        if ($request->hasFile('paternity')) {
        $image = $request->file('paternity');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/leave_files');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Leave_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'paternity';
        $profile_file->user_id = auth()->user()->id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->leave_id = $leave->id;
        $profile_file->save();
        }

        if ($request->hasFile('maternity')) {
        $image = $request->file('maternity');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/leave_files');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Leave_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'maternity';
        $profile_file->user_id = auth()->user()->id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->leave_id = $leave->id;
        $profile_file->save();
        }

        if ($request->hasFile('bereavement')) {
        $image = $request->file('bereavement');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/leave_files');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Leave_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'bereavement';
        $profile_file->user_id = auth()->user()->id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->leave_id = $leave->id;
        $profile_file->save();
        }

        if ($request->hasFile('comp')) {
        $image = $request->file('comp');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/leave_files');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Leave_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'comp';
        $profile_file->user_id = auth()->user()->id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->leave_id = $leave->id;
        $profile_file->save();
        }

        if ($request->hasFile('cas')) {
        $image = $request->file('cas');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/leave_files');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Leave_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'casual';
        $profile_file->user_id = auth()->user()->id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->leave_id = $leave->id;
        $profile_file->save();
        }
        $user = User::where('id', '=', Auth::user()->id)->first();
        // dd($user);
        // exit;
        $g = GroupMember::orderBy('created_at', 'DESC')->where('employee_id', '=', $user->id)->whereNull('manager')->orWhere('manager', '<>', 1)->first();
        if(isset($g)){
            $gr = GroupMember::where('group_id', '=', $g->group_id)->where('manager', '=', 1)->first();
            $gm = User::where('id', '=', $gr->employee_id)->first();
            $send_email = $gm->email;
            $gid = $g->group_id;
        } else {
            $hr = User::where('id', '=', $user->hr_id)->first();
            $gm = '';
            $send_email = $hr->email;
            $gid = '';
        }
        //$send_email = "midhun@skiloratech.com";

        $leavet = $leave->leave_type;
        if($leave->leave_type=='medical_leave'){
            $lname = 'Medical Leave';
        } elseif($leave->leave_type=='paternity_leave'){
            $lname = 'Paternity Leave';
        } elseif($leave->leave_type=='maternity_leave'){
            $lname = 'Maternity Leave';
        } elseif($leave->leave_type=='bereavement_leave'){
            $lname = 'Bereavement Leave';
        } elseif($leave->leave_type=='comp_off'){
            $lname = 'Comp Off Leave';
        } elseif($leave->leave_type=='casual_leave'){
            $lname = 'Casual Leave';
        } elseif($leave->leave_type=='loss_of_pay'){
            $lname = 'Loss of Pay';
        } elseif($leave->leave_type=='half_day'){
            $lname = 'Half Day Leave';
        } elseif($leave->leave_type=='marriage_leave'){
            $lname = 'Marriage Leave';
        }

        // $start = $leave->dates;
        $lreason = $leave->leave_reason;

        $d = $leave->dates;
        $start = explode(',', $d);

        $data=array('gm'=>$gm,'gid'=>$gid,'to'=>$send_email,'lname'=>$lname,'start'=>$start,'lreason'=>$lreason,'user'=>$user,'leave'=>$leave);

        Mail::send('emails.leave_request', $data, function($message) use ($send_email, $user, $lname)
          {
           $message->to($send_email)->subject("Leave Request - ".$user->name." - ".$lname);
          });

    	return redirect()->route('employee.leaves')->with('success', 'Leave Request Submitted Succesfully!');
    }

    public function view_leave_doc($id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $d = $leave->dates;
        $start = explode(',', $d);
        $file = Leave_file::where('leave_id', '=', $leave->id)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        return view('employee.view_leave_document', compact('leave', 'file', 'company', 'start'));
    }

    public function groups()
    {
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $group = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->get();
        foreach ($group as $key => $groups) {
            $gp = Group::where('id', '=', $groups->group_id)->first();
            $user = User::where('id', '=', $groups->employee_id)->first();
            $members = GroupMember::where('group_id', '=', $groups->group_id)->count();
            $groups->gp = $gp;
            $groups->user = $user;
            $groups->members = $members;
        }
        return view('employee.group', compact('grp', 'group', 'company'));
    }

    public function group_members($id)
    {
        $group = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $grp = Group::findOrFail($id);
        $member = GroupMember::where('group_id', '=', $grp->id)->paginate(20);
        $fcompany = array();
        foreach ($member as $key => $members) {
            $cmp = Company::where('id', '=', $members->company_id)->first();
            $user = User::where('id', '=', $members->employee_id)->first();
            $fcompany[]=$members->employee_id;
            $members->cmp = $cmp;
            $members->user = $user;
        }
        $emp = User::where('status', '=', "1")->orWhereNull('status')->whereNotIn('id',$fcompany)->get();
        // dd($emp);
        return view('employee.group_members', compact('grp', 'member', 'emp', 'group', 'company'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function leave_requests($id, $eid)
    {
        $group = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $grp = Group::findOrFail($id);
        $employee = User::findOrFail($eid);
        $leave = LeaveRequest::where('user_id', '=', $employee->id)->paginate(20);
        return view('employee.leave_request', compact('grp', 'employee', 'leave', 'group', 'company'))->with('i', (request()->input('page', 1) - 1) * 20);

    }

    public function leave_accept($id, $gid)
    {
        $leave = LeaveRequest::findOrFail($id);
        $grp = Group::findOrFail($gid);
        $manager = GroupMember::where('group_id', '=', $grp->id)->where('manager', '=', 1)->first();

        $leave->approve = 1;
        $leave->approved_by = $manager->employee_id;
        $leave->save();



        $user = User::where('id', '=', $leave->user_id)->first();
        if($leave->leave_type == 'casual_leave'){
            $fl = $user->casual_leave;
            $util = $user->casual_util;
            $rem = $user->casual_rem;
        } elseif ($leave->leave_type == 'medical_leave') {
            $fl = $user->medical_leave;
            $util = $user->medical_util;
            $rem = $user->medical_rem;
        } elseif ($leave->leave_type == 'paternity_leave') {
            $fl = $user->paternity_leave;
            $util = $user->paternity_util;
            $rem = $user->paternity_rem;
        } elseif ($leave->leave_type == 'maternity_leave') {
            $fl = $user->maternity_leave;
            $util = $user->maternity_util;
            $rem = $user->maternity_rem;
        } elseif ($leave->leave_type == 'bereavement_leave') {
            $fl = $user->bereavement_leave;
            $util = $user->bereavement_util;
            $rem = $user->bereavement_rem;
        }  elseif ($leave->leave_type == 'seniority_leave') {
            $fl = $user->seniority_leave;
            $util = $user->seniority_util;
            $rem = $user->seniority_rem;
        }  elseif ($leave->leave_type == 'marriage_leave') {
            $fl = $user->marriage_leave;
            $util = $user->marriage_util;
            $rem = $user->marriage_rem;
        } elseif ($leave->leave_type == 'loss_of_pay') {
            $fl = $user->loss_of_pay;
            $util = $user->loss_util;
        } elseif ($leave->leave_type == 'comp_off') {
            $fl = $user->comp_off;
            $util = $user->comp_util;
        }
        if($leave->leave_type == 'loss_of_pay' || $leave->leave_type == 'comp_off') {
            $nfl = $fl + $leave->days;
            $nutil = $util + $leave->days;
        } elseif ($leave->leave_type == 'half_day' && $user->casual_rem>0) {
            $casual = $user->casual_rem;
            $ut = $user->casual_util;
            $nfl = $casual-0.5;
            $nutil = $ut + 0.5;
        } elseif ($leave->leave_type == 'half_day' && $user->casual_rem==0) {
            $casual = $user->loss_of_pay;
            $ut = $user->loss_util;
            $nfl = $casual+0.5;
            $nutil = $ut+0.5;
        } else {
            $nfl = $rem - $leave->days;
            $nutil = $util + $leave->days;
        }

        if($leave->leave_type == 'casual_leave'){
            $user->casual_rem = $nfl;
            $user->casual_util = $nutil;
        } elseif ($leave->leave_type == 'medical_leave') {
            $user->medical_rem = $nfl;
            $user->medical_util = $nutil;
        } elseif ($leave->leave_type == 'paternity_leave') {
            $user->paternity_rem = $nfl;
            $user->paternity_util = $nutil;
        } elseif ($leave->leave_type == 'maternity_leave') {
            $user->maternity_rem = $nfl;
            $user->maternity_util = $nutil;
        } elseif ($leave->leave_type == 'bereavement_leave') {
            $user->bereavement_rem = $nfl;
            $user->bereavement_util = $nutil;
        } elseif ($leave->leave_type == 'seniority_leave') {
            $user->seniority_rem = $nfl;
            $user->seniority_util = $nutil;
        } elseif ($leave->leave_type == 'marriage_leave') {
            $user->marriage_rem = $nfl;
            $user->marriage_util = $nutil;
        } elseif ($leave->leave_type == 'loss_of_pay') {
            $user->loss_of_pay = $nfl;
            $user->loss_util = $nutil;
        } elseif ($leave->leave_type == 'comp_off') {
            $user->comp_off = $nfl;
            $user->comp_util = $nutil;
        } elseif ($leave->leave_type == 'half_day' && $user->casual_rem>0) {
            $user->casual_rem = $nfl;
            $user->casual_util = $nutil;
        } elseif ($leave->leave_type == 'half_day' && $user->casual_rem==0) {
            $user->loss_of_pay = $nfl;
            $user->loss_util = $nutil;
        }
        $user->save();

        $leave_date = $leave->dates;
        if($leave->days>1){
            $ld = explode(",",$leave_date);
            foreach ($ld as $k => $lds) {
                $date_split = new LeaveDateSplit;
                $date_split->employee_id = $leave->employee_id;
                $date_split->employee = $leave->user_id;
                $date_split->leave_type = $leave->leave_type;
                if ($leave->leave_type == 'half_day' && $user->casual_rem>0) {
                    $date_split->type = "gain";
                } elseif ($leave->leave_type == 'half_day' && $user->casual_rem==0) {
                    $date_split->type = "loss";
                }
                $date_split->date = $lds;
                $date_split->save();
            }
        } else {
            $date_split = new LeaveDateSplit;
            $date_split->employee_id = $leave->employee_id;
            $date_split->employee = $leave->user_id;
            $date_split->leave_type = $leave->leave_type;
            if ($leave->leave_type == 'half_day' && $user->casual_rem>0) {
                $date_split->type = "gain";
            } elseif ($leave->leave_type == 'half_day' && $user->casual_rem==0) {
                $date_split->type = "loss";
            }
            $date_split->date = $leave->dates;
            $date_split->save();
        }

        $emp = Employee::where('employee_id', '=', $leave->employee_id)->first();
        if($leave->leave_type == 'casual_leave'){
        $fl = $emp->casual_leave;
        } elseif ($leave->leave_type == 'medical_leave') {
            $fl = $emp->medical_leave;
        } elseif ($leave->leave_type == 'paternity_leave') {
            $fl = $emp->paternity_leave;
        } elseif ($leave->leave_type == 'maternity_leave') {
            $fl = $emp->maternity_leave;
        } elseif ($leave->leave_type == 'bereavement_leave') {
            $fl = $emp->bereavement_leave;
        } elseif ($leave->leave_type == 'loss_of_pay') {
            $fl = $emp->loss_of_pay;
        } elseif ($leave->leave_type == 'comp_off') {
            $fl = $emp->comp_off;
        }
        if($leave->leave_type == 'loss_of_pay' || $leave->leave_type == 'comp_off'){
            $nfl = $fl + $leave->days;
        } elseif ($leave->leave_type == 'half_day' && $emp->casual_leave>0) {
            $casual = $emp->casual_leave;
            $nfl = $casual-0.5;
        } elseif ($leave->leave_type == 'half_day' && $emp->casual_leave==0) {
            $casual = $emp->loss_of_pay;
            $nfl = $casual+0.5;
        } else {
            $nfl = $fl - $leave->days;
        }

        if($leave->leave_type == 'casual_leave'){
            $emp->casual_leave = $nfl;
        } elseif ($leave->leave_type == 'medical_leave') {
            $emp->medical_leave = $nfl;
        } elseif ($leave->leave_type == 'paternity_leave') {
            $emp->paternity_leave = $nfl;
        } elseif ($leave->leave_type == 'maternity_leave') {
            $emp->maternity_leave = $nfl;
        } elseif ($leave->leave_type == 'bereavement_leave') {
            $emp->bereavement_leave = $nfl;
        } elseif ($leave->leave_type == 'loss_of_pay') {
            $emp->loss_of_pay = $nfl;
        } elseif ($leave->leave_type == 'comp_off') {
            $emp->comp_off = $nfl;
        }
        $emp->save();

        $leavet = $leave->leave_type;
        if($leave->leave_type=='medical_leave'){
            $lname = 'Medical Leave';
        } elseif($leave->leave_type=='paternity_leave'){
            $lname = 'Paternity Leave';
        } elseif($leave->leave_type=='maternity_leave'){
            $lname = 'Maternity Leave';
        } elseif($leave->leave_type=='bereavement_leave'){
            $lname = 'Bereavement Leave';
        } elseif($leave->leave_type=='comp_off'){
            $lname = 'Comp Off Leave';
        } elseif($leave->leave_type=='casual_leave'){
            $lname = 'Casual Leave';
        } elseif($leave->leave_type=='loss_of_pay'){
            $lname = 'Loss of Pay';
        } elseif($leave->leave_type=='half_day'){
            $lname = 'Half Day Leave';
        }

        $send_email = $user->email;
        // $send_email = "midhun@skiloratech.com";

        $d = $leave->dates;
        $start = explode(',', $d);
        $lreason = $leave->leave_reason;

        $data=array('to'=>$send_email, 'lname'=>$lname, 'start'=>$start, 'lreason'=>$lreason, 'user'=>$user, 'leave'=>$leave);

        Mail::send('emails.approve_leave', $data, function($message) use ($send_email, $user, $lname)
          {
           $message->to($send_email)->subject("Leave Approved - ".$user->name." - ".$lname);
          });

        return redirect()->route('employee.leave_requests', ['id'=>$grp->id, 'eid'=>$leave->user_id])->with('success', 'Leave Approved Succesfully!');
    }

    public function leave_reject(Request $request, $id, $gid)
    {
        $request->validate([
            'reject_reason' => 'required',
        ]);
        $leave = LeaveRequest::findOrFail($id);
        $grp = Group::findOrFail($gid);
        $manager = GroupMember::where('group_id', '=', $grp->id)->where('manager', '=', 1)->first();

        $leave->approve = 0;
        $leave->reject_reason = $request->input('reject_reason');
        $leave->rejected_by = Auth::user()->id;
        $leave->save();
        $user = User::where('id', '=', $leave->user_id)->first();

        $leavet = $leave->leave_type;
        if($leave->leave_type=='medical_leave'){
            $lname = 'Medical Leave';
        } elseif($leave->leave_type=='paternity_leave'){
            $lname = 'Paternity Leave';
        } elseif($leave->leave_type=='maternity_leave'){
            $lname = 'Maternity Leave';
        } elseif($leave->leave_type=='bereavement_leave'){
            $lname = 'Bereavement Leave';
        } elseif($leave->leave_type=='comp_off'){
            $lname = 'Comp Off Leave';
        } elseif($leave->leave_type=='casual_leave'){
            $lname = 'Casual Leave';
        } elseif($leave->leave_type=='loss_of_pay'){
            $lname = 'Loss of Pay';
        } elseif($leave->leave_type=='half_day'){
            $lname = 'Half Day Leave';
        }

        $send_email = $user->email;
        // $send_email = "midhun@skiloratech.com";

        $d = $leave->dates;
        $start = explode(',', $d);
        $lreason = $leave->reject_reason;

        $data=array('to'=>$send_email,'lname'=>$lname,'start'=>$start,'lreason'=>$lreason,'user'=>$user,'leave'=>$leave);

        Mail::send('emails.reject_leave', $data, function($message) use ($send_email, $user, $lname)
          {
           $message->to($send_email)->subject("Leave Rejected - ".$user->name." - ".$lname);
          });
        return redirect()->route('employee.leave_requests', ['id'=>$grp->id, 'eid'=>$leave->user_id])->with('success', 'Leave Rejected Succesfully!');
    }

    public function group_leaves()
    {
        $group = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->get();
        $fmember = '';
        foreach ($group as $key => $groups) {
            $member = GroupMember::orderBy('employee_id')->where('group_id', '=', $groups->group_id)->whereNotNull('leave_id')->get();
            $fmember = $member;
        }
    }

    public function remove_from_group($id, $gid)
    {
        $grp = Group::findOrFail($id);
        $mem = GroupMember::findOrFail($gid);
        $mem->delete();

        return redirect()->route('employee.group_members', $id)->with('success', 'Employee removed from Group Succesfully!');
    }

    public function documents()
    {
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $doc = Document::where('employee', '=', Auth::user()->id)->orWhere('employee', '=', 'all')->paginate(20);
        foreach ($doc as $key => $docs) {
            $user = User::where('id', '=', $docs->employee)->first();
            $docs->user = $user;
        }
        return view('employee.docs', compact('doc', 'grp', 'company'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function view_document($id)
    {
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $doc = Document::findOrFail($id);
        $file = Doc_file::where('doc_id', '=', $id)->get();
        return view('employee.view_document', compact('doc', 'file', 'grp', 'company'));
    }

    public function delete_document($id)
    {
        $doc = Document::findOrFail($id);
        $doc->delete();
        return redirect()->route('employee.documents')->with('success', 'Document Deleted Succesfully!');
    }

    public function salary_slip()
    {
        $salary = SalarySlip::where('employee_id', '=', Auth::user()->employee_id)->paginate(15);
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        return view('employee.salary_slip', compact('salary', 'company'))->with('i', (request()->input('page', 1) - 1) * 15);
    }

    public function view_salary_slip($id)
    {
        $salary = SalarySlip::findOrFail($id);
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        return view('employee.view_salary', compact('salary', 'company'));
    }

    public function profile()
    {
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $user = User::where('id', '=', Auth::user()->id)->first();
        $member = GroupMember::where('employee_id', '=', $user->id)->get();
        $count = GroupMember::where('employee_id', '=', $user->id)->where('manager', '=', 1)->count();
        $gr=array();
        $gm=array();
        foreach ($member as $key => $members) {
            $grp = Group::where('id', '=', $members->group_id)->first();
            $mem = GroupMember::where('group_id', '=', $members->group_id)->where('manager', '=', 1)->first();
            $man = User::where('id', '=', $mem->employee_id)->first();
            $members->grp = $grp;
            $members->mem = $mem;
            $members->man = $man;
        }
        $grp = GroupMember::where('employee_id', '=', Auth::user()->id)->where('manager', '=', 1)->first();
        $hr = User::where('id', '=', $user->hr_id)->first();
        $g = GroupMember::orderBy('created_at', 'DESC')->where('employee_id', '=', $user->id)->whereNull('manager')->orWhere('manager', '<>', 1)->first();
        // $gp = Group::where()
        if(isset($g)){
        $gr = GroupMember::where('group_id', '=', $g->group_id)->where('manager', '=', 1)->first();
        $gm = User::where('id', '=', $gr->employee_id)->first();
        }
        $hr = User::where('id', '=', Auth::user()->hr_id)->first();
        return view('employee.profile', compact('user', 'company', 'member', 'hr', 'count', 'grp', 'company', 'grp', 'hr','g','gm'));
    }

    public function holidays()
    {
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $holiday = Holiday::orderBy('dt', 'ASC')->where('year', '=', date('Y'))->paginate(20);
        return view('employee.holidays', compact('company', 'holiday'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function change_password()
    {
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('employee.change_password', compact('user','company'));
    }

    public function change(Request $request)
    {
        $messages = [
            'old_password.same' => 'Current password is not correct.',
            'new_password.regex' => 'Password must contain atleast one special character,number and character.',
            'confirm_password.required' => 'Please enter new password again.',
            'confirm_password.same' => 'Password should be same as new password.',
           ];
        $request->validate([
            'old_password' => 'required|string|same:pass|min:8',
            'new_password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
            'confirm_password' =>'required|string|same:new_password|min:8',
        ],$messages);
        
        $user = User::where('id', '=', Auth::user()->id)->first();
        $user_name = $user->name;

        // if($request->input('old_password') == Auth::user()->pass){
        //     if ($request->input('new_password') == $request->input('confirm_pass')) {
                $user->password = Hash::make($request->input('confirm_password'));
                $user->pass = $request->input('confirm_password');
                $user->save();
            // }
        // }

        Auth::login($user);
        return redirect()->route('employee.home')->with('success', 'Welcome back '.$user_name.', Password changed successfully!');
    }

    public function profile_photo()
    {
        
    }
}

