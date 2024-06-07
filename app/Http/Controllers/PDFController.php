<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\User;
use App\Salary;
use App\LeaveRequest;
use Carbon\Carbon;
use Storage;

class PDFController extends Controller
{
    public function downloadPDF($eid) 
    {
        $empl = User::where('employee_id', '=', $eid)->first();
        $leave = LeaveRequest::where('employee_id', '=', $eid)->where('fmonth', '=', date('m'))->where('tmonth', '=', date('m'))->where('approve', '=', 1)->get();
        $days = LeaveRequest::where('employee_id', '=', $eid)->where('fmonth', '=', date('m'))->where('tmonth', '=', date('m'))->where('approve', '=', 1)->sum('days');
        // dd($employee);

        if($empl->loss_of_pay>0 && $days>0){
            $worked = 30 - $days;
            $per_day = $empl->base_salary / 30;
            $free = $days - $empl->loss_of_pay;
            $paid = $empl->loss_of_pay;
            $ded = round($paid * $per_day);
            $earn = round($empl->base_salary - $paid * $per_day);
            $basic = round($empl->other_allow - $paid * $per_day);
            } elseif ($empl->loss_of_pay==0 && $days>0){
            $worked = 30 - $days;
            $per_day = $empl->base_salary / 30;
            $free = $days;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = round($empl->base_salary);
            $basic = round($empl->other_allow);
            } elseif ($empl->loss_of_pay==0 && $days==0) {
            $worked = 30 - $days;
            $per_day = $empl->base_salary / 30;
            $free = 0;
            $paid = 0;
            $ded = round($paid * $per_day);
            $earn = round($empl->base_salary - $days * $per_day);
            $basic = round($empl->other_allow - $days * $per_day);
        }
        /*$sal = Salary::where('employee', '=', $employee->employee_id)->where('month', '=', date('m'))->count();
        if($sal<1){
            $salary = new Salary;
            $salary->employee = $employee->employee_id;
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
        } */
        $current = date('F');
        $month = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('F');
        $mon = Carbon::createFromFormat('F-d', "$current-1")->addMonth()->format('M Y');
        $pdf = PDF::loadView('hr.pdf', compact('empl', 'leave', 'days', 'worked', 'days', 'free', 'paid', 'ded', 'earn', 'basic', 'month'));
        
        return $pdf->download('Salary Slip-'.$eid.'-'.$empl->name.'-'.$mon.'.pdf');
    }
}
