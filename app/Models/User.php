<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'handle',
        'quote',
        'website',
        'avatar',
        'twitter',
        'instagram',
        'facebook',
        'linkedin',
        'medium',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follower', 'follower_id', 'user_id')
            ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follower', 'user_id', 'follower_id')
            ->withTimestamps();
    }
    public function isFollowedByMe()
    {
        return $this->followers->contains('id', auth()->id());
    }

    /**
     * Check if the user follows another user.
     *
     * @param int $user_id The ID of the user to check if the current user follows.
     * @return bool Returns true if the user follows the specified user, otherwise false.
     */
    public function isFollowing($user_id)
    {
        return $this->following()->where('user_id', $user_id)
            ->exists();
    }

    /**
     * Check if the user is followed by another user.
     *
     * @param int $user_id The ID of the user to check if they are following.
     * @return bool Returns true if the user is followed by the specified user, otherwise false.
     */
    public function isFollowed($user_id)
    {
        return $this->followers()->where('follower_id', $user_id)->exists();
    }
}
