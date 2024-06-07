<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','company', 'employee_id', 'email', 'phone','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_tillken',
    ];

public function setEmailAttribute($value)
{
    $this->attributes['email'] = strtolower($value);
}   

public function getEmailAttribute($value)
{
    return strtolower($value);
}

}
