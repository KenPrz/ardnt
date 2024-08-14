<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\User;
class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();

        $users->each(function ($user) use ($users) {
            $toFollow = $users->where('id', '!=', $user->id)
                ->filter(function ($potentialFollow) use ($user) {
                    // Check if the user is not already following the potential user
                    return !$user->following()->where('follower_id', $potentialFollow->id)
                        ->exists();
                })
                ->random(rand(2, 5))
                ->pluck('id');
            
            $user->following()->attach($toFollow);
        });
        
    }
}
