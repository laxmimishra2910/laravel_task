<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsModelEvents;
use App\Models\Scopes\TenantScope;



class Employee extends Model
{
      use HasFactory, SoftDeletes, LogsModelEvents;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'email', 'phone', 'position', 'salary', 'photo','department_id',
    ];
   
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

  public function projects()
{
    return $this->belongsToMany(Project::class, 'employee_project', 'employee_id', 'project_id')
        ->withPivot(['assigned_at', 'assigned_by']) // Optional: if you have these fields
        ->withTimestamps(); // Optional: if using created_at/updated_at
}


    public function feedbacks()
{
    return $this->hasMany(Feedback::class);
}



}
