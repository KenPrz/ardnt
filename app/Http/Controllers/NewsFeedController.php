<?php

namespace App\Http\Controllers;

use App\Models\{
    Post,
    Theme,
    UserFollower,
};
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
            $post->is_liked_by_user = $post->isNotLikedByUser($user->id);
        }

        return Inertia::render('Feed/NewsFeed', [
            'posts' => $posts,
            'followRecommendations' => $this->getRecommendedFollowers($user->id, $followerIds),
            'themes' => Theme::all(),
            'hasMorePages' => $posts->hasMorePages(),
            'nextPageUrl' => $posts->nextPageUrl(),
        ]);
    }

    /**
     * Retrieves recommended followers for a user.
     *
     * @param  int  $user_id  The ID of the user.
     * @param  array  $followerIds  An array of follower IDs.
     * @return \Illuminate\Support\Collection A collection of recommended followers.
     */
    private function getRecommendedFollowers($user_id, $followerIds)
    {
        $follow_recommendations = UserFollower::where('user_id', '!=', $user_id)
            ->whereNotIn('follower_id', $followerIds)
            ->with(['follower:id,name,handle,avatar'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($userFollower) {
                return [
                    'user_id' => $userFollower->follower->id,
                    'handle' => $userFollower->follower->handle,
                    'name' => $userFollower->follower->name,
                    'avatar' => $userFollower->follower->avatar,
                ];
            })
            ->unique('user_id'); // Ensure unique 'user_id'

        return $follow_recommendations;
    }

    private function getPublicPosts()
    {
        return Post::where('is_public', true)
            ->with('user', 'comments.user', 'likedByUsers', 'originalPost', 'shares')
            ->latest()
            ->paginate(10);
    }

    private function getAllPosts($followerIds)
    {
        return Post::whereIn('user_id', $followerIds)
            ->orWhere('is_public', true)
            ->with('user', 'comments.user', 'likedByUsers', 'originalPost', 'shares')
            ->latest()
            ->paginate(10);
    }
}
