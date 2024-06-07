<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SalarySlip extends Model
{
    protected $collection = 'salary_slips';
    protected $fillable = [
        'employee_id','user_id', 'path', 'salary_id', 'earned_leaves'
    ];
  /*  protected $searchable = [

        'columns' => [

            'industries.industry_name' => 10,


        ]

    ];*/


}
