<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Feedback extends Model
{       
    use HasFactory ;
      
        protected $fillable = ['client_name', 'email', 'message', 'rating'];
      

 

}
