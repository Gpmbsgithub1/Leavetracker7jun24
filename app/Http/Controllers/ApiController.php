<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Models\User;

class ApiController extends Controller
{
    public function api(){
        $api='qwedfgrtsrtuvw12hgdi37';
        $id='13s1gdi37';
        $users=array();
        if(Request::input('api')==$api && Request::input('id')==$id){
    //     $date = \Carbon\Carbon::today()->subDays(360);
    //   $d = date('Y-m-d',strtotime("-5 days"));
    //   $activedate=\Carbon\Carbon::parse($d);
        $job=User::where('status', '=', '1')->get();
        foreach($job as $jobitem){
                // $RJobdesc='';
                // $Rcmp = Company::where('id', '=', @$jobitem->company_id)->where('company_active', '=', '1')->first();
                // $Rcareers = Company_career::where('company_id','=',@$Rcmp->id)->first();
                // $url =route('view.company.job', ['company' =>@$Rcmp->slug,'id'=>$jobitem->id]);
                // $company_slug=route('view.company.index', ['company' =>@$Rcmp->slug]);
                // $company_name=@$Rcmp->company_name;
                // $logo='';
                // if(@$Rcareers->career_logo==''){
                //  $logo=url('content/img/profilepik.jpg');
                // }
                // else { 
                //  $logo=asset('storage').'/'.$Rcareers->career_logo;
                // }
                // $skillsitem=array();
                // $skill = Jobskill::where('job_id', '=', @$jobitem->id)->get();
                // $Rskill='';
                // foreach($skill as $skillitem){
                // $sk=Skill::where('id','=',$skillitem->skill_id)->first();
                // if(@$sk->skill_name!=''){ $Rskill .=$sk->skill_name.','; }
                // }
                
                // if($jobitem->jobtype=="1"){
                // $rjtype='Full Time';
                // }
                // if($jobitem->jobtype=="2"){
                // $rjtype='Part Time';    
                // }
                // if($jobitem->jobtype=="3"){
                //  $rjtype='Per Hour';   
                // }
                // if($jobitem->jobtype=="4"){
                //     $rjtype='Contract';   
                // }
                // if($jobitem->jobtype=="5"){
                //     $rjtype='Freelance';   
                // }
    
                // if($jobitem->job_salary_per=='M'){
                //     $Rsalary_per = 'Month';  
                // }
                // if($jobitem->job_salary_per=='D'){
                //     $Rsalary_per = 'Day';  
                // }
                // if($jobitem->job_salary_per=='H'){
                //     $Rsalary_per = 'Hour';  
                // }
    
                // $Rsalary= $jobitem->job_salary_from.' - '.$jobitem->job_salary_upto.' '.$jobitem->job_salary_in.' /'.$Rsalary_per;
                // if($jobitem->job_salary_from==''){
                // $Rsalary = '';
                // }
                // if($jobitem->job_responsibilities_duties!=''){
                // $RJobdesc = $jobitem->job_summery.' </br></br>Responsibilities and Duties</br> '.$jobitem->job_responsibilities_duties;
                // } else {
                //     $RJobdesc = $jobitem->job_summery;
                // }
                /*  $string = htmlentities($RJobdesc, null, 'utf-8');
                     $content = str_replace("&nbsp;", "", $string);
                     $content = html_entity_decode($content);
                     $content=strip_tags($content);
                     $content=preg_replace("/&nbsp;/",'',$content);
                     */
                if($jobitem->hr == 1){
                    $role = 'admin';
                } else {
                    $role = 'user';
                }

                if($jobitem->status == '1'){
                    $status = 'active';
                } else {
                    $status = 'inactive';
                }
        $jobs[]= array('user_id'=>$jobitem->id,'name'=>$jobitem->name,'employee_id'=>$jobitem->employee_id,'email'=>$jobitem->email,'role'=>$role,'status'=>$status,'password'=>$jobitem->password);	
        }
        
    }
    //jobs_api?api=qwedfgrtsrtuvw12sdfb67%20&&%20id=13s1dfb67
    return json_encode($jobs);
    
    }
}
