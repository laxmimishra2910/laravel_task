<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeProject extends Model
{
      protected $table = 'employee_project';

    protected $fillable = [
        'employee_id',
        'project_id',
        'role',
        'assigned_at',
        'assigned_by',
    ];

    public $timestamps = true;
}
