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
use App\Document;
use App\Doc_file;
use App\LeaveRequest;
use App\Salary;
use App\SalarySlip;
use App\Award;
use App\Award_file;
use App\Leave_file;
use App\Identity_file;
use App\Pan_file;
use App\Expense;
use App\Holiday;
use App\YearlyExpense;
use App\LeaveDateSplit;
use Validator;
use Auth;
use File;
use DB;
use Storage;
use PDF;
use DateTime;
use DateInterval;
use Mail;
use Carbon\Carbon;

class HrController extends Controller
{
    public function index()
    {
        $employee = User::where('status', '=', "1")->orWhereNull('status')->count();
        $group = Group::count();
        $leave = LeaveRequest::orderBy('from_date', 'ASC')->where('from_date', '<=', date('Y-m-d'))->orWhere('to_date', '>=', date('Y-m-d'))->where('approve', '=', 1)->get();
        foreach ($leave as $key => $leaves) {
            $user = User::where('id', '=', $leaves->user_id)->first();
            $leaves->user = $user;
        }
        $request = LeaveRequest::orderBy('from_date', 'ASC')->whereNull('approve')->get();
        // dd($request);
        foreach ($request as $key => $requests) {
            $user = User::where('id', '=', $requests->user_id)->first();
            $requests->user = $user;
        }
        $emp = User::orderBy('joining_date', 'DESC')->where('status', '=', "1")->orWhereNull('status')->get();
       
    	return view('hr.home', compact('employee', 'group', 'leave', 'request', 'emp'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function employees()
    {
    	$emp = User::orderBy('employee_id', 'ASC')->where('status', '=', "1")->orWhereNull('status')->paginate(20);
        // dd($emp);
        // $member = array();
        foreach($emp as $k => $emps){
            // $man = Group::where('company_id', '=', $emps->cmp)->get();
            $member = GroupMember::where('employee_id', '=', $emps->id)->pluck('group_id');
            if(count($member)>0){
            $man = Group::whereNotIn('id', $member)->where('company_id', '=', $emps->cmp)->get();
        } else {
            $man = Group::where('company_id', '=', $emps->cmp)->get();
        }
            $emps->man = $man;   
        }

        // dd($member);
    	return view('hr.employee', compact('emp'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function create_employee()
    {
        $emp = User::orderBy('employee_id', 'DESC')->first();
        $us = User::get();
        $eid = $emp->employee_id;
    	return view('hr.create_employee', compact('eid'));
    }

    public function store_employee(Request $request)
    {
        $messages = [
            'email.cmail' => 'Please enter company Email.',
            'employee_id.max' => 'The employee id may not be greater than 10 characters.',
            'phone.without_spaces' => 'Please enter your 10 digit phone number without spaces.',
            'password.regex' => 'Password must contain atleast one special character,number and character.',
            'idp.mimes' => 'The Identity Proof must be a file of type: pdf, jpg, png, jpeg, gif.',
            'pan.mimes' => 'The PAN Card must be a file of type: pdf, jpg, png, jpeg, gif.',
           ];
    	$request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/u',
            'employee_id' => 'required|string|max:10|unique:users',
            'joining_date' => 'required',
            'designation' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/u',
            'employment_type' => 'required',
            'gender' => 'required',
            'email' => 'required|string|email|cmail|max:100|unique:users,email|different:alternate_email',
            'alternate_email' => 'required|string|email|max:100|unique:users,alternate_email|different:email',
            'phone' => 'required|without_spaces|min:10|regex:/^(?!0+$)\d{10,}$/|max:10|different:alternate_phone',
            'alternate_phone' => 'required|without_spaces|min:10|regex:/^(?!0+$)\d{10,}$/|different:phone',
            'address' => 'required',
            'birth_day' => 'required',
            'bank_account' => 'required',
            'base_salary' => 'required|numeric',
            'basic_salary' => 'required|numeric',
            'hra' => 'required|numeric',
            'other_allow' => 'required|numeric',
            'salary_advance' => 'numeric',
            'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
            'status' => 'required',
            'idp' => 'required|mimes:pdf,jpg,png,jpeg,gif',
            'pan' => 'required|mimes:pdf,jpg,png,jpeg,gif'
        ],$messages);

        $cmp = Company::where('status', '=', 'active')->first();

    	$user = new User;
    	$user->name = $request->input('name');
    	$user->cmp = $cmp->id;
    	$user->hr_id = Auth::user()->id;
        $user->employee_id = $request->input('employee_id');
        $date = date('Y-m-d', strtotime($request->input('joining_date')));
        $user->joining_date = $date;
        $user->designation = $request->input('designation');
        $user->employment_type = $request->input('employment_type');
        $user->gender = $request->input('gender');
        if ($request->input('gender')=='M') {
            $user->paternity_leave = 3;
        } elseif ($request->input('gender')=='F') {
            $user->maternity_leave = 60;
        }
        $jmonth = date('m', strtotime($request->input('joining_date')));
        $jyear = date('Y', strtotime($request->input('joining_date')));
        if($jyear==date('Y') && $jmonth>=01){
            $user->casual_leave = (12-$jmonth)+1;
        } else {
            $user->casual_leave = 12;
        }
        $fdate = $date;
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
        $user->seniority_leave = $dd->y;
        $user->medical_leave = 5;
        $user->bereavement_leave = 5;
        $user->loss_of_pay = 0;
        $user->comp_off = 0;
        $user->email = $request->input('email');
        $user->alternate_email = $request->input('alternate_email');
        $user->phone = $request->input('phone');
        $user->alternate_phone = $request->input('alternate_phone');
        $user->address = $request->input('address');
        $user->birth_day = date('Y-m-d', strtotime($request->input('birth_day')));
        if($request->input('wedding_day')!=''){
        $user->wedding_day = date('Y-m-d', strtotime($request->input('wedding_day')));
        } else {
            $user->wedding_day = '';
        }
        $user->bank_account = $request->input('bank_account');
        $user->base_salary = $request->input('base_salary');
        $user->basic_salary = $request->input('basic_salary');
        $user->hra = $request->input('hra');
        $user->other_allow = $request->input('other_allow');
        $user->salary_advance = $request->input('salary_advance');
        $user->password = Hash::make($request->input('password'));
        $user->pass = $request->input('password');
        $user->status = $request->input('status');
        $user->hr = 0;
        $user->groups = 0;
        $user->manager = 0;
        $user->save();

        $emp = new Employee;
        $emp->name = $request->input('name');
    	$emp->company_id = $cmp->id;
    	$emp->hr_id = Auth::user()->id;
    	$emp->user_id = $user->id;
        $emp->employee_id = $request->input('employee_id');
        $date = date('Y-m-d', strtotime($request->input('joining_date')));
        $emp->joining_date = $date;
        $emp->designation = $request->input('designation');
        $emp->employment_type = $request->input('employment_type');
        $emp->gender = $request->input('gender');
        if ($request->input('gender')=='M') {
            $emp->paternity_leave = 3;
        } elseif ($request->input('gender')=='F') {
            $emp->maternity_leave = 60;
        }
        $jmonth = date('m', strtotime($request->input('joining_date')));
        $jyear = date('Y', strtotime($request->input('joining_date')));
        if($jyear==date('Y') && $jmonth>=01){
            $emp->casual_leave = (12-$jmonth)+1;
        } else {
            $emp->casual_leave = 12;
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
        $emp->seniority_leave = $dd->y;
        $emp->medical_leave = 5;
        $emp->bereavement_leave = 5;
        $emp->loss_of_pay = 0;
        $emp->comp_off = 0;
        $emp->email = $request->input('email');
        $emp->alternate_email = $request->input('alternate_email');
        $emp->phone = $request->input('phone');
        $emp->alternate_phone = $request->input('alternate_phone');
        $emp->address = $request->input('address');
        $emp->birth_day = date('Y-m-d', strtotime($request->input('birth_day')));
        if($request->input('wedding_day')!=''){
            $emp->wedding_day = date('Y-m-d', strtotime($request->input('wedding_day')));
        } else {
            $emp->wedding_day = '';
        }
        $emp->bank_account = $request->input('bank_account');
        $emp->base_salary = $request->input('base_salary');
        $emp->basic_salary = $request->input('basic_salary');
        $emp->hra = $request->input('hra');
        $emp->other_allow = $request->input('other_allow');
        $emp->salary_advance = $request->input('salary_advance');
        $emp->status = $request->input('status');
        $emp->groups = 0;
        $emp->save();

        if ($request->hasFile('idp')) {
        $image = $request->file('idp');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/identity_proof');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Identity_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'identity';
        $profile_file->employee = $user->id;
        $profile_file->employee_id = $user->employee_id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->save();
        }

        if ($request->hasFile('pan')) {
        $image = $request->file('pan');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/pan_file');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Pan_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'pan';
        $profile_file->employee = $user->id;
        $profile_file->employee_id = $user->employee_id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->save();
        }

        return redirect()->route('hr.employees')->with('success', 'Employee Created Succesfully!');

    }

    public function edit_employee(Response $response, $id)
    {
    	$emp = User::findOrFail($id);
        $idp = Identity_file::where('employee', '=', $emp->id)->first();
        $pan = Pan_file::where('employee', '=', $emp->id)->first();
    	return view('hr.edit_employee', compact('emp', 'idp', 'pan'));
    }

    public function store_edit_employee(Request $request, $id)
    {
    	$messages = [
            'email.cmail' => 'Please enter company Email.',
            'employee_id.max' => 'The employee id may not be greater than 10 characters.',
            'phone.without_spaces' => 'Please enter your 10 digit phone number without spaces.',
            'password.regex' => 'Password must contain atleast one special character,number and character.',
            'idp.mimes' => 'The Identity Proof must be a file of type: pdf, jpg, png, jpeg, gif.',
            'pan.mimes' => 'The PAN Card must be a file of type: pdf, jpg, png, jpeg, gif.',
           ];
        $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/u',
            'employee_id' => 'required|string|max:10',
            'joining_date' => 'required',
            'designation' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/u',
            'employment_type' => 'required',
            'gender' => 'required',
            'email' => 'required|string|email|cmail|max:100',
            'alternate_email' => 'required|string|email|max:100',
            'phone' => 'required|without_spaces|min:10|regex:/^(?!0+$)\d{10,}$/|max:10',
            'alternate_phone' => 'required|without_spaces|min:10|regex:/^(?!0+$)\d{10,}$/',
            'address' => 'required',
            'birth_day' => 'required',
            'bank_account' => 'required',
            'basic_salary' => 'required|numeric',
            'hra' => 'required|numeric',
            'other_allow' => 'required|numeric',
            'base_salary' => 'required|numeric',
            'salary_advance' => 'numeric',
            'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
            'status' => 'required',
            'idp' => 'mimes:pdf,jpg,png,jpeg,gif',
            'pan' => 'mimes:pdf,jpg,png,jpeg,gif'
        ],$messages);

        $user = User::findOrFail($id);
    	$user->name = $request->input('name');
        $user->employee_id = $request->input('employee_id');
        $date = date('Y-m-d', strtotime($request->input('joining_date')));
        $user->joining_date = $date;
        $user->designation = $request->input('designation');
        $user->employment_type = $request->input('employment_type');
        $user->gender = $request->input('gender');
        $user->email = $request->input('email');
        $user->alternate_email = $request->input('alternate_email');
        $user->phone = $request->input('phone');
        $user->alternate_phone = $request->input('alternate_phone');
        $user->address = $request->input('address');
        $user->birth_day = date('Y-m-d', strtotime($request->input('birth_day')));
        if($request->input('wedding_day')!=''){
        $user->wedding_day = date('Y-m-d', strtotime($request->input('wedding_day')));
        } else {
            $user->wedding_day = '';
        }
        $user->bank_account = $request->input('bank_account');
        $user->base_salary = $request->input('base_salary');
        $user->basic_salary = $request->input('basic_salary');
        $user->hra = $request->input('hra');
        $user->other_allow = $request->input('other_allow');
        $user->salary_advance = $request->input('salary_advance');
        $user->password = Hash::make($request->input('password'));
        $user->pass = $request->input('password');
        $user->status = $request->input('status');
        $user->save();

        if($user->hr == 0){
        $emp = Employee::where('user_id', '=', $id)->first();
        $emp->name = $request->input('name');
        $emp->employee_id = $request->input('employee_id');
        $emp->joining_date = $request->input('joining_date');
        $emp->designation = $request->input('designation');
        $emp->employment_type = $request->input('employment_type');
        $emp->gender = $request->input('gender');
        $emp->email = $request->input('email');
        $emp->alternate_email = $request->input('alternate_email');
        $emp->phone = $request->input('phone');
        $emp->alternate_phone = $request->input('alternate_phone');
        $emp->address = $request->input('address');
        $emp->birth_day = date('Y-m-d', strtotime($request->input('birth_day')));
        if($request->input('wedding_day')!=''){
        $emp->wedding_day = date('Y-m-d', strtotime($request->input('wedding_day')));
        } else {
            $emp->wedding_day = '';
        }
        $emp->bank_account = $request->input('bank_account');
        $emp->base_salary = $request->input('base_salary');
        $emp->basic_salary = $request->input('basic_salary');
        $emp->hra = $request->input('hra');
        $emp->other_allow = $request->input('other_allow');
        $emp->salary_advance = $request->input('salary_advance');
        $emp->status = $request->input('status');
        $emp->save();
    }

        if ($request->hasFile('idp')) {
        $image = $request->file('idp');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/identity_proof');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Identity_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'identity';
        $profile_file->employee = $user->id;
        $profile_file->employee_id = $user->employee_id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->save();
        }

        if ($request->hasFile('pan')) {
        $image = $request->file('pan');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/pan_file');
        $image->move($destinationPath, $input['imagename']);
        $profile_file = new Pan_file;
        $profile_file->path = $input['imagename'];
        $profile_file->file_type = 'pan';
        $profile_file->employee = $user->id;
        $profile_file->employee_id = $user->employee_id;
        $profile_file->company_id = auth()->user()->cmp;
        $profile_file->save();
        }

        return redirect()->route('hr.employees')->with('success', 'Employee Updated Succesfully!');
    }

    public function inactivate_employee($id)
    {
    	$user = User::findOrFail($id);
    	$user->status = "0";
    	$user->save();

        if($user->hr == 0){
    	$emp = Employee::where('user_id', '=', $id)->first();
    	$emp->status = "0";
    	$emp->save();
        }

    	return redirect()->route('hr.inactive_employees')->with('success', 'Employee Deactivated Succesfully!');
    }

    public function activate_employee($id)
    {
        $user = User::findOrFail($id);
        $user->status = "1";
        $user->save();

        if($user->hr == 0){
        $emp = Employee::where('user_id', '=', $id)->first();
        $emp->status = "1";
        $emp->save();
        }

        return redirect()->route('hr.employees')->with('success', 'Employee Activated Succesfully!');
    }

    public function inactive_employees()
    {
    	$emp = User::where('status', '=', "0")->paginate(20);
    	return view('hr.inactive_employee', compact('emp'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function groups()
    {
    	$grp = Group::get();
    	foreach($grp as $k => $grps){
    		$user = User::where('id', '=', $grps->manager)->first();
            $members = GroupMember::where('group_id', '=', $grps->id)->count();
    		$grps->user = $user;
            $grps->members = $members;
    	}
    	return view('hr.groups', compact('grp'));
    }

    public function create_group()
    {
    	$man = User::orderBy('employee_id', 'ASC')->where('status', '=', "1")->orWhereNull('status')->get();
    	return view('hr.create_group', compact('man'));
    }

    public function store_group(Request $request)
    {
    	$request->validate([
            'group_name' => 'required|string|max:50',
            'manager' => 'required',
            // 'level' => 'required'
        ]);

        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

        $grp = new Group;
        $grp->group_name = $request->input('group_name');
        $grp->company_id = $cmp->id;
        $grp->user_id = Auth::user()->id;
        $grp->manager = $request->input('manager');
        // $grp->level = $request->input('level');
        $grp->save();

        $member = new GroupMember;
        $member->group_id = $grp->id;
        $member->user_id = Auth::user()->id;
        $member->company_id = $cmp->id;
        $member->employee_id = $request->input('manager');
        $member->manager = 1;
        $member->save();

        $user = User::where('id', '=', $request->input('manager'))->first();
        $user->group = $grp->id;
        $user->manager = 1; 
        $user->save();

        return redirect()->route('hr.groups')->with('success', 'Group Created Successfully!');
    }

    public function edit_group($id)
    {
    	$grp = Group::findOrFail($id);
    	$man = User::orderBy('employee_id', 'ASC')->where('status', '=', "1")->orWhereNull('status')->get();
    	return view('hr.edit_group', compact('grp','man'));
    }

    public function store_edit_group(Request $request,$id)
    {
        $request->validate([
            'group_name' => 'required|string|max:50',
            'manager' => 'required',
        ]);
        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

    	$grp = Group::findOrFail($id);
    	$grp->group_name = $request->input('group_name');
        $grp->manager = $request->input('manager');
        $grp->save();

        $member = GroupMember::where('group_id', '=', $id)->where('manager', '=', 1)->first();
        $member->employee_id = $request->input('manager');
        $member->manager = 1;
        $member->save();

        $user = User::where('id', '=', $request->input('manager'))->first();
        $user->group = $grp->id;
        $user->manager = 1; 
        $user->save();

    	return redirect()->route('hr.groups')->with('success', 'Group Updated Successfully!');
    }

    public function delete_group($id)
    {
    	$grp = Group::findOrFail($id);
    	$grp->delete();
        $mem = GroupMember::where('group_id', '=', $id)->get();
        $cnt = GroupMember::where('group_id', '=', $id)->count();
        if($cnt>0){
            foreach($mem as $k => $mems){
                $mems->delete();
            }
        }
    	return redirect()->route('hr.groups')->with('success', 'Group Deleted Successfully!');
    }

    public function add_to_group(Request $request, $id)
    {
        $request->validate([
            'group' => 'required',
        ]);
        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

        $user = User::findOrFail($id);
        $user->group = $request->input('group');
        $grp = $user->groups;
        $user->groups = ++$grp;
        $user->save();

        $member = new GroupMember;
        $member->group_id = $request->input('group');
        $member->user_id = Auth::user()->id;
        $member->company_id = $cmp->id;
        $member->employee_id = $id;
        $member->save();

        if($user->hr == 0){
        $emp = Employee::where('user_id', '=', $id)->first();
        $emp->group = $request->input('group');
        $emp->save();
        }

        return redirect()->route('hr.employees')->with('success', 'Employee Added to Group Succesfully!');

    }

    public function add_from_group(Request $request, $id, $gid)
    {
        $request->validate([
            'group' => 'required',
        ]);
        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

        $group = Group::findOrFail($gid);

        $user = User::findOrFail($id);
        $user->group = $request->input('group');
        $grp = $user->groups;
        $user->groups = ++$grp;
        $user->save();

        $member = new GroupMember;
        $member->group_id = $request->input('group');
        $member->user_id = Auth::user()->id;
        $member->company_id = $cmp->id;
        $member->employee_id = $id;
        $member->save();

        if($user->hr == 0){
        $emp = Employee::where('user_id', '=', $id)->first();
        $emp->group = $request->input('group');
        $emp->save();
        }

        return redirect()->route('hr.group_members', $group->id)->with('success', 'Employee Added to Group Succesfully!');

    }

    public function group_members($id)
    {
        $grp = Group::findOrFail($id);
        $member = GroupMember::where('group_id', '=', $grp->id)->paginate(20);
        // dd($member);
        $fcompany = array();
        foreach ($member as $key => $members) {
            $cmp = Company::where('id', '=', $members->company_id)->first();
            $members->cmp = $cmp;
            $user = User::where('id', '=', $members->employee_id)->first();
            $members->user = $user;
            $group_members = GroupMember::where('employee_id', '=', $member[$key]->employee_id)->pluck('group_id');
            if(count($group_members)>0){
            $group = Group::whereNotIn('id', $group_members)->get();
        } else {
            $group = Group::get();
        }
            
            $members->group = $group;
            $fcompany[]=$members->employee_id;
        }
        // dd($member);
        $emp = User::where('status', '=', "1")->orWhereNull('status')->whereNotIn('id',$fcompany)->get();
        // dd($emp);
        return view('hr.group_members', compact('grp', 'member', 'emp'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function make_manager(Request $request, $id, $uid)
    {
        $grp = Group::findOrFail($id);
        $user = User::findOrFail($uid);

        $grp->manager = $uid;
        $grp->save();

        $mem = GroupMember::where('group_id', '=', $grp->id)->where('manager', '=', 1)->first();
        $mem->manager = 0;
        $mem->save();

        $member = GroupMember::where('group_id', '=', $grp->id)->where('employee_id', '=', $user->id)->first();
        $member->manager = 1;
        $member->save();

        return redirect()->route('hr.group_members', $id)->with('success', 'Group Manager changed Succesfully!');
    }

    public function add_group(Request $request, $id)
    {
        $grp = Group::findOrFail($id);
        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

        $emp = $request->input('employee');
        if($request->input('employee')!=''){
        foreach($emp as $k => $emps){
            $member = new GroupMember;
            $member->group_id = $grp->id;
            $member->user_id = Auth::user()->id;
            $member->company_id = $cmp->id;
            $member->employee_id = $emps;
            $member->save();
        }
    }

        return redirect()->route('hr.group_members', $id)->with('success', 'New Employee added to Group Succesfully!');

    }

    public function remove_from_group($id, $gid)
    {
        $grp = Group::findOrFail($id);
        $mem = GroupMember::findOrFail($gid);
        $mem->delete();

        return redirect()->route('hr.group_members', $id)->with('success', 'Employee removed from Group Succesfully!');
    }

    public function documents()
    {
        $doc = Document::where('user_id', '=', Auth::user()->id)->paginate(20);
        foreach ($doc as $key => $docs) {
            $user = User::where('id', '=', $docs->employee)->first();
            $docs->user = $user;
        }
        return view('hr.docs', compact('doc'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function my_docs()
    {
        $doc = Document::where('employee', '=', Auth::user()->id)->orWhere('employee', '=', 'all')->paginate(20);
        foreach ($doc as $key => $docs) {
            $user = User::where('id', '=', $docs->employee)->first();
            $docs->user = $user;
        }
        return view('hr.my_docs', compact('doc'))->with('i', (request()->input('page', 1) - 1) * 20);

    }

    public function add_doc()
    {
        $emp = User::where('status', '=', "1")->orWhereNull('status')->get();
        return view('hr.add_doc', compact('emp'));
    }

    public function doc_store(Request $request)
    {
        $request->validate([
            'doc_name' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]+$/u',
            'employee' => 'required',
            'description' => 'required',
            'document' => 'required',
        ]);
        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

        // $doc = new Document;
        // $doc->document_name = $request->input('doc_name');
        // $doc->employee = $request->input('employee');
        $users = array();
        $emp = $request->input('employee');
        if($request->input('employee')!=''){
        foreach($emp as $k => $emps){
            $doc = new Document;
            $doc->document_name = $request->input('doc_name');
            $doc->employee = $emps;
            $doc->description = $request->input('description');
            $doc->user_id = Auth::user()->id;
            $doc->company_id = $cmp->id;
            $doc->save();

            $users[] = $doc->id;

            if($request->input('employee')==array(0 => "all")){
                $employees = User::where('status', '=', "1")->where('cmp', '=', $cmp->id)->get();
                foreach($employees as $k => $employee){
                    $send_email = $employee->email;
                    $data=array('to'=>$send_email,'doc'=>$doc,'employee'=>$employee);

                    Mail::send('emails.doc_upload', $data, function($message) use ($send_email, $doc)
                    {
                        $message->to($send_email)->subject("Document Uploaded - ".$doc->document_name);
                    });
                }
            } else {
                $employee = User::where('id', '=', $emps)->first();
                $send_email = $employee->email;

                $data=array('to'=>$send_email,'doc'=>$doc,'employee'=>$employee);

                Mail::send('emails.doc_upload', $data, function($message) use ($send_email, $doc)
                {
                    $message->to($send_email)->subject("Document Uploaded - ".$doc->document_name);
                });
            }

        }
        if ($request->hasFile('document')) {
                $image = $request->file('document');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/doc_file');
                $request->file('document')->move($destinationPath, $filename);
                $ind = Document::where('id','=',$doc->id)->first();
                foreach($users as $k => $us){
                    $profile_file = new Doc_file;
                    $profile_file->path = $filename;
                    $profile_file->doc_id=$us;
                    $profile_file->employee = $emps;
                    $profile_file->user_id = auth()->user()->id;
                    $profile_file->company_id = $cmp->id;
                    $profile_file->save();
               } 
        }
    }
        // $doc->description = $request->input('description');
        // $doc->user_id = Auth::user()->id;
        // $doc->company_id = $cmp->id;
        // $doc->save();
        
        
        return redirect()->route('hr.documents')->with('success', 'New Document Created Succesfully!');
    }

    public function edit_doc($id)
    {
        $doc = Document::findOrFail($id);
        $file = Doc_file::where('doc_id', '=', $doc->id)->first();
        $emp = User::where('status', '=', "1")->orWhereNull('status')->get();
        return view('hr.edit_document', compact('doc', 'emp', 'file'));
    }

    public function edit_doc_store(Request $request, $id)
    {
        $request->validate([
            'doc_name' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]+$/u',
            'employee' => 'required',
            'description' => 'required',
            'files' => 'mimes:pdf',
        ]);
        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

        $doc = Document::findOrFail($id);
        $doc->document_name = $request->input('doc_name');
        $doc->employee = $request->input('employee');
        $doc->description = $request->input('description');
        $doc->user_id = Auth::user()->id;
        $doc->company_id = $cmp->id;
        $doc->save();
        
        $emp = $request->file('files');
        if($request->file('files')!=''){
        foreach($emp as $k => $emps){
            $input['imagename'] = time().'.'.$emp[$k]->getClientOriginalExtension();
        $destinationPath = public_path('/doc_file');
        $emp[$k]->move($destinationPath, $input['imagename']);
        $ind = Document::where('id','=',$doc->id)->first();
        $profile_file = new Doc_file;
        $profile_file->path = $input['imagename'];
        $profile_file->doc_id=$ind->id;
        $profile_file->user_id = auth()->user()->id;
        $profile_file->company_id = $cmp->id;
        $profile_file->save();
        }
        }
        return redirect()->route('hr.documents')->with('success', 'New Document Created Succesfully!');


    }

    public function view_document($id)
    {
        $doc = Document::findOrFail($id);
        $file = Doc_file::where('doc_id', '=', $id)->get();
        return view('hr.view_document', compact('doc', 'file'));
    }

    public function delete_document($id)
    {
        $doc = Document::findOrFail($id);
        $doc->delete();
        return redirect()->route('hr.documents')->with('success', 'Document Deleted Succesfully!');
    }

    public function slip()
    {
        $salary = SalarySlip::where('employee_id', '=', Auth::user()->employee_id)->paginate(15);
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        return view('hr.sal_slip', compact('salary', 'company'))->with('i', (request()->input('page', 1) - 1) * 15);
    }

    public function view_salary_slip($id)
    {
        $salary = SalarySlip::findOrFail($id);
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        return view('hr.view_salary', compact('salary', 'company'));
    }

    public function awards()
    {
        $awd = Award::paginate(20);
        foreach ($awd as $key => $awds) {
            $user = User::where('id', '=', $awds->employee)->first();
            $awds->user = $user;
        }
        return view('hr.awards', compact('awd'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function add_award()
    {
        $emp = User::where('status', '=', "1")->orWhereNull('status')->get();
        return view('hr.add_award', compact('emp'));
    }

    public function award_store(Request $request)
    {
        $request->validate([
            'award_name' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]+$/u',
            'employee' => 'required',
            'files' => 'required',
        ]);
        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

        // $doc = new Document;
        // $doc->document_name = $request->input('doc_name');
        // $doc->employee = $request->input('employee');
            $doc = new Award;
            $doc->award_name = $request->input('award_name');
            $doc->employee = $request->input('employee');
            $doc->user_id = Auth::user()->id;
            $doc->company_id = $cmp->id;
            $doc->save();

            if ($request->hasFile('files')) {
            $image = $request->file('files');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/award_file');
            $image->move($destinationPath, $input['imagename']);
            $ind = Award::where('id','=',$doc->id)->first();
            $profile_file = new Award_file;
            $profile_file->path = $input['imagename'];
            $profile_file->award_id=$ind->id;
            $profile_file->user_id = auth()->user()->id;
            $profile_file->company_id = $cmp->id;
            $profile_file->save();
        }

        return redirect()->route('hr.awards')->with('success', 'New Award Created Succesfully!');
    }

    public function edit_award($id)
    {
        $doc = Award::findOrFail($id);
        $file = Award_file::where('award_id', '=', $doc->id)->first();
        $emp = User::where('status', '=', "1")->orWhereNull('status')->get();
        return view('hr.edit_award', compact('doc', 'emp', 'file'));
    }

    public function edit_award_store(Request $request, $id)
    {
        $request->validate([
            'award_name' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]+$/u',
            'employee' => 'required',
            'files' => 'mimes:pdf,',
        ]);
        $cmp = Company::where('id', '=', Auth::user()->cmp)->first();

        $doc = Award::findOrFail($id);
        $doc->document_name = $request->input('doc_name');
        $doc->employee = $request->input('employee');
        $doc->user_id = Auth::user()->id;
        $doc->company_id = $cmp->id;
        $doc->save();
        
        if ($request->hasFile('files')) {
            $image = $request->file('files');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/award_file');
            $image->move($destinationPath, $input['imagename']);
            $ind = Award::where('id','=',$doc->id)->first();
            $profile_file = new Award_file;
            $profile_file->path = $input['imagename'];
            $profile_file->award_id=$ind->id;
            $profile_file->user_id = auth()->user()->id;
            $profile_file->company_id = $cmp->id;
            $profile_file->save();
        }
        return redirect()->route('hr.awards')->with('success', 'Award Updated Succesfully!');


    }

    public function view_award($id)
    {
        $doc = Award::findOrFail($id);
        $file = Award_file::where('award_id', '=', $id)->get();
        return view('hr.view_award', compact('doc', 'file'));
    }

    public function delete_award($id)
    {
        $doc = Award::findOrFail($id);
        $doc->delete();
        return redirect()->route('hr.awards')->with('success', 'Award Deleted Succesfully!');
    }

    public function leave_request()
    {
        $manager = GroupMember::where('user_id', '=', Auth::user()->id)->where('manager', '=', 1)->whereNotNull('leave_id')->get();
        $date = date('Y-m-d');
        // dd($date);
        $fleave = LeaveRequest::orderBy('from_date', 'ASC')->whereNull('approve')->paginate(20);
        // dd($fleave);
        foreach($fleave as $k => $leaves){
            $user = User::where('id', '=', $fleave[$k]->user_id)->first();
            $leaves->user = $user;
         }

        return view('hr.leave_request', compact('manager', 'fleave'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function approved_leaves()
    {
        $manager = GroupMember::where('user_id', '=', Auth::user()->id)->where('manager', '=', 1)->whereNotNull('leave_id')->get();
        $fleave = LeaveRequest::orderBy('created_at', 'DESC')->where('approve', '=', 1)->paginate(20);
        // dd($fleave);
        foreach($fleave as $k => $leaves){
            $user = User::where('id', '=', $fleave[$k]->user_id)->first();
            $leaves->user = $user;
         }

        return view('hr.approved_leaves', compact('manager', 'fleave'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function rejected_leaves()
    {
        $manager = GroupMember::where('user_id', '=', Auth::user()->id)->where('manager', '=', 1)->whereNotNull('leave_id')->get();
        $fleave = LeaveRequest::orderBy('from_date', 'ASC')->where('approve', '=', 0)->paginate(20);
        // dd($fleave);
        foreach($fleave as $k => $leaves){
            $user = User::where('id', '=', $fleave[$k]->user_id)->first();
            $leaves->user = $user;
         }

        return view('hr.rejected_leaves', compact('manager', 'fleave'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function leave_accept($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->approve = 1;
        $leave->approved_by = Auth::user()->id;
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

        $data=array('to'=>$send_email,'lname'=>$lname,'start'=>$start,'lreason'=>$lreason,'user'=>$user,'leave'=>$leave);

        Mail::send('emails.approve_leave', $data, function($message) use ($send_email, $user, $lname)
          {
           $message->to($send_email)->subject("Leave Approved - ".$user->name." - ".$lname);
          });
        return redirect()->route('hr.approved_leaves')->with('success', 'Leave Approved Succesfully!');
    }

    public function leave_reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required',
        ]);
        $leave = LeaveRequest::findOrFail($id);

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
        return redirect()->route('hr.rejected_leaves')->with('success', 'Leave Rejected Succesfully!');
    }

    public function view_leave_doc($id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $d = $leave->dates;
        $start = explode(',', $d);
        $file = Leave_file::where('leave_id', '=', $leave->id)->first();
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        return view('hr.view_leave_document', compact('leave', 'file', 'company', 'start'));
    }

    public function salary()
    {
        $employee = User::orderBy('employee_id', 'ASC')->where('status', '=', "1")->paginate(20);
        // dd($employee);
        if(date('d')>='01' && date('d')<='05'){
            $date = Carbon::now();
            $salary_month = $date->subMonth()->format('M Y');
        } else {
            $date = Carbon::now();
            $salary_month = $date->format('M Y');
        }
        $totdays = array();
        foreach($employee as $key => $employees){
                $d = Carbon::now();
                $monthprev = $d->subMonth()->format('m');
                $date = Carbon::now();
                $lastMonth =  $date->subMonth()->format('Y-m')."-26";
                $thiMonth = date('Y-m')."-25";

                $days = LeaveDateSplit::where('employee', '=', $employees->id)->where('leave_type', '<>', 'half_day')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
                $free = LeaveDateSplit::where('employee', '=', $employees->id)->where('leave_type', '<>', 'loss_of_pay')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
                $paid = LeaveDateSplit::where('employee', '=', $employees->id)->where('leave_type', '=', 'loss_of_pay')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
                $half_days = LeaveDateSplit::where('employee', '=', $employees->id)->where('leave_type', '=', 'half_day')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
                $half_gain = LeaveDateSplit::where('employee', '=', $employees->id)->where('leave_type', '=', 'half_day')->where('type', '=', 'gain')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
                $half_loss = LeaveDateSplit::where('employee', '=', $employees->id)->where('leave_type', '=', 'half_day')->where('type', '=', 'loss')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
                $days = $days + $half_days * 0.5;
                $free = $free + $half_gain * 0.5;
                $paid = $paid + $half_loss * 0.5;

            // $totdays[] = $days;
            $year = date('Y');
            $month = date('m');
            // $days = LeaveRequest::where('user_id', '=', $employees->id)->where('date('m', strtotime('from_date'))')->whereBetween('to_date', array(Carbon::createFromDate($year, $month, 1), Carbon::createFromDate($year, $month, 30)))->where('approve', '=', 1)->sum('days');
            if($paid>0 && $days>0){
            $worked = 30 - $days;
            $per_day = $employees->base_salary / 30;
            $free = $days - $paid;
            $paid = $paid;
            $ded = round($paid * $per_day);
            $earn = $employees->base_salary - $paid * $per_day;
            $employees->days = $days;
            $employees->worked = $worked;
            $employees->ded = $ded;
            $employees->earn = round($earn);
            $employees->free = $free;
            $employees->paid = $paid;
            } elseif ($employees->paid==0 && $days>0){
            $worked = 30 - $days;
            $per_day = $employees->base_salary / 30;
            $free = $days;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = $employees->base_salary;
            $employees->days = $days;
            $employees->worked = $worked;
            $employees->ded = $ded;
            $employees->earn = round($earn);
            $employees->free = $free;
            $employees->paid = $paid;
            } elseif ($employees->loss_of_pay==0 && $days==0) {
            $worked = 30 - $days;
            $per_day = $employees->base_salary / 30;
            $free = 0;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = $employees->base_salary - $days * $per_day;
            $employees->days = $days;
            $employees->worked = $worked;
            $employees->ded = $ded;
            $employees->earn = round($earn);
            $employees->free = $free;
            $employees->paid = $paid;
        }
        }
        $today = \Carbon\Carbon::now(); //Current Date and Time
        // dd(date('m'));
        //dd($totdays);
        //exit();

    $lastDayofMonth =    \Carbon\Carbon::parse($today)->endOfMonth()->toDateString();
    $d = date('d', strtotime($lastDayofMonth));
    // dd($d);

        return view('hr.salary', compact('employee', 'd', 'salary_month'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function add_salary()
    {
        $request->validate([
            'doc_name' => 'required',
            'employee' => 'required',
            'description' => 'required',
            'files' => 'required',
        ]);
        $salary = new Salary;

    }

    public function profile(Request $request, $eid)
    {
        $user = User::where('employee_id', '=', $eid)->first();
        $days = LeaveRequest::where('employee_id', '=', $eid)->where('fmonth', '=', date('m'))->where('tmonth', '=', date('m'))->where('approve', '=', 1)->sum('days');
        // dd($user);

        if($user->casual_leave<0 && $days>0){
            $worked = 30 - $days;
            $per_day = $user->base_salary / 30;
            $free = $days + $user->casual_leave;
            $paid = -$user->casual_leave;
            $ded = round($paid * $per_day);
            $earn = round($user->base_salary - $paid * $per_day);
            $basic = round($user->basic_salary - $paid * $per_day);
        } elseif ($user->casual_leave>=0 && $days>0){
            $worked = 30 - $days;
            $per_day = $user->base_salary / 30;
            $free = $days;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = round($user->base_salary);
            $basic = round($user->basic_salary);
            } else {
            $worked = 30 - $days;
            $per_day = $user->base_salary / 30;
            $free = 0;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = round($user->base_salary - $days * $per_day);
            $basic = round($user->basic_salary - $days * $per_day);
        }
        $company = Company::where('id', '=', $user->cmp)->first();
        $member = GroupMember::where('employee_id', '=', $user->id)->where('manager', '<>', 1)->get();
        $manager = array();
        foreach($member as $k => $members){
            $group = Group::where('id', '=', 'group_id')->first();
            $manager[] = GroupMember::where('group_id', '=', $members->group_id)->where('manager', '=', 1)->first();
            $members->group = $group;
        }
        // dd($group);
        foreach ($manager as $key => $managers) {
            $us = User::where('id', '=', $managers->employee_id)->first();
            $managers->us = $us;
        }
        $g = GroupMember::where('employee_id', '=', $user->id)->where('manager', '<>', 1)->first();
        if(isset($g)){
            $grp = Group::where('id', '=', $g->group_id)->first();
        } else {
            $grp = "";
        }
        $leave = LeaveRequest::where('user_id', '=', $user->id)->get();
        return view('hr.profile', compact('user', 'leave', 'company', 'member', 'manager', 'days', 'worked', 'per_day', 'free', 'paid', 'ded', 'earn', 'basic', 'grp'));
    }

    public function salary_slip($eid)
    {
        if(date('d')>='01' && date('d')<='05'){
            $date = Carbon::now();
            $salary_month = $date->subMonth()->format('M Y');
        } else {
            $date = Carbon::now();
            $salary_month = $date->format('M Y');
        }
        // $date = Carbon::createFromFormat('m/d/Y', '11/02/2020')->addMonth();
  
        $newDate = $date->format('m/d/Y');
  
        // dd($salary_month);
        $employee = User::where('employee_id', '=', $eid)->first();
        $leave = LeaveRequest::where('employee_id', '=', $eid)->where('fmonth', '=', date('m'))->where('tmonth', '=', date('m'))->where('approve', '=', 1)->get();
        // $days = LeaveRequest::where('employee_id', '=', $eid)->where('fmonth', '=', date('m'))->where('tmonth', '=', date('m'))->where('approve', '=', 1)->sum('days');
            $dt = Carbon::now();
            $lastMonth =  $dt->subMonth()->format('Y-m')."-26";
            $thiMonth = date('Y-m')."-25";
            $days = LeaveDateSplit::where('employee', '=', $employee->id)->where('leave_type', '<>', 'half_day')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
            $free = LeaveDateSplit::where('employee', '=', $employee->id)->where('leave_type', '<>', 'loss_of_pay')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
            $paid = LeaveDateSplit::where('employee', '=', $employee->id)->where('leave_type', '=', 'loss_of_pay')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
            $half_days = LeaveDateSplit::where('employee', '=', $employee->id)->where('leave_type', '=', 'half_day')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
            $half_gain = LeaveDateSplit::where('employee', '=', $employee->id)->where('leave_type', '=', 'half_day')->where('type', '=', 'gain')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
            $half_loss = LeaveDateSplit::where('employee', '=', $employee->id)->where('leave_type', '=', 'half_day')->where('type', '=', 'loss')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
            $days = $days + $half_days * 0.5;
            $free = $free + $half_gain * 0.5;
            $paid = $paid + $half_loss * 0.5;
            // dd($employee);

        if($paid>0 && $days>0){
            $worked = 30 - $days;
            $per_day = $employee->base_salary / 30;
            $free = $days - $paid;
            $paid = $paid;
            $ded = round($paid * $per_day);
            $earn = round($employee->base_salary - $paid * $per_day);
            $basic = round($employee->other_allow - $paid * $per_day);
            $totded = round($employee->salary_advance + $ded);
            } elseif ($paid==0 && $days>0){
            $worked = 30 - $days;
            $per_day = $employee->base_salary / 30;
            $free = $days;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = round($employee->base_salary);
            $basic = round($employee->other_allow);
            $totded = round($employee->salary_advance + $ded);
            } elseif ($paid==0 && $days==0) {
            $worked = 30 - $days;
            $per_day = $employee->base_salary / 30;
            $free = 0;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = round($employee->base_salary);
            $basic = round($employee->other_allow);
            $totded = round($employee->salary_advance + $ded);
        }
        $sal = Salary::where('employee_id', '=', $employee->employee_id)->where('month', '=', date('m'))->count();
        if($sal<1){
            $salary = new Salary;
            $salary->employee_id = $employee->employee_id;
            $salary->working_days = 30;
            $salary->worked_days = $worked;
            $salary->leave_taken = $days;
            $salary->earned_leaves = $free;
            $salary->loss_of_pay = $paid;
            $salary->salary = $employee->base_salary;
            $salary->leave_deduction = $ded;
            $salary->earnings = $earn;
            $salary->basic_salary = $basic;
            $salary->month = date('m');
            $salary->save();
        } else {
            $salary = Salary::where('employee_id', '=', $employee->employee_id)->where('month', '=', date('m'))->first();
            $salary->employee_id = $employee->employee_id;
            $salary->working_days = 30;
            $salary->worked_days = $worked;
            $salary->leave_taken = $days;
            $salary->earned_leaves = $free;
            $salary->loss_of_pay = $paid;
            $salary->salary = $employee->base_salary;
            $salary->leave_deduction = $ded;
            $salary->earnings = $earn;
            $salary->basic_salary = $basic;
            $salary->month = date('m');
            $salary->save();
        }
        $current = date('F');
        $month = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('F');
        $mon = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('M Y');

        return view('hr.salary_slip', compact('employee', 'leave', 'days', 'worked', 'days', 'free', 'paid', 'ded', 'earn', 'basic', 'totded', 'month', 'salary_month'));
    }

    public function delete_employee()
    {
        $user = User::where('employee_id', '=', null)->first();
        $user->delete();
        return 'Deleted';
    }

    public function delete_salary()
    {
        $sal = LeaveRequest::first();
        $sal->delete();
        return 'Deleted';
    }

    public function get_employee()
    {
        $user = User::where('hr_id', '=', Auth::user()->id)->where('status', '=', '1')->get();
        dd($user);
    }

    public function expense()
    {
        $expense = Expense::where('year', '=', date('Y'))->get();
        $mon1 = Expense::where('month', '=', '01')->where('year', '=', date('Y'))->first();
        $jan = @$mon1->amount;
        $mon2 = Expense::where('month', '=', '02')->where('year', '=', date('Y'))->first();
        if(isset($mon2)){
            $feb = @$mon2->amount;
        } else {
            $feb = '';
        }
        $mon3 = Expense::where('month', '=', '03')->where('year', '=', date('Y'))->first();
        if(isset($mon3)){
            $mar = @$mon3->amount;
        } else {
            $mar = '';
        }
        $mon4 = Expense::where('month', '=', '04')->where('year', '=', date('Y'))->first();
        if(isset($mon4)){
            $apr = @$mon4->amount;
        } else {
            $apr = '';
        }
        $mon5 = Expense::where('month', '=', '05')->where('year', '=', date('Y'))->first();
        if(isset($mon5)){
            $may = $mon5->amount;
        } else {
            $may = '';
        }
        $mon6 = Expense::where('month', '=', '06')->where('year', '=', date('Y'))->first();
        if(isset($mon6)){
            $jun = @$mon6->amount;
        } else {
            $jun = '';
        }
        $mon7 = Expense::where('month', '=', '07')->where('year', '=', date('Y'))->first();
        if(isset($mon7)){
            $jul = @$mon7->amount;
        } else {
            $jul = '';
        }
        $mon8 = Expense::where('month', '=', '08')->where('year', '=', date('Y'))->first();
        if(isset($mon8)){
            $aug = @$mon8->amount;
        } else {
            $aug = '';
        }
        $mon9 = Expense::where('month', '=', '09')->where('year', '=', date('Y'))->first();
        if(isset($mon9)){
            $sep = @$mon9->amount;
        } else {
            $sep = '';
        }
        $mon10 = Expense::where('month', '=', '10')->where('year', '=', date('Y'))->first();
        if(isset($mon10)){
            $oct = @$mon10->amount;
        } else {
            $oct = '';
        }
        $mon11 = Expense::where('month', '=', '11')->where('year', '=', date('Y'))->first();
        if(isset($mon11)){
            $nov = @$mon11->amount;
        } else {
            $nov = '';
        }
        $mon12 = Expense::where('month', '=', '12')->where('year', '=', date('Y'))->first();
        if(isset($mon12)){
            $dec = @$mon12->amount;
        } else {
            $dec = '';
        }
        $yexpense = YearlyExpense::whereNotNull('year')->get();
        return view('hr.expense', compact('expense','yexpense','jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'));
    }

    public function holiday()
    {
        $holiday = Holiday::orderBy('dt', 'ASC')->where('year', '=', date('Y'))->paginate(20);
        return view('hr.holiday', compact('holiday'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function add_holiday()
    {
        return view('hr.add_holiday');
    }

    public function holiday_store(Request $request)
    {
        $request->validate([
            'holiday' => 'required',
            'holiday_date' => 'required',
            'description' => 'required',
        ]);
        $holiday = new Holiday;

        $holiday->holiday = $request->input('holiday');
        $holiday->date = date('M-d', strtotime($request->input('holiday_date')));
        $holiday->year = date('Y', strtotime($request->input('holiday_date')));
        $holiday->day = date('l', strtotime($request->input('holiday_date')));
        $holiday->dt = date('Y-m-d', strtotime($request->input('holiday_date')));
        $holiday->description = $request->input('description');
        $holiday->save();

        return redirect()->route('hr.holiday')->with('success', 'Holiday Added Succesfully!');

    }

    public function edit_holiday($id)
    {
        $holiday = Holiday::findOrFail($id);
        return view('hr.edit_holiday', compact('holiday'));
    }

    public function edit_holiday_store(Request $request, $id)
    {
        $request->validate([
            'holiday' => 'required',
            'holiday_date' => 'required',
            'description' => 'required',
        ]);
        $holiday = Holiday::findOrFail($id);

        $holiday->holiday = $request->input('holiday');
        $holiday->date = date('M-d', strtotime($request->input('holiday_date')));
        $holiday->year = date('Y', strtotime($request->input('holiday_date')));
        $holiday->day = date('l', strtotime($request->input('holiday_date')));
        $holiday->dt = date('Y-m-d', strtotime($request->input('holiday_date')));
        $holiday->description = $request->input('description');
        $holiday->save();

        return redirect()->route('hr.holiday')->with('success', 'Holiday Updated Succesfully!');
    }

    public function delete_holiday($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();

        return redirect()->route('hr.holiday')->with('success', 'Holiday Deleted Succesfully!');
    }

    public function change_password()
    {
        $company = Company::where('id', '=', Auth::user()->cmp)->first();
        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('hr.change_password', compact('user','company'));
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
        return redirect()->route('hr.home')->with('success', 'Welcome back '.$user_name.', Password changed successfully!');
    }

    public function salary_cron()
    {
        if(date('d')>='01' && date('d')<='05'){
            $date = Carbon::now();
            $salary_month = $date->subMonth()->format('M Y');
        } else {
            $date = Carbon::now();
            $salary_month = $date->format('M Y');
        }
        // $date = Carbon::createFromFormat('m/d/Y', '11/02/2020')->addMonth();
  
        $newDate = $date->format('m/d/Y');
  
        // dd($salary_month);
        $employee = User::where('status', '=', "1")->get();
        foreach($employee as $k => $employees){
        $leave = LeaveRequest::where('employee_id', '=', $employee[$k]->id)->where('fmonth', '=', date('m'))->where('tmonth', '=', date('m'))->where('approve', '=', 1)->get();
        $days = LeaveRequest::where('employee_id', '=', $employee[$k]->id)->where('fmonth', '=', date('m'))->where('tmonth', '=', date('m'))->where('approve', '=', 1)->sum('days');
        // dd($employee);

        if($employee[$k]->loss_of_pay>0 && $days>0){
            $worked = 30 - $days;
            $per_day = $employee[$k]->base_salary / 30;
            $free = $days - $employee[$k]->loss_of_pay;
            $paid = $employee[$k]->loss_of_pay;
            $ded = round($paid * $per_day);
            $earn = round($employee[$k]->base_salary - $paid * $per_day);
            $basic = round($employee[$k]->other_allow - $paid * $per_day);
            } elseif ($employee[$k]->loss_of_pay==0 && $days>0){
            $worked = 30 - $days;
            $per_day = $employee[$k]->base_salary / 30;
            $free = $days;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = round($employee[$k]->base_salary);
            $basic = round($employee[$k]->other_allow);
            } elseif ($employee[$k]->loss_of_pay==0 && $days==0) {
            $worked = 30 - $days;
            $per_day = $employee[$k]->base_salary / 30;
            $free = 0;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = round($employee[$k]->base_salary);
            $basic = round($employee[$k]->other_allow);
        }
        $sal = Salary::where('employee', '=', $employee[$k]->employee_id)->where('month', '=', date('m'))->count();
        if($sal<1){
            $salary = new Salary;
            $salary->employee = $employee[$k]->employee_id;
            $salary->working_days = 30;
            $salary->worked_days = $worked;
            $salary->leave_taken = $days;
            $salary->earned_leaves = $free;
            $salary->loss_of_pay = $paid;
            $salary->salary = $employee[$k]->basic_salary;
            $salary->leave_deduction = $ded;
            $salary->earnings = $earn;
            $salary->basic_salary = $employee[$k]->basic_salary;
            $salary->month = date('m');
            $salary->year = date('Y');
            $salary->save();
        } else {
            $salary = Salary::where('employee', '=', $employee[$k]->employee_id)->where('month', '=', date('m'))->first();
            $salary->employee = $employee[$k]->employee_id;
            $salary->working_days = 30;
            $salary->worked_days = $worked;
            $salary->leave_taken = $days;
            $salary->earned_leaves = $free;
            $salary->loss_of_pay = $paid;
            $salary->salary = $employee[$k]->base_salary;
            $salary->leave_deduction = $ded;
            $salary->earnings = $earn;
            $salary->basic_salary = $employee[$k]->basic_salary;
            $salary->month = date('m');
            $salary->year = date('Y');
            $salary->save();
        }
        $current = date('F');
        $empl = User::where('id', '=', $employee[$k]->id)->first();
        $month = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('F');
        $mon = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('M Y');
        $pdf = PDF::loadView('hr.pdf', compact('empl', 'leave', 'days', 'worked', 'days', 'free', 'paid', 'ded', 'earn', 'basic', 'month'));

        $slip = SalarySlip::where('user_id', '=', $employee[$k]->id)->where('salary_id', '=', $salary->id)->where('month', '=', date('m'))->count();
        if($slip<1){
        Storage::put('public/pdf/'.'Salary Slip-'.$employee[$k]->employee_id.'-'.$employee[$k]->name.'-'.$mon.'.pdf', $pdf->output());
        $salary_slip = new SalarySlip;
        $salary_slip->employee_id = $employee[$k]->employee_id;
        $salary_slip->user_id = $employee[$k]->id;
        $salary_slip->salary_id = $salary->id;
        $salary_slip->path = 'Salary Slip-'.$employee[$k]->employee_id.'-'.$employee[$k]->name.'-'.$mon.'.pdf';
        $salary_slip->month = date('m');
        $salary_slip->save();
        } else {
        $salary_slip = SalarySlip::where('user_id', '=', $employee[$k]->id)->where('salary_id', '=', $salary->id)->first();
        $salary_slip->employee_id = $employee[$k]->employee_id;
        $salary_slip->user_id = $employee[$k]->id;
        $salary_slip->salary_id = $salary->id;
        $salary_slip->path = 'Salary Slip-'.$employee[$k]->employee_id.'-'.$employee[$k]->name.'-'.$mon.'.pdf';
        $salary_slip->month = date('m');
        $salary_slip->save();
        }
    }

    $total_salary = Salary::where('month', '=', date('m'))->where('year', '=', date('Y'))->sum('earnings');
    $exp = Expense::where('month', '=', date('m'))->where('year', '=', date('Y'))->count();
    if($exp<1){
        $expense = new Expense;
        $expense->amount = $total_salary;
        $expense->month = date('m');
        $expense->year = date('Y');
        $expense->save();
    }
    $totalYearExp = Expense::where('month', '=', date('m'))->where('year', '=', date('Y'))->sum('amount');
    $yearexp = YearlyExpense::where('year', '=', date('Y'))->count();
    if($exp<1){
        $expense = new YearlyExpense;
        $expense->amount = $totalYearExp;
        $expense->year = date('Y');
        $expense->save();
    } else {
        $expense = YearlyExpense::where('year', '=', date('Y'))->first();
        $expense->amount = $totalYearExp;
        $expense->year = date('Y');
        $expense->save();
    }
    }

}
