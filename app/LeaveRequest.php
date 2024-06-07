<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LeaveRequest extends Model
{
    protected $collection = 'leave_requests';
    protected $fillable = [
        'employee_id','user_id','from_date','to_date', 'leave_type', 'leave_reason'
    ];
  /*  protected $searchable = [

        'columns' => [

            'industries.industry_name' => 10,


        ]

    ];*/


}