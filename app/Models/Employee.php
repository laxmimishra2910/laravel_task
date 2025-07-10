<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Employee extends Model
{
    use SoftDeletes , HasFactory;

    public $incrementing=false;
    protected $keyType='String';
    
    protected $fillable=[
        'name','email','phone','position','salary','photo'
    ];
   protected static function booted()
    {
        static::creating(function ($employee) {
            $employee->id = (string) Str::uuid(); // Auto UUID
        });

        static::updating(function ($employee) {
            Log::info("Employee updated: {$employee->id}");
        });

        static::deleting(function ($employee) {
            Log::warning("Employee deleted: {$employee->id}");
        });
    }


}
