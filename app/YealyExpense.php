<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YealyExpense extends Model
{
   
    protected $collection = 'yearly_expenses';
    protected $fillable = [
        'amount','month','year'
    ];
  /*  protected $searchable = [

        'columns' => [

            'industries.industry_name' => 10,


        ]

    ];*/
}
