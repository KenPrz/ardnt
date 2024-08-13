<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    
        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'post_id' => $this->faker->numberBetween(1, Post::count()),
            'content' => $this->faker->paragraph,
        ];
    }
        
}
