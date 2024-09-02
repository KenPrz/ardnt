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
            'avatars/pfp0.jpg',
            'avatars/pfp1.jpg',
            'avatars/pfp2.jpg',
            'avatars/pfp3.jpg',
            'avatars/pfp4.jpg',
            'avatars/pfp5.jpg',
            'avatars/pfp6.jpg',
            'avatars/pfp7.jpg',
            'avatars/pfp8.jpg',
            'avatars/pfp9.jpg',
            'avatars/pfp10.jpg',
            'avatars/pfp11.jpg',
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
