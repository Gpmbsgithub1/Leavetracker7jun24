<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Leave_file extends Model
{
    protected $collection = 'leave_files';
    protected $fillable = [
        'path','leave_id', 'file_type', 'user_id', 'company_id'
    ];
  /*  protected $searchable = [

        'columns' => [

            'industries.industry_name' => 10,


        ]

    ];*/
}
