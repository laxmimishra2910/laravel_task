<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Traits\HasAllRelations;

class Department extends Model
{
    use HasFactory, HasAllRelations;
    
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['name'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

 // In App\Models\Department
public function employees()
{
    return $this->belongsToMany(Employee::class, 'department_employee', 'department_id', 'employee_id')
               ->withTimestamps();
}

    // Add this accessor for counting employees
    public function getEmployeesCountAttribute()
    {
        return $this->employees()->count();
    }
}