<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFollower extends Model
{
    use HasFactory;

    protected $table = 'user_follower';

    protected $fillable = [
        'user_id',
        'follower_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
