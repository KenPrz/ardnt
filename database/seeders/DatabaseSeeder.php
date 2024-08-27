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

        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        User::factory(50)->create();

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
