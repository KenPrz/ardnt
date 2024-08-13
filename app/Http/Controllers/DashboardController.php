<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Theme;
use App\Models\UserFollower;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $followerIds = UserFollower::where("user_id", $user->id)
            ->where('users.deleted_at', null)
            ->join('users', 'users.id', '=', 'user_follower.follower_id')
            ->pluck('follower_id')
            ->toArray();

        $posts = Post::whereIn('user_id', $followerIds)
            ->with('user', 'comments.user', 'likedByUsers', 'originalPost', 'shares')
            ->latest()
            ->paginate(10);
            
        // Check if each post is liked by the authenticated user
        foreach ($posts as $post) {
            $post->is_liked_by_user = $post->isNotLikedByUser($user->id);
        }
        $follow_recommendations = UserFollower::where('user_id', '!=', auth()->user()->id)
                                ->whereNotIn('follower_id', $followerIds)
                                ->inRandomOrder()
                                ->limit(8)
                                ->get();
        return Inertia::render('Feed/NewsFeed', [
            'posts' => $posts,
            'followRecommendations' => $follow_recommendations,
            'themes' => Theme::all(),
        ]);
    }
}
