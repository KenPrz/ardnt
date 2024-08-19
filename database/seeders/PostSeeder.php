<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use app\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Create posts for each user
        $users->each(function ($user) {
            $user->posts()->saveMany(Post::factory()->count(rand(1, 10))->make());
        });

        $posts = Post::all();

        $posts->each(function ($post) use ($users) {
            if ($post->is_public) {
                // Public posts can be liked by any random users
                $randomUsers = $users->random(rand(1, 5)); // 1-5 users randomly like the post
            } else {
                // Non-public posts can only be liked by the user's followers
                $userFollowers = $post->user->followers;
                $randomUsers = $userFollowers->isNotEmpty()
                    ? $userFollowers->random(rand(1, min(5, $userFollowers->count())))
                    : collect(); // No likes if no followers
            }

            // Assign likes
            $randomUsers->each(function ($user) use ($post) {
                $user->likedPosts()->attach($post->id);
            });

            // Generate comments based on the visibility
            if ($post->is_public) {
                // For public posts
                $randomUsers = $users->random(rand(1,5));

                foreach ($randomUsers as $user) {
                    Comment::factory()->create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                    ]);
                }
            } else {
                // For non-public posts
                $userFollowers = $post->user->followers;
                if ($userFollowers->isNotEmpty()) {
                    foreach ($userFollowers as $user) {
                        Comment::factory()->create([
                            'user_id' => $user->id,
                            'post_id' => $post->id,
                        ]);
                    }
                }
            }
        });
    }
}
