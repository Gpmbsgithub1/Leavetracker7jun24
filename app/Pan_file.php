<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pan_file extends Model
{
    
    protected $collection = 'pan_files';
    protected $fillable = [
        'path', 'file_type', 'employee', 'employee_id', 'company_id'
    ];
  /*  protected $searchable = [

        'columns' => [

            'industries.industry_name' => 10,


        ]

    ];*/
}
