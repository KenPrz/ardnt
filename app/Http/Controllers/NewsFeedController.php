<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Theme;
use App\Models\User;
use App\Models\UserFollower;
use Inertia\Inertia;

class NewsFeedController extends Controller
{
    /**
     * Display the news feed page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $user = auth()->user();

        // Get IDs of the followers of the authenticated user
        $followerIds = UserFollower::where('user_id', $user->id)
            ->where('users.deleted_at', null)
            ->join('users', 'users.id', '=', 'user_follower.follower_id')
            ->pluck('follower_id')
            ->toArray();

        $followerCount = count($followerIds);

        // Define thresholds for follower count
        $smallFollowerThreshold = 5; // Adjust this value as needed

        if ($followerCount == 0) {
            // Case: User has zero followers
            $posts = $this->getPublicPosts();
        } elseif ($followerCount <= $smallFollowerThreshold) {
            // Case: User has a small number of followers
            $posts = $this->getPublicPosts();
        } else {
            // Case: User has a regular number of followers
            $posts = $this->getAllPosts($followerIds);
        }

        // Check if each post is liked by the authenticated user
        foreach ($posts as $post) {
            $post->is_liked_by_user = $post->isLikedByUser($user->id);
        }

        return Inertia::render('Feed/NewsFeed', [
            'posts' => $posts,
            'followRecommendations' => $this->getRecommendedFollowers($user->id),
            'themes' => Theme::all(),
            'hasMorePages' => $posts->hasMorePages(),
            'nextPageUrl' => $posts->nextPageUrl(),
        ]);
    }

    /**
     * Retrieves recommended followers for a user.
     *
     * @param  int  $user_id  The ID of the user.
     * @return \Illuminate\Support\Collection A collection of recommended followers.
     */
    private function getRecommendedFollowers($user_id)
    {
        $follow_recommendations = User::select('id', 'first_name', 'last_name', 'avatar', 'handle')
            ->whereNotIn('id', function ($query) use ($user_id) {
                $query->select('user_id')
                    ->from('user_follower')
                    ->where('follower_id', $user_id);
            })->where('id', '!=', $user_id)
            ->limit(5)
            ->get();

        return $follow_recommendations;
    }

    /**
     * Retrieve public posts with related data.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getPublicPosts()
    {
        return Post::where('is_public', true)
            ->withRelationsAndCounts()
            ->latest('created_at')
            ->paginate(10);
    }

    /**
     * Retrieve all posts from the database based on the given follower IDs.
     *
     * @param  array  $followerIds  The IDs of the followers.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of posts.
     */
    private function getAllPosts($followerIds)
    {
        return Post::whereIn('user_id', $followerIds)
            ->orWhere('is_public', true)
            ->withRelationsAndCounts()
            ->latest()
            ->paginate(10);
    }
}
