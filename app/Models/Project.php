<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{

     protected $fillable = [
        'project_name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    public function employees()
{
    return $this->belongsToMany(Employee::class);
}

    protected static function booted()
{
    static::addGlobalScope('tenant', function ($query) {
        if ($tenantId = app('tenant_id')) {
            $query->where('tenant_id', $tenantId);
        }
    });

    static::creating(function ($employee) {
        $employee->tenant_id = app('tenant_id');
    });
}

    
}
