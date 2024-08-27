<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'theme_id',
        'cover_image',
        'is_public',
        'user_id',
        'is_shared',
        'shared_post_id',
    ];

    protected $casts = [
        'is_shared' => 'boolean',
        'is_public' => 'boolean',
    ];

    protected $appends = ['is_liked_by_user'];

    /**
     * Get the user that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Define a many-to-many relationship between the Post model and the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    /**
     * Check if the post is liked by the currently authenticated user.
     *
     * @return bool
     */
    public function getIsLikedByUserAttribute()
    {
        if (auth()->check()) {
            return $this->likedByUsers->contains(auth()->id());
        }

        return false;
    }

    /**
     * Get the original post that this post belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function originalPost()
    {
        return $this->belongsTo(Post::class, 'shared_post_id');
    }

    /**
     * Define a relationship between the Post model and its shared posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shares()
    {
        return $this->hasMany(Post::class, 'shared_post_id');
    }

    /**
     * Get the theme that the post belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    /**
     * Scope to eager load relations and get counts for comments and likes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRelationsAndCounts($query)
    {
        return $query->with([
            'user',
            'comments' => function ($query) {
                $query->latest('created_at')->take(100);
            },
            'comments.user' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'avatar', 'handle');
            },
            'theme' => function ($query) {
                $query->select('id', 'name');
            },
            'likedByUsers' => function ($query) {
                $query->select('users.id', 'users.first_name', 'users.last_name', 'users.avatar', 'users.handle');
            },
            'originalPost' => function ($query) {
                $query->select('id', 'title', 'content', 'theme_id', 'cover_image', 'is_public', 'user_id', 'is_shared','created_at', 'updated_at')
                    ->with([
                        'user' => function ($query) {
                            $query->select('id', 'handle', 'avatar');
                        },
                        'theme' => function ($query) {
                            $query->select('id', 'name');
                        },
                    ]);
            },
            'shares' => function ($query) {
                $query->select(
                    'id', 
                    'title', 
                    'content', 
                    'theme_id', 
                    'cover_image', 
                    'is_public', 
                    'user_id', 
                    'is_shared', 
                    'shared_post_id'
                )
                ->with([
                    'theme' => function ($query) {
                        $query->select('id', 'name');
                    },
                    'user' => function ($query) {
                        $query->select('id', 'first_name', 'last_name', 'avatar', 'handle');
                    },
                ]);
            }
        ])
        ->withCount(['comments', 'likedByUsers'])
        ->latest('created_at');
    }

}
