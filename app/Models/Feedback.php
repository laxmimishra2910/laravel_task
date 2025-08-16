<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\LogsModelEvents;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\HasAllRelations;


class Feedback extends Model
{       
    use HasFactory,LogsModelEvents,HasUuids,HasAllRelations ;
    
     protected $keyType = 'string'; // Because UUIDs are strings
    public $incrementing = false;  // UUIDs are not auto-incremented
      
        protected $fillable = ['client_name', 'email', 'message', 'rating' ];
        
         public function employee()
    {
        return $this->belongsToMany(\App\Models\Employee::class, 'employee_feedback', 'feedback_id', 'employee_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

}
