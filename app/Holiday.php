<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Holiday extends Model
{
    protected $collection = 'holidays';
    protected $fillable = [
        'date','day', 'holiday', 'year', 'description'
    ];
  /*  protected $searchable = [

        'columns' => [

            'industries.industry_name' => 10,


        ]

    ];*/
}
