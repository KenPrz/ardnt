<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'is_edited',
    ];

    protected $casts = [
        'is_edited' => 'boolean',
    ];

    /**
     * Get the user who owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that the comment belongs to.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public static function canUserComment($userId)
    {
        $key = 'user_comment_count_' . $userId;
        $commentCount = Cache::get($key, 0);
        if ($commentCount >= 20) {
            return false;
        }
        Cache::put($key, $commentCount + 1, now()->addMinutes(5));
        return true;
    }
}
