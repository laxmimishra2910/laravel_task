<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 use Illuminate\Support\Facades\Auth;
 use App\Traits\LogsModelEvents;
 use App\Models\EmployeeProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
  
    use HasFactory,LogsModelEvents;

    public $incrementing = false; // ✅ Disable auto-increment
    protected $keyType = 'string'; // ✅ UUIDs are strings

    protected static function boot()
    {
        parent::boot();

        // ✅ Auto-generate UUID on creating
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
     protected $fillable = [
        'project_name',
        'description',
        'status',
        'start_date',
        'end_date',
       
     
    ];

  public function employees()
{
    return $this->belongsToMany(Employee::class, 'employee_project', 'project_id', 'employee_id')
        ->withPivot(['assigned_at', 'assigned_by'])
        ->withTimestamps();
}


    
    
}
