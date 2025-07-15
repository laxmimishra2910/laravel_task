<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use SoftDeletes, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'email', 'phone', 'position', 'salary', 'photo','tenant_id'
    ];
    public function tenant()
{
    return $this->belongsTo(Tenant::class);
}
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function projects()
{
    return $this->belongsToMany(Project::class);
}

    public function feedbacks()
{
    return $this->hasMany(Feedback::class);
}


        

    protected static function booted()
    {
       static::creating(function ($employee) {

        if (!$employee->id) {
            $employee->id = (string) Str::uuid();
        }
        
    if (app()->bound('tenant_id')) {
        $employee->tenant_id = app('tenant_id');
    }
});


    static::addGlobalScope('tenant', function ($query) {
    if (app()->bound('tenant_id')) {
        $query->where('tenant_id', app('tenant_id'));
    }
});
        // Event: retrieved
        static::retrieved(function ($employee) {
            Log::info("Employee retrieved: {$employee->id}");
        });

        // Event: creating
        // static::creating(function ($employee) {
        //     $employee->id = (string) Str::uuid(); // Auto-generate UUID
        //     Log::info("Employee is being created with ID: {$employee->id}");
        // });

        // Event: created
        static::created(function ($employee) {
            Log::info("Employee created: {$employee->id}");
        });

        // Event: saving (before create or update)
        static::saving(function ($employee) {
            Log::info("Employee saving: {$employee->id}");
        });

        // Event: saved (after create or update)
        static::saved(function ($employee) {
            Log::info("Employee saved: {$employee->id}");
        });

        // Event: updating
        static::updating(function ($employee) {
            Log::info("Employee is being updated: {$employee->id}");
        });

        // Event: updated
        static::updated(function ($employee) {
            Log::info("Employee updated: {$employee->id}");
        });

        // Event: deleting
        static::deleting(function ($employee) {
            Log::warning("Employee is being deleted: {$employee->id}");
        });

        // Event: deleted
        static::deleted(function ($employee) {
            Log::warning("Employee deleted: {$employee->id}");
        });

        // Event: restoring (for soft deletes)
        static::restoring(function ($employee) {
            Log::notice("Employee is being restored: {$employee->id}");
        });

        // Event: restored
        static::restored(function ($employee) {
            Log::notice("Employee restored: {$employee->id}");
        });
    }
}
