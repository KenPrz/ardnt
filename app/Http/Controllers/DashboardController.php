<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
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
                ->paginate(10)
                ->each(function ($post, $user) {
                    $post->isLikedByUser = $post->likedByUsers->contains($user);
                });
        
        $follow_recommendations = UserFollower::where('user_id', '!=', $user->id)
                                ->whereNotIn('follower_id', $followerIds)
                                ->inRandomOrder()
                                ->limit(8)
                                ->get();
        dd($posts);
        return Inertia::render('Dashboard', [
            'posts' => $posts,
            'followRecommendations' => $follow_recommendations,
        ]);
    }
}
