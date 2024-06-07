<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Salary extends Model
{
    protected $collection = 'salaries';
    protected $fillable = [
        'employee','working_days', 'worked_days', 'leave_taken', 'earned_leaves', 'loss_of_pay', 'salary', 'leave_deduction', 'earnings'
    ];
  /*  protected $searchable = [

        'columns' => [

            'industries.industry_name' => 10,


        ]

    ];*/


}
