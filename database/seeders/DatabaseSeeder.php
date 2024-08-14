<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users first
        User::factory(100)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Optionally: Create themes if they are used in posts
        $this->call(ThemeSeeder::class);

        // Create posts
        $this->call([
            FollowerSeeder::class,
            PostSeeder::class,
        ]);

        // // Create comments
        // $this->call(CommentSeeder::class);
    }
}
