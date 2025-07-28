<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\LogsModelEvents;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Concerns\HasUuids;



class Feedback extends Model
{       
    use HasFactory,LogsModelEvents,HasUuids ;
    
     protected $keyType = 'string'; // Because UUIDs are strings
    public $incrementing = false;  // UUIDs are not auto-incremented
      
        protected $fillable = ['employee_id','client_name', 'email', 'message', 'rating' ];
        public function employee()
{
    return $this->belongsTo(Employee::class);
}


}
