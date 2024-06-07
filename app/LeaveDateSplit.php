<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LeaveDateSplit extends Model
{
    protected $collection = 'leave_date_splits';
    protected $fillable = [
        'employee_id','employee','leave_type','date'
    ];
  /*  protected $searchable = [

        'columns' => [

            'industries.industry_name' => 10,


        ]

    ];*/
}
