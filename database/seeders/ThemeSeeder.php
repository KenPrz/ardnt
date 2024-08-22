<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            'Prose',
            'Poetry',
            'Fiction',
            'Non-fiction',
            'Drama',
            'Comedy',
            'Tragedy',
            'Romance',
            'Mystery',
            'Thriller',
            'Horror',
            'Fantasy',
            'Science Fiction',
        ];

        foreach ($themes as $theme) {
            Theme::create(['name' => $theme]);
        }
    }
}
