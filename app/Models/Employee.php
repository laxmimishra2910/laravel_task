<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsModelEvents;
use App\Traits\HasAllRelations;

class Employee extends Model
{
    use HasFactory, SoftDeletes, LogsModelEvents, HasAllRelations;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'email', 'phone', 'position', 'salary', 'photo',
    ];
   // In App\Models\Employee

// In App\Models\Employee

public function department()
{
    return $this->belongsToMany(Department::class, 'department_employee', 'employee_id', 'department_id')
        ->withPivot(['id', 'created_at', 'updated_at'])
        ->take(1);
}

public function assignToDepartment($departmentId)
{
    // Use syncWithoutDetaching to maintain other relationships if they exist
    $this->department()->syncWithoutDetaching([$departmentId]);
    
}
// Add this accessor to get the first department directly
public function getDepartmentAttribute()
{
    return $this->department()->first();

}

public function projects()
{
    return $this->belongsToMany(Project::class, 'employee_project')
        ->withPivot(['assigned_at', 'assigned_by', 'id'])
        ->withTimestamps();
}

}