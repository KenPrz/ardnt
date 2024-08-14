<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $num_of_users = User::count();
        $num_of_posts = Post::count();
        $num_of_themes = Theme::count();
        $isShared = $num_of_posts > 0 && $this->faker->boolean(40); // 40% chance of being a shared post

        return [
            'user_id' => $this->faker->numberBetween(1, $num_of_users),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'theme_id' => rand(1, $num_of_themes),
            'is_public' => $this->faker->boolean(50), // 50% chance of being public
            'cover_image' => $this->faker->imageUrl($width = rand(100, 1000), $height = rand(100, 1000)),
            'is_shared' => $isShared,
            'shared_post_id' => $isShared ? $this->faker->numberBetween(1, $num_of_posts) : null, // Assign a valid post ID if it's a shared post
        ];
    }
}
