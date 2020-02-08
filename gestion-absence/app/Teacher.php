<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name', 'email', 'phone','CIN','last_name','type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public static function count(){
    	return Teacher::count();
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
