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
     * This method returns an instance of the BelongsToMany class, which represents the relationship
     * between the Post model and the User model. The relationship is defined through the 'likes' table.
     * The 'likes' table is used to store the many-to-many relationship between posts and users.
     * The 'likedByUsers' method allows you to retrieve the users who have liked a particular post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    /**
     * Check if the post is not liked by a specific user.
     *
     * @param  int  $user_id  The ID of the user.
     * @return bool Returns true if the post is not liked by the user, false otherwise.
     */
    public function isNotLikedByUser($user_id): bool
    {
        return ! $this->likedByUsers->contains($user_id);
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
}
