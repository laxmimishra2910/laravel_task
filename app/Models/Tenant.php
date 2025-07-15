<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tenant extends Model
{

    use HasFactory;
    protected $fillable = ['name']; 
    
     public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class);
    }
}
