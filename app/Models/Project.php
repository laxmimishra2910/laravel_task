<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{

     protected $fillable = [
        'project_name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];
    
}
