<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\LogsFeedback;


class Feedback extends Model
{       
    use HasFactory,LogsFeedback ;
      
        protected $fillable = ['client_name', 'email', 'message', 'rating'];
      
    public function tenant()
         {
             return $this->belongsTo(Tenant::class);
         }
     public function employee()
         {
             return $this->belongsTo(Employee::class);
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
