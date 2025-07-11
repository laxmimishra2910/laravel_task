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
      

 

}
