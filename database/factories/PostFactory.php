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

        $htmlContents = [
            '<p>This is the first paragraph with some <strong>bold text</strong>.</p><p>Here\'s the second paragraph, including <em>italic</em> and <s>strikethrough</s> text.</p>',
            '<p>Welcome to my post! This is paragraph one.</p><p>This is the second paragraph with <strong><em>bold and italic</em></strong> text.</p><p>And here\'s a third paragraph for good measure.</p>',
            '<p>Let\'s start with this opening paragraph.</p><p>Now, here\'s our second paragraph with some <strong>important information</strong>.</p><p>And a final thought in the third paragraph, featuring <em>emphasized text</em>.</p>',
            '<p>First paragraph: Introducing the topic of <strong>web development</strong>.</p><p>Second paragraph: It\'s an <em>exciting</em> field with many opportunities.</p><p>Third paragraph: Always stay updated with <s>old</s> new technologies.</p>',
            '<p>Opening statement: Here\'s an interesting <strong>fact</strong>.</p><p>The details: Did you know that the average person spends <em>6 months</em> of their life waiting for traffic lights to change?</p>',
        ];

        return [
            'user_id' => $this->faker->numberBetween(1, $num_of_users),
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->randomElement($htmlContents),
            'theme_id' => rand(1, $num_of_themes),
            'is_public' => $this->faker->boolean(50),
            'cover_image' => $this->faker->imageUrl($width = rand(100, 1000), $height = rand(100, 1000)),
            'is_shared' => $isShared,
            'shared_post_id' => $isShared ? $this->faker->numberBetween(1, $num_of_posts) : null, // Assign a valid post ID if it's a shared post
        ];
    }
}
