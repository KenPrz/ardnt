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
        $images = ['img1.png', 'img2.png', 'img3.png', 'img4.png', 'img5.png', 'img6.png', 'img7.png', 'img8.png'];
        $htmlContents = [
            '<p>This is a short post with <strong>bold</strong> and <em>italic</em> text.</p>',
            '<p>Here is a longer post that includes more content. We use <strong>bold text</strong> to highlight key points and <em>italic text</em> to emphasize certain words. This paragraph goes on to provide additional details and context to ensure the reader fully understands the subject matter discussed.</p>',
            '<p>This is the first paragraph of our document. It contains some <strong>bold text</strong> that stands out to the reader.</p><p>Here\'s the second paragraph, which includes <em>italicized text</em> to highlight certain words and <s>strikethrough</s> text to show what has been removed.</p>',
            '<p>Welcome to my post! This is the first paragraph designed to grab your attention.</p><p>The second paragraph contains <strong><em>both bold and italic</em></strong> text to emphasize important points.</p><p>Additionally, here\'s a third paragraph to provide further details and ensure a comprehensive read.</p>',
            '<p>Let\'s begin with this opening paragraph that sets the stage for what\'s to come.</p><p>In the second paragraph, we delve into <strong>some important details</strong> that are crucial for understanding the topic.</p><p>Finally, the third paragraph wraps up with a <em>summary</em> of the key takeaways and thoughts.</p>',
            '<p>The first paragraph introduces the topic of <strong>web development</strong> and its relevance in today\'s tech world.</p><p>The second paragraph describes how it is an <em>exciting</em> field filled with opportunities and innovations.</p><p>In the third paragraph, we discuss the importance of staying updated with <s>outdated</s> new technologies to remain competitive.</p>',
            '<p>Opening statement: Here\'s an intriguing <strong>fact</strong> about human behavior.</p><p>In the following details, did you know that the average person spends <em>up to six months</em> of their life waiting for traffic lights to change?</p><p>This fascinating statistic sheds light on how we experience time in our daily lives.</p>',
        ];
        
        return [
            'user_id' => $this->faker->numberBetween(1, $num_of_users),
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->randomElement($htmlContents),
            'theme_id' => rand(1, $num_of_themes),
            'is_public' => $this->faker->boolean(50),
            'cover_image' => $this->faker->randomElement($images),
            'is_shared' => $isShared,
            'shared_post_id' => $isShared ? $this->faker->numberBetween(1, $num_of_posts) : null,
        ];
    }
}
