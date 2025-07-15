<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;



class Department extends Model
{
    use HasFactory;
    protected $keyType = 'string';
public $incrementing = false;
      protected $fillable =['id', 'name', 'tenant_id'];

      protected static function booted()
{
    static::creating(function ($model) {
        $model->id = (string) Str::uuid();
    });
}

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
       protected static function newFactory()
    {
        return DepartmentFactory::new();
    }

}
