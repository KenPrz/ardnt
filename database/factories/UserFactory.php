<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $avatars = [
            'avatars/pfp0.jpeg',
            'avatars/pfp1.jpeg',
            'avatars/pfp2.jpeg',
            'avatars/pfp3.jpeg',
            'avatars/pfp4.jpeg',
            'avatars/pfp5.jpeg',
            'avatars/pfp6.jpeg',
            'avatars/pfp7.jpeg',
            'avatars/pfp8.jpeg',
            'avatars/pfp9.jpeg',
            'avatars/pfp10.jpeg',
            'avatars/pfp11.jpeg'
        ];          
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'handle' => fake()->unique()->userName(),
            'quote' => fake()->sentence(),
            'website' => fake()->url(),
            'avatar' => $this->faker->randomElement($avatars),
            'twitter' => fake()->userName(),
            'instagram' => fake()->userName(),
            'facebook' => fake()->userName(),
            'linkedin' => fake()->userName(),
            'medium' => fake()->userName(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Use bcrypt to hash the password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
