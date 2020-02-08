<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absence extends Model
{
    protected $fillable = [
        'justification', 'hours', 'type','date','module_id','student_id'
    ];

}
