<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 use App\Traits\HasAllRelations;
 use App\Relationships\HasOneThroughPivot;

class Profile extends Model
{
    use HasFactory,HasAllRelations;

    protected $fillable = ['user_id', 'phone', 'address', 'status'];

    public function profile()
    {
        return new HasOneThroughPivot(
            app(Profile::class)->newQuery(),
            $this,
            'user_profile',
            'user_id',
            'profile_id'
        );
    }
}
