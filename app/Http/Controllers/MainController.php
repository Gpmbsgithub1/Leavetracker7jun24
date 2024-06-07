<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Company;
use App\DesklogApi;
use App\DesklogUsers;
use App\Doc_file;
use App\Document;
use App\Employee;
use App\Group;
use App\GroupMember;
use App\LeaveRequest;
use App\Salary;
use App\SalarySlip;
use App\Award;
use App\Award_file;
use App\Leave_file;
use App\Expense;
use App\Identity_file;
use App\Pan_file;
use App\YearlyExpense;
use App\LeaveDateSplit;
use Carbon\Carbon;
use Mail;
use File;
use DB;
use Storage;
use PDF;
use DateTime;
use DateInterval;
class MainController extends Controller
{
    public function index()
    {
    	if(Auth::user()->hr == 1){
    		return redirect()->route('hr.home');
    	} elseif (Auth::user()->hr == 0) {
    		return redirect()->route('employee.home');
    	}
    }

    public function delete_user()
    {
        $emp = DesklogUsers::get();
        // $emp->loss_of_pay = 1;
        // $emp->save();
        // dd($emp);
        // return "Deleted";
        // exit();
        $main = User::where('status', '=', '1')->get();
        $total_salary = User::where('status', '=', '1')->sum('base_salary');
        // $em = SalarySlip::get();
        // $yesterday = Carbon::yesterday()->format('d-m-Y');
        // $lv = DesklogUsers::where('publication_date', '=', $yesterday)->get();
        // $grp = Doc_file::first();
        dd($main);
        exit();
        //  foreach ($main as $key => $value) {
        //      $value->delete();
        //  }
        // $main->delete();
        // $em->delete();
        //$grp->delete();

        return "Entry Deleted";
        // return "Data Entered";
    }

    public function create_company()
    {
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $week = DesklogApi::whereBetween('publication_date', [Carbon::now()->startOfWeek()->format('d-m-Y'), Carbon::now()->endOfWeek()->format('d-m-Y')])->sum('productive_time');
        // dd($week);
        // exit();
        $yesterday = Carbon::yesterday()->format('d-m-Y');
        $cmp = DesklogApi::where('publication_date', '=', '13-12-2021')->get();
        $lv = LeaveRequest::where('employee_id', '=', 'SK0021')->where('approve', '=', 1)->first();
        dd($lv->id);
        exit();
        $send_email = "preethisarath@skiloratech.com";
        // $send_email = "midhun@skiloratech.com";

        $user = User::where('id', '=', $lv->user_id)->first();
        $d = $lv->dates;
        $start = explode(',', $d);
        $lname = 'Half Day Leave';
        $lreason = $lv->leave_reason;

        // $data=array('to'=>$send_email, 'lname'=>$lname, 'start'=>$start, 'lreason'=>$lreason, 'user'=>$user, 'leave'=>$lv);

        // Mail::send('emails.approve_leave', $data, function($message) use ($send_email, $user, $lname)
        //   {
        //    $message->to($send_email)->subject("Leave Approved - ".$user->name." - ".$lname);
        //   });
        
        // $cmp = GroupMember::where('manager', '=', 1)->where('group_id', '=', "617fce079c636754b616b4e4")->first();
        // $cmp = GroupMember::where('manager', '=', 1)->where('group_id', '=', "617fceb33f5faf3ce4795e82")->first();
        // $cmp = GroupMember::where('manager', '=', 1)->where('group_id', '=', "617fcf0c9f020567a255add6")->first();
        // $cmp = GroupMember::where('manager', '=', 1)->where('group_id', '=', "617fcf553f5faf3ce4795e84")->first();
        // $cmp = Group::where('id', '=', "6183d0ec7bbfb823e83ef092")->first();
        // $cmp = Group::where('id', '=', "6183d18aa798ce07eb4b0512")->first();
        // $cmp = Group::where('id', '=', "6183d232a00fe1144b34c5a3")->first();
        // $cmp = Group::where('id', '=', "6183d2a5c086275314531412")->first();
        // $cmp = Group::where('id', '=', "6183d2e67bbfb823e83ef095")->first();
        // $cmp = Group::where('id', '=', "6183d33a2918243ebf0e66f2")->first();
        // $cmp = GroupMember::where('manager', '=', 1)->where('group_id', '=', "6183d3e457ffe64ef82d64d2")->first();
        // $cmp = Group::where('id', '=', "6183d41c6b971c3c904e0c88")->first();

        dd($lv);
        exit();
        // $cmp->delete();
        // $cmp->company_name = 'Skilora Technologies';
        // $cmp->status = "active";
        // $cmp->save();
        // 617fce079c636754b616b4e4 -- *
        // 617fceb33f5faf3ce4795e82 -- *
        // 617fcf0c9f020567a255add6 -- *
        // 617fcf553f5faf3ce4795e84 -- *
        // 6183d0ec7bbfb823e83ef092 --
        // 6183d18aa798ce07eb4b0512 --
        // 6183d232a00fe1144b34c5a3 --
        // 6183d2a5c086275314531412 --
        // 6183d2e67bbfb823e83ef095 --
        // 6183d33a2918243ebf0e66f2 --
        // 6183d3e457ffe64ef82d64d2 -- *
        // 6183d41c6b971c3c904e0c88 --


        // 6183d0ec7bbfb823e83ef092
        // 6183d18aa798ce07eb4b0512
        // 6183d232a00fe1144b34c5a3
        // 6183d2a5c086275314531412
        // 6183d2e67bbfb823e83ef095
        // 6183d33a2918243ebf0e66f2
        // 6183d41c6b971c3c904e0c88

        return "Entry Deleted";
    }

    public function group()
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $g = GroupMember::orderBy('created_at', 'DESC')->where('employee_id', '=', $user->id)->whereNull('manager')->orWhere('manager', '<>', 1)->first();
        if(isset($g)){
        $gr = GroupMember::where('group_id', '=', $g->group_id)->where('manager', '=', 1)->first();
        $gm = User::where('id', '=', $gr->employee_id)->first();
        dd($gm);
        exit();
        //$yexpense = YearlyExpense::whereNotNull('year')->get();
        //dd($yexpense);
        $grp = GroupMember::where('group_id', '=', '6184f2c7288a1b25f8311823')->where('manager', '=', 1)->first();
        // dd($grp);
        // exit();
        // $grp->delete();
        // return "Deleted";
        }
    }

    public function desklog()
    {
        $yesterday = Carbon::yesterday()->format('d-m-Y');
        $grp = Group::where('group_name', '=', 'ERP-CRM Department')->first();
        $desk = DesklogApi::where('email','=', "yathishk@skiloratech.com")->where('publication_date', '=', $yesterday)->first();
        // $us = DesklogApi::where('email', '=', 'nofe.alshumaimeri@machinestalk.com')->where('publication_date', '=', $yesterday)->first();
        $send_email =  "nofe.alshumaimeri@machinestalk.com";
            // $send_email = "midhun@skiloratech.com";
            $i = 0;

            $data=array('desk'=>$desk,'grp'=>$grp,'to'=>$send_email,'yesterday'=>$yesterday,'i'=>$i);

                Mail::send('emails.crm_list', $data, function($message) use ($send_email, $grp, $yesterday)
                {
                $message->to($send_email)->cc(['yathishk@skiloratech.com','vinay@skiloratech.com','nikhil@skiloratech.com','hr@skiloratech.com'])->subject("Skilora Time Sheet - ".$grp->group_name." - ".$yesterday);
                });

        return "Email Send";
    }

    public function productive()
    {
        $user = User::where('employee_id', '=', 'SK0013')->first();
        $user->casual_util = 2;
        $user->casual_rem = 0;
        $user->medical_util = 0.5;
        $user->medical_rem = 4.5;
        $user->save();
        // $desk = DesklogApi::where('publication_date', '=', '17-12-2021')->get();
        // foreach ($desk as $k => $desks) {
        //     if($desk[$k]->productive_time != 'NA'){
        //         $yt = $desk[$k]->productive_time;
        //     } else {
        //         $yt = "00h 00m 00s";
        //     }
        //     $spl = explode(" ", $yt);
        //     $h = explode("h",$spl[0]);
        //     $m = explode("m",$spl[1]);
        //     $s = explode("s",$spl[2]);
        //     $ytime = $h[0].":".$m[0].":".$s[0];
        //     $desk[$k]->productive = $ytime;
        //     $desk[$k]->productive_str = strtotime($ytime);
        //     $desk[$k]->save();
            
        // }
        return "Database Updated";
    }

    public function week_productive()
    {
        $pr = "26-".date("m-Y", strtotime("first day of previous month"));
        // dd($pr);
        // exit();
        // $user = User::where('status', '=', "1")->orWhereNull('status')->get();
        // foreach($user as $k => $users){
        //     $lv = LeaveRequest::where('employee_id', '=', 'SK0002')->get();
        //     $leave = array();
        //     foreach ($lv as $k => $lvs) {
        //         $leave[] = $lvs->dates;
        //     }
        //     dd($leave);
        //     exit();
        // }
        $yesterday = Carbon::yesterday()->format('d-m-Y');
        $desk = DesklogUsers::get();
        // dd($desk);
        // exit();
        $prod = array();
        foreach ($desk as $k => $desks) {
            $sum = "00:00:00";
            $api = DesklogApi::where('employee_id', '=', $desk[$k]->employee_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            // $prt = array();
            // $name = array();
            $hrs = array();
            $mns = array();
            $sec = array();
            foreach ($api as $k => $apis) {
                if($api[$k]->productive_time != 'NA' && $api[$k]->productive!=''){
                    $prt = $api[$k]->productive;
                } else {
                    $prt = "00:00:00";
                }
                // $name[] = $api[$k]->name;
                $t = explode(':', $prt);
                $hrs[] = $t[0];
                $mns[] = $t[1];
                $sec[] = $t[2];
            }

            $hour =  array_sum($hrs);
            $minute = array_sum($mns);
            $second = array_sum($sec);
            $hours = floor($minute / 60);
            $min = $minute - ($hours * 60);
            $h = $hours.":".$min;
            $hour = $hour + $hours;
            $minute = $min;
            $s = gmdate("H:i:s", $second);
            $sc = explode(":", $s);
            $hour = number_format($hour + $sc[0]);
            $minute = number_format($minute + $sc[1]);
            $second = $sc[2];

            $in = $hour.":".$minute.":".$second;
            $out = "40:00:00";
            $emp = User::where('employee_id', '=', $desk[$k]->employee_id)->first();
            if($desk[$k]->name != ''){
            $emp_name = $desk[$k]->name;
            } else{
                $emp_name = $emp->name;
            }
            // $send_email = $desk[$k]->email;
            $send_email = "midhun@skiloratech.com";
            $productive = $hour."h ".$minute."m ".$second."s";

            if($hour>=40){
                $hdiff = $hour - 40;
                $mdiff = $minute;
                $sdiff = $second;

                $diff = $hdiff.":".$mdiff.":".$sdiff;
                $dt = explode(":", $diff);
                $deficit_time = $dt[0]."h ".$dt[1]."m ".$dt[2]."s";

                $data=array('emp_name'=>$emp_name,'diff'=>$diff,'to'=>$send_email,'productive'=>$productive,'deficit_time'=>$deficit_time);
                if($send_email != 'nofe.alshumaimeri@machinestalk.com'){
                    Mail::send('emails.week_desk_gain', $data, function($message) use ($send_email, $yesterday, $emp_name)
                    {
                    $message->to($send_email)->subject("Skilora Weekly Time Sheet - ".$emp_name." - 13-12-2021 to 17-12-2021");
                    });
                }
            } else {
                $hdiff = 40 - $hour;
                $mdiff = 60 - $minute;
                $sdiff = 60 - $second;

                $diff = $hdiff.":".$mdiff.":".$sdiff;
                $dt = explode(":", $diff);
                $deficit_time = $dt[0]."h ".$dt[1]."m ".$dt[2]."s";

                $data=array('emp_name'=>$emp_name,'diff'=>$diff,'to'=>$send_email,'productive'=>$productive,'deficit_time'=>$deficit_time);

                if($send_email != 'nofe.alshumaimeri@machinestalk.com'){
                    Mail::send('emails.week_desk_gain', $data, function($message) use ($send_email, $yesterday, $emp_name)
                    {
                    $message->to($send_email)->subject("Skilora Weekly Time Sheet - ".$emp_name." - 13-12-2021 to 17-12-2021");
                    });
                }
            }
            
            // $diff = date('H:i:s', strtotime($in) - strtotime($out));
            // dd(strtotime($in));
            // exit();

            
            

        }
        
        return "Email Send";
    }

    public function leave_split()
    {
        ini_set('max_execution_time', '300');
        $user = User::where('status', '=', '1')->get();
        foreach ($user as $k => $users) {
            $days = 0;
            if($user[$k]->employee_id == 'SK0003'){
                $days = 1;
            } elseif ($user[$k]->employee_id == 'SK0004') {
                $days = 1;
            } elseif ($user[$k]->employee_id == 'SK0011') {
                $days = 2;
            } elseif ($user[$k]->employee_id == 'SK0017') {
                $days = 1.5;
            } elseif ($user[$k]->employee_id == 'SK0021') {
                $days = 0.5;
            } elseif ($user[$k]->employee_id == 'SK0030') {
                $days = 0.5;
            }
            $worked = 30;
            if($user[$k]->employee_id == 'SK0003'){
                $worked = 30-1;
            } elseif ($user[$k]->employee_id == 'SK0004') {
                $worked = 30-1;
            } elseif ($user[$k]->employee_id == 'SK0011') {
                $worked = 30-2;
            } elseif ($user[$k]->employee_id == 'SK0017') {
                $worked = 30-1.5;
            } elseif ($user[$k]->employee_id == 'SK0021') {
                $worked = 30-0.5;
            } elseif ($user[$k]->employee_id == 'SK0030') {
                $worked = 30-0.5;
            }
            $per_day = $user[$k]->base_salary / 30;
            $free = $days - $user[$k]->loss_of_pay;
            if($user[$k]->employee_id == 'SK0003'){
                $free = 1;
            } elseif ($user[$k]->employee_id == 'SK0004') {
                $free = 1;
            } elseif ($user[$k]->employee_id == 'SK0011') {
                $free = 2;
            } elseif ($user[$k]->employee_id == 'SK0017') {
                $free = 1.5;
            } elseif ($user[$k]->employee_id == 'SK0021') {
                $free = 0.5;
            } elseif ($user[$k]->employee_id == 'SK0030') {
                $free = 0.5;
            }
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = $user[$k]->base_salary;
            $basic = round($user[$k]->other_allow - $paid * $per_day);
            $current = date('F');
            $date = Carbon::now();
            $salary_month = $date->format('M Y');
        $empl = User::where('id', '=', $user[$k]->id)->first();
        $month = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('F');
        $mon = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('M Y');
        $pdf = PDF::loadView('hr.slip', compact('empl', 'leave', 'days', 'worked', 'days', 'free', 'paid', 'ded', 'earn', 'basic', 'month', 'salary_month'));
        Storage::put('public/pdf/'.'Salary Slip-'.$user[$k]->employee_id.'-'.$user[$k]->name.'-Dec 2021.pdf', $pdf->output());
        // return $pdf->download('Salary Slip-'.$user[$k]->employee_id.'-'.$user[$k]->name.'-'.date('M Y').'.pdf');

        $salary_slip = SalarySlip::where('employee_id', '=', $user[$k]->employee_id)->where('date', '=', 'Dec 2021')->count();
        if($salary_slip<1){
            $sal = new SalarySlip;
            $sal->employee_id = $user[$k]->employee_id;
            $sal->user_id = $user[$k]->id;
            $sal->path = 'Salary Slip-'.$user[$k]->employee_id.'-'.$user[$k]->name.'-Dec 2021.pdf';
            $sal->date = "Dec 2021";
            // $sal->amount =
            // $sal->date = "date('M Y')";
            $sal->save();
        } else {
            $sal = SalarySlip::where('employee_id', '=', $user[$k]->employee_id)->where('date', '=', 'Dec 2021')->first();
            $sal->employee_id = $user[$k]->employee_id;
            $sal->user_id = $user[$k]->id;
            $sal->path = 'Salary Slip-'.$user[$k]->employee_id.'-'.$user[$k]->name.'-Dec 2021.pdf';
            $sal->date = "Dec 2021";
            // $sal->date = date('M Y');
            $sal->save();
        }

        // $send_email = $user[$k]->email;
        // $send_email = "midhun@skiloratech.com";
        // $doc = "Salary Slip - Dec 2021";
        // $employee = $user[$k];

        // $data=array('to'=>$send_email,'doc'=>$doc,'employee'=>$employee);

        //         Mail::send('emails.doc_upload', $data, function($message) use ($send_email)
        //         {
        //             $message->to($send_email)->subject("Salary Slip Uploaded - Dec 2021");
        //         });

        // $leave_date = $leave->dates;
        // if($leave->days>1){
        //     $ld = explode(",",$leave_date);
        //     foreach ($ld as $k => $lds) {
        //         $date_split = new LeaveDateSplit;
        //         $date_split->employee_id = $leave->employee_id;
        //         $date_split->employee = $leave->user_id;
        //         $date_split->date = $lds;
        //         $date_split->save();
        //     }
        // } else {
        //     $date_split = new LeaveDateSplit;
        //     $date_split->employee_id = $leave->employee_id;
        //     $date_split->employee = $leave->user_id;
        //     $date_split->date = $leave->dates;
        //     $date_split->save();
        // }
    }
    return "Salary Slips saved";
}

    public function salary_slip()
    {
        $sal = SalarySlip::get();
        dd($sal);
    }

    public function pdf()
    {
        ini_set('max_execution_time', '300');
        $user = User::where('employee_id', '=', 'SK0005')->first();
            $days = 0;
            $worked = 30;
            $per_day = $user->base_salary / 30;
            $free = $days - $user->loss_of_pay;
            $free = 0;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = $user->base_salary;
            $basic = round($user->other_allow - $paid * $per_day);
            $current = date('F');
            $date = Carbon::now();
            $salary_month = $date->format('M Y');
        $empl = User::where('id', '=', $user->id)->first();
        $month = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('F');
        $mon = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('M Y');
        return view('hr.slip', compact('empl', 'leave', 'days', 'worked', 'days', 'free', 'paid', 'ded', 'earn', 'basic', 'month', 'salary_month'));
    }

    public function salary_email()
    {
        $user = User::where('employee_id', '=', 'SK0005')->first();
        $send_email = $user->email;
        // $send_email = "midhun@skiloratech.com";
        $doc = "Salary Slip - Dec 2021";
        $employee = $user;
        $data=array('to'=>$send_email,'doc'=>$doc,'employee'=>$employee);

                Mail::send('emails.salary_slip', $data, function($message) use ($send_email)
                {
                    $message->to($send_email)->subject("Salary Slip Uploaded - Dec 2021");
                });
    }

    public function sal_date()
    {
        $date_split = new LeaveDateSplit;
        $date_split->employee_id = 'SK0002';
        $date_split->employee = '61e66886f46c00001c0072f3';
        $date_split->leave_type = 'casual_leave';
        $date_split->date = '2022-01-27';
        $date_split->save();
        // $date2 = Carbon::today()->toDateString();
        // $myModel->whereBetween('created_at', [$date1, $date2]);

        return "Data Saved";
    }

    public function cmp()
    {
        $employee = User::where('employee_id', '=', 'SK0002')->first();
        $date = Carbon::now();
        $lastMonth =  $date->subMonth()->format('Y-m')."-26";
        $thiMonth = date('Y-m')."-25";
        $days = LeaveDateSplit::where('employee', '=', $employee->id)->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
        $free = LeaveDateSplit::where('employee', '=', $employee->id)->where('leave_type', '<>', 'loss_of_pay')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
        $ded = LeaveDateSplit::where('employee', '=', $employee->id)->where('leave_type', '=', 'loss_of_pay')->whereBetween('date', [$lastMonth." 00:00:00", $thiMonth." 23:59:59"])->count();
        dd($days);
    }

    public function user_update()
    {
        $user = User::where('status', '=', '1')->get();
        foreach ($user as $k => $users) {
            $emp = User::where('employee_id', '=', $user[$k]->employee_id)->first();
            $emp->marriage_leave = 5;
            $emp->marriage_util = 0;
            $emp->marriage_rem = 5;
            $emp->save();
            // $fdate = $user[$k]->joining_date;
            // $tdate = date('Y-m-d');
            // $datetime1 = new DateTime($fdate);
            // $datetime2 = new DateTime($tdate);
            // $interval = $datetime1->diff($datetime2);
            // $days = $interval->format('%a');//now do whatever you like with $days
            // // dd($days);

            // $start_date = new DateTime();
            // $end_date = (new $start_date)->add(new DateInterval("P{$days}D") );
            // $dd = date_diff($start_date,$end_date);
            // $time_at_company = $dd->y." Years ".$dd->m." Months ".$dd->d." Days";
            // if($user[$k]->employee_id=="SK0003"){
            //     $user[$k]->casual_leave = 12;
            //     $user[$k]->casual_util = 1;
            //     $user[$k]->casual_rem = 0;
            //     $user[$k]->medical_leave = 5;
            //     $user[$k]->medical_util = 0;
            //     $user[$k]->medical_rem = 5;
            //     $user[$k]->paternity_leave = 3;
            //     $user[$k]->paternity_util = 0;
            //     $user[$k]->paternity_rem = 3;
            //     $user[$k]->bereavement_leave = 5;
            //     $user[$k]->bereavement_util = 0;
            //     $user[$k]->bereavement_rem = 5;
            //     $user[$k]->loss_of_pay = 0;
            //     $user[$k]->loss_util = 0;
            //     $user[$k]->comp_off = 0;
            //     $user[$k]->comp_util = 0;
            //     $user[$k]->seniority_leave = $dd->y;
            //     $user[$k]->seniority_util = 0;
            //     $user[$k]->seniority_rem = $dd->y;
            //     $user[$k]->save();
            // } elseif ($user[$k]->employee_id=="SK0004") {
            //     $user[$k]->casual_leave = 12;
            //     $user[$k]->casual_util = 1;
            //     $user[$k]->casual_rem = 0;
            //     $user[$k]->medical_leave = 5;
            //     $user[$k]->medical_util = 0;
            //     $user[$k]->medical_rem = 5;
            //     $user[$k]->paternity_leave = 3;
            //     $user[$k]->paternity_util = 0;
            //     $user[$k]->paternity_rem = 3;
            //     $user[$k]->bereavement_leave = 5;
            //     $user[$k]->bereavement_util = 0;
            //     $user[$k]->bereavement_rem = 5;
            //     $user[$k]->loss_of_pay = 0;
            //     $user[$k]->loss_util = 0;
            //     $user[$k]->comp_off = 0;
            //     $user[$k]->comp_util = 0;
            //     $user[$k]->seniority_leave = $dd->y;
            //     $user[$k]->seniority_util = 0;
            //     $user[$k]->seniority_rem = $dd->y;
            //     $user[$k]->save();
            // } elseif ($user[$k]->employee_id=="SK0006") {
            //     $user[$k]->casual_leave = 12;
            //     $user[$k]->casual_util = 1;
            //     $user[$k]->casual_rem = 0;
            //     $user[$k]->medical_leave = 5;
            //     $user[$k]->medical_util = 0;
            //     $user[$k]->medical_rem = 5;
            //     $user[$k]->paternity_leave = 3;
            //     $user[$k]->paternity_util = 0;
            //     $user[$k]->paternity_rem = 3;
            //     $user[$k]->bereavement_leave = 5;
            //     $user[$k]->bereavement_util = 0;
            //     $user[$k]->bereavement_rem = 5;
            //     $user[$k]->loss_of_pay = 0;
            //     $user[$k]->loss_util = 0;
            //     $user[$k]->comp_off = 0;
            //     $user[$k]->comp_util = 0;
            //     $user[$k]->seniority_leave = $dd->y;
            //     $user[$k]->seniority_util = 0;
            //     $user[$k]->seniority_rem = $dd->y;
            //     $user[$k]->save();
            // } elseif ($user[$k]->employee_id=="SK0017") {
            //     $user[$k]->casual_leave = 12;
            //     $user[$k]->casual_util = 1;
            //     $user[$k]->casual_rem = 0;
            //     $user[$k]->medical_leave = 5;
            //     $user[$k]->medical_util = 0;
            //     $user[$k]->medical_rem = 5;
            //     $user[$k]->paternity_leave = 3;
            //     $user[$k]->paternity_util = 0;
            //     $user[$k]->paternity_rem = 3;
            //     $user[$k]->bereavement_leave = 5;
            //     $user[$k]->bereavement_util = 0;
            //     $user[$k]->bereavement_rem = 5;
            //     $user[$k]->loss_of_pay = 0;
            //     $user[$k]->loss_util = 0;
            //     $user[$k]->comp_off = 0;
            //     $user[$k]->comp_util = 0;
            //     $user[$k]->seniority_leave = $dd->y;
            //     $user[$k]->seniority_util = 0;
            //     $user[$k]->seniority_rem = $dd->y;
            //     $user[$k]->save();
            // } elseif ($user[$k]->employee_id=="SK0026") {
            //     $user[$k]->casual_leave = 12 ;
            //     $user[$k]->casual_util = 1;
            //     $user[$k]->casual_rem = 0;
            //     $user[$k]->medical_leave = 5;
            //     $user[$k]->medical_util = 0;
            //     $user[$k]->medical_rem = 5;
            //     $user[$k]->maternity_leave = 60;
            //     $user[$k]->maternity_util = 0;
            //     $user[$k]->maternity_rem = 60;
            //     $user[$k]->bereavement_leave = 5;
            //     $user[$k]->bereavement_util = 0;
            //     $user[$k]->bereavement_rem = 5;
            //     $user[$k]->loss_of_pay = 0;
            //     $user[$k]->loss_util = 0;
            //     $user[$k]->comp_off = 0;
            //     $user[$k]->comp_util = 0;
            //     $user[$k]->seniority_leave = $dd->y;
            //     $user[$k]->seniority_util = 0;
            //     $user[$k]->seniority_rem = $dd->y;
            //     $user[$k]->save();
            // } elseif ($user[$k]->employee_id=="SK0030") {
            //     $user[$k]->casual_leave = 12;
            //     $user[$k]->casual_util = 1;
            //     $user[$k]->casual_rem = 0;
            //     $user[$k]->medical_leave = 5;
            //     $user[$k]->medical_util = 1.5;
            //     $user[$k]->medical_rem = 3.5;
            //     $user[$k]->maternity_leave = 60;
            //     $user[$k]->maternity_util = 0;
            //     $user[$k]->maternity_rem = 60;
            //     $user[$k]->bereavement_leave = 5;
            //     $user[$k]->bereavement_util = 0;
            //     $user[$k]->bereavement_rem = 5;
            //     $user[$k]->loss_of_pay = 0;
            //     $user[$k]->loss_util = 0;
            //     $user[$k]->comp_off = 0;
            //     $user[$k]->comp_util = 0;
            //     $user[$k]->seniority_leave = $dd->y;
            //     $user[$k]->seniority_util = 0;
            //     $user[$k]->seniority_rem = $dd->y;
            //     $user[$k]->save();
            // } else {
            //     $user[$k]->casual_leave = 12;
            //     $user[$k]->casual_util = 0;
            //     $user[$k]->casual_rem = 1;
            //     $user[$k]->medical_leave = 5;
            //     $user[$k]->medical_util = 0;
            //     $user[$k]->medical_rem = 5;
            //     if($user[$k]->gender=='M'){
            //         $user[$k]->paternity_leave = 3;
            //         $user[$k]->paternity_util = 0;
            //         $user[$k]->paternity_rem = 3;
            //     } elseif ($user[$k]->gender=='F') {
            //         $user[$k]->maternity_leave = 60;
            //         $user[$k]->maternity_util = 0;
            //         $user[$k]->maternity_rem = 60;
            //     }
            //     $user[$k]->bereavement_leave = 5;
            //     $user[$k]->bereavement_util = 0;
            //     $user[$k]->bereavement_rem = 5;
            //     $user[$k]->loss_of_pay = 0;
            //     $user[$k]->loss_util = 0;
            //     $user[$k]->comp_off = 0;
            //     $user[$k]->comp_util = 0;
            //     $user[$k]->seniority_leave = $dd->y;
            //     $user[$k]->seniority_util = 0;
            //     $user[$k]->seniority_rem = $dd->y;
            //     $user[$k]->save();
            // }
        }
    }
}

