<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Theme;
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
        $followerIds = UserFollower::where("user_id", $user->id)
            ->where('users.deleted_at', null)
            ->join('users', 'users.id', '=', 'user_follower.follower_id')
            ->pluck('follower_id')
            ->toArray();

        // Fetch posts from the followers
        $posts = Post::whereIn('user_id', $followerIds)
            ->with('user', 'comments.user', 'likedByUsers', 'originalPost', 'shares')
            ->latest()
            ->paginate(10);

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
     * @param int $user_id The ID of the user.
     * @param array $followerIds An array of follower IDs.
     * @return \Illuminate\Support\Collection A collection of recommended followers.
     */
    private function getRecommendedFollowers($user_id, $followerIds) {
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
    

}
