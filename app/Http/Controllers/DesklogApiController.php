<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DesklogApi;
use App\DesklogUsers;
use App\Models\User;
use Mail;
use Carbon\Carbon;
use App\GroupMember;
use App\Group;

class DesklogApiController extends Controller
{
    public function api()
    {
        $api = DesklogApi::first();
        // $prod = floor($api->productive_time / 60);
        $prod = $api->productive_time;
        $spl = explode(" ", $prod);
        $h = explode("h",$spl[0]);
        $m = explode("m",$spl[1]);
        $s = explode("s",$spl[2]);
        $in = $h[0].":".$m[0].":".$s[0];
        $out = "08:00:00";
        if($in <= $out){
            $diff = date('H:i:s', strtotime($out) - strtotime($in));
        } else {
            $diff = date('H:i:s', strtotime($in) - strtotime($out));
        }
        // $diff = date('H:i:s', strtotime($out) - strtotime($in));

        dd($diff);
        return view('desk_api.index', compact('api'))->with('i', (request()->input('page', 1) - 1) * 30);
    }

    public function create_api()
    {
        return view('desk_api.create_api');
    }



    public function store_api(Request $request)
    {
     /*   $request->validate([
            'api' => 'required',
            'job_id' => 'required',
            'url' => 'required',
            'job_title' => 'required',
            'company_logo' => 'required',
            'category_name' => 'required',
            'job_type' => 'required',
            'category_name' => 'required',
            'description' => 'required',
            'publication_date' => 'required',
            'job_resource' => 'required',
  
        ]);
*/
    
        if($request->input('id')==''){
            $RJob = new Japi;
        }
        else{
            $RJob= Japi::findOrFail($request->input('id'));
           
        }
        $RJob->api =$request->input('api');
        $RJob->name =$request->input('name');
        $RJob->prameter =$request->input('prameter');
        $RJob->job_id =$request->input('job_id');
        $RJob->url = $request->input('url');;
        $RJob->slug = $request->input('company_slug');
        $RJob->job_title = $request->input('job_title');
        $RJob->company_name = $request->input('company_name'); 
        $RJob->company_slug = $request->input('company_slug'); 
        $RJob->company_logo = $request->input('company_logo'); 
        $RJob->category_name = $request->input('category_name');
        $RJob->job_type = $request->input('job_type');
        $RJob->tags =$request->input('tags');
        $RJob->required_location = $request->input('required_location');
        $RJob->salary = $request->input('salary');
        $RJob->description = $request->input('description');
        $RJob->publication_date = $request->input('publication_date');
        $RJob->job_resource =$request->input('job_resource'); 
        $RJob->save();  
    
       
        return redirect()->route('admin.api.index')
            ->with('success', 'API created successfully.');
    }


    public function load_api()
    {
       $employee= User::get();
       $yesterday = Carbon::yesterday()->format('d-m-Y');
       $y = date('Y-m-d', strtotime($yesterday));
       $ch =  "https://api.desklog.io/api/v1/app_usage_attentance?appKey=neal1wck6xr3p23anjmstjhnrpqr5v6iefw14bbm&date=".$yesterday;
       $get  = curl_init();
       curl_setopt($get, CURLOPT_URL, $ch);
       curl_setopt($get, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($get, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($get, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       curl_setopt($get, CURLOPT_CONNECTTIMEOUT, 5);
       curl_setopt($get, CURLOPT_TIMEOUT, 3);
       curl_setopt($get, CURLOPT_HTTPHEADER, array('Accept: application/json'));
       $getapi = curl_exec($get);
       $getapi = json_decode($getapi,true);
        $parameter="data";
           $prsvr =  $getapi[$parameter];

        // dd($prsvr);
        // exit();
        // $prsvr = $prsvr->where('created_at','=', Carbon::yesterday())->orWhere('created_at','=', Carbon::today())->orWhere('pub_date','=', Carbon::yesterday())->orWhere('pub_date','=', Carbon::today())->orWhere('publication_date','=', Carbon::yesterday())->orWhere('publication_date','=', Carbon::today())->orWhere('pubDate','=', Carbon::yesterday())->orWhere('pubDate','=', Carbon::today())->get();
        // if($prsvr==null){
        //     Artisan::call('config:cache');
        //     return redirect()->route('admin.api.index')
        //     ->with('success', 'No data to fetch.');
        // }
        foreach($prsvr as $apiitem){
            $emp = User::where('email','=', $apiitem['email'])->first();
            if(isset($emp)){
                $emp_id = $emp->employee_id;
            } else{
                $emp_id = '';
            }
            $RJob = new DesklogApi;
            $RJob->desklog_id = @$apiitem['id'];
            $RJob->employee_id = $emp_id;
            if($apiitem['name']!=''){
                $RJob->name =  @$apiitem['name'];
            } else {
                $RJob->name =  @$emp->name;
            }
            $RJob->email =@$apiitem['email'];
            $RJob->arrival_at =  @$apiitem['arrival_at'];
            $RJob->at_work = @$apiitem['at_work'];
            $RJob->productive_time = @$apiitem['productive_time'];
            $RJob->idle_time = @$apiitem['idle_time'];
            $RJob->private_time =@$apiitem['private_time'];
            $RJob->total_time_allocated = @$apiitem['total_time_allocated'];
            $RJob->total_time_spended = @$apiitem['total_time_spended'];
            $RJob->time_zone = @$apiitem['time_zone'];
            $RJob->app_and_os = @$apiitem['app_and_os'];
            $RJob->publication_date = $yesterday;
            $RJob->save();  

            if(isset($emp)){
            $g = GroupMember::orderBy('created_at', 'DESC')->where('employee_id', '=', $emp->id)->whereNull('manager')->orWhere('manager', '<>', 1)->first();
            if(isset($g)){
            $gr = GroupMember::where('group_id', '=', $g->group_id)->where('manager', '=', 1)->first();
            $gp = Group::where('id', '=', $g->group_id)->first();
            $gm = User::where('id', '=', $gr->employee_id)->first();
            $RJob->group = $gp->id;
            $RJob->group_manager = $gm->id;
            $RJob->save();
            // dd($gm);
            // exit();
            } else {
                $gm = User::where('id', '=', $emp->hr_id)->first();
                $RJob->group_manager = $hr->id;
                $RJob->save();
            }
        }
            
            $emp_name = $RJob->name;
            // $send_email = $RJob->email;
            $productive = $RJob->productive_time;
            $send_email = "midhun@skiloratech.com";
            $prod = $apiitem['productive_time'];
            if($prod != 'NA'){
            $spl = explode(" ", $prod);
            $h = explode("h",$spl[0]);
            $m = explode("m",$spl[1]);
            $s = explode("s",$spl[2]);
            $in = $h[0].":".$m[0].":".$s[0];
            $out = "08:00:00";
            if($in <= $out){
                $diff = date('H:i:s', strtotime($out) - strtotime($in));
                // dd($diff);
                // exit();
                $dt = explode(":", $diff);
                $RJob->deficit_time = $dt[0]."h ".$dt[1]."m ".$dt[2]."s";
                $RJob->save();
                $data=array('emp_name'=>$emp_name,'diff'=>$diff,'to'=>$send_email,'productive'=>$productive,'dth'=>$dt[0],'dtm'=>$dt[1],'dts'=>$dt[2],'yesterday'=>$yesterday);

                Mail::send('emails.desk_def', $data, function($message) use ($send_email, $RJob, $yesterday)
                {
                $message->to($send_email)->subject("Desklog Time Report - ".$RJob->name." - ".$yesterday);
                });
            } else {
                $diff = date('H:i:s', strtotime($in) - strtotime($out));
                // dd($diff);
                // exit();
                $dt = explode(":", $diff);
                $RJob->gain_time = $dt[0]."h ".$dt[1]."m ".$dt[2]."s";
                $RJob->save();
                $data=array('emp_name'=>$emp_name,'diff'=>$diff,'to'=>$send_email,'productive'=>$productive,'dth'=>$dt[0],'dtm'=>$dt[1],'dts'=>$dt[2],'yesterday'=>$yesterday);

                Mail::send('emails.desk_gain', $data, function($message) use ($send_email, $RJob, $yesterday)
                {
                $message->to($send_email)->subject("Desklog Time Report - ".$RJob->name." - ".$yesterday);
                });
            }
        } else {
            $RJob->deficit_time = "08h 00m 00s";
            $RJob->save();
            $data=array('emp_name'=>$emp_name,'to'=>$send_email,'productive'=>$productive,'dth'=>'08','dtm'=>'00','dts'=>'00','yesterday'=>$yesterday);

                Mail::send('emails.desk_def', $data, function($message) use ($send_email, $RJob, $yesterday)
                {
                $message->to($send_email)->subject("Desklog Time Report - ".$RJob->name." - ".$yesterday);
                });
        }
        
        }

        $man = GroupMember::where('manager', '=', 1)->get();
        foreach($man as $k => $mans){
            $us = User::where('id', '=', $man[$k]->employee_id)->first();
            $grp = Group::where('id', '=', $man[$k]->group_id)->first();
            $yest = Carbon::yesterday()->format('d-m-Y');
            $desk = DesklogApi::where('group_manager', '=', $us->id)->where('publication_date', '=', $yest)->get();
            // $mans->desk = $desk;
            $send_email =  $us->email;

            // $send_email = "midhun@skiloratech.com";
            $i = 0;

            $data=array('us'=>$us,'desk'=>$desk,'grp'=>$grp,'to'=>$send_email,'yesterday'=>$yesterday,'i'=>$i);

                Mail::send('emails.manager_list', $data, function($message) use ($send_email, $grp, $yesterday)
                {
                $message->to($send_email)->cc(['vinay@skiloratech.com','nikhil@skiloratech.com','hr@skiloratech.com'])->subject("Desklog Team Report - ".$grp->group_name." - ".$yesterday);
                });
        }

        

        $em = ['vinay@skiloratech.com','nikhil@skiloratech.com','hr@skiloratech.com','sagar@skiloratech.com','roshan@skiloratech.com'];

        foreach ($em as $k => $ems) {
            $yest_day = Carbon::yesterday()->format('d-m-Y');
        $desk_users = DesklogApi::where('publication_date', '=', $yesterday)->get();
        if($ems == 'vinay@skiloratech.com'){
            $hname = "Vinay Prasad";
        } elseif ($ems == 'nikhil@skiloratech.com') {
            $hname = "Nikhil Raju";
        } elseif ($ems == 'hr@skiloratech.com') {
            $hname = "Bindi Shah";
        } elseif ($ems == 'sagar@skiloratech.com') {
            $hname = "Sagar Khan";
        } elseif ($ems == 'roshan@skiloratech.com') {
            $hname = "Roshan Elizabeth Mathew";
        }
            $send_email =  $ems;
            $i = 0;

        $data=array('desk_users'=>$desk_users,'hname'=>$hname,'to'=>$send_email,'yesterday'=>$yesterday,'i'=>$i);

            Mail::send('emails.hr_list', $data, function($message) use ($send_email, $yesterday)
            {
                $message->to($send_email)->subject("Employee Timesheet - ".$yesterday);
            });
        }
        



        // dd($diff);
        // exit();
        // $api->last_fetch = date('d M Y H:i:s', strtotime(Carbon::now()));
        // $api->save();
        return 'API Fetched';

    }

    public function desklog_users()
    {
        $ch =  "https://api.desklog.io/api/v1/all_users?appKey=neal1wck6xr3p23anjmstjhnrpqr5v6iefw14bbm";
       $get  = curl_init();
       curl_setopt($get, CURLOPT_URL, $ch);
       curl_setopt($get, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($get, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($get, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       curl_setopt($get, CURLOPT_CONNECTTIMEOUT, 5);
       curl_setopt($get, CURLOPT_TIMEOUT, 3);
       curl_setopt($get, CURLOPT_HTTPHEADER, array('Accept: application/json'));
       $getapi = curl_exec($get);
       $getapi = json_decode($getapi,true);
        $parameter="data";
           $prsvr =  $getapi[$parameter];

        // dd($prsvr);
        // exit();
        // $prsvr = $prsvr->where('created_at','=', Carbon::yesterday())->orWhere('created_at','=', Carbon::today())->orWhere('pub_date','=', Carbon::yesterday())->orWhere('pub_date','=', Carbon::today())->orWhere('publication_date','=', Carbon::yesterday())->orWhere('publication_date','=', Carbon::today())->orWhere('pubDate','=', Carbon::yesterday())->orWhere('pubDate','=', Carbon::today())->get();
        // if($prsvr==null){
        //     Artisan::call('config:cache');
        //     return redirect()->route('admin.api.index')
        //     ->with('success', 'No data to fetch.');
        // }
        foreach($prsvr as $apiitem){
            $emp = User::where('email','=', $apiitem['email'])->first();
            if(isset($emp)){
                $emp_id = $emp->employee_id;
            } else{
                $emp_id = '';
            }
            $RJob = new DesklogUsers;
            $RJob->desklog_id = @$apiitem['id'];
            $RJob->employee_id = $emp_id;
            if($apiitem['name']!=''){
                $RJob->name =  @$apiitem['name'];
            } else {
                $RJob->name =  @$emp->name;
            }
            $RJob->email =@$apiitem['email'];
            $RJob->team_id =  @$apiitem['team_id'];
            $RJob->team_name = @$apiitem['team_name'];
            $RJob->role = @$apiitem['role'];
            $RJob->is_online = @$apiitem['is_online'];
            $RJob->app_and_os = @$apiitem['app_and_os'];
            $RJob->save();  
        
        }
        // $api->last_fetch = date('d M Y H:i:s', strtotime(Carbon::now()));
        // $api->save();
        return 'Desklog Users API Fetched';
    }
}
