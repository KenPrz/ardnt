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
            'prose',
            'poetry',
            'fiction',
            'non-fiction',
            'drama',
            'comedy',
            'tragedy',
            'romance',
            'mystery',
            'thriller',
            'horror',
            'fantasy',
            'science fiction',
        ];

        foreach ($themes as $theme) {
            Theme::create(['name' => $theme]);
        }
    }
}
