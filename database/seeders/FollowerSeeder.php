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

        // Each user will follow 2-5 other users
        $users->each(function ($user) use ($users) {
            $toFollow = $users->where('id', '!=', $user->id)->random(rand(2, 5))->pluck('id');
            $user->following()->attach($toFollow);
        });
    }
}
