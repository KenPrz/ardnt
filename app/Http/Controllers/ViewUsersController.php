<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ViewUsersController extends Controller
{
    /**
     * Show the user's profile with followers, following, and posts.
     *
     * @param int $id The ID of the user.
     * @return \Inertia\Response The rendered view of the user's profile.
     */
    public function show($identifier)
    {
        // Determine if the identifier is an ID or a handle 
        $user = is_numeric($identifier)
            ? User::with('followers', 'following')->findOrFail($identifier)
            : User::with('followers', 'following')->where('handle', $identifier)->firstOrFail();

        $user->is_followed_by_me = $user->isFollowedByMe();

        // Attach the 'is_followed_by_me' attribute to followers
        $followers = $user->followers->map(function ($follower) {
            return $follower->toArray() + ['is_followed_by_me' => $follower->isFollowedByMe()];
        });

        // Attach the 'is_followed_by_me' attribute to following
        $following = $user->following->map(function ($followingUser) {
            return $followingUser->toArray() + ['is_followed_by_me' => $followingUser->isFollowedByMe()];
        });

        // Fetch posts of the user with relations and counts
        $posts = Post::where('user_id', $user->id)
                ->withRelationsAndCounts()
                ->paginate(10);

        // Check if each post is liked by the authenticated user
        foreach ($posts as $post) {
            $post->is_liked_by_user = $post->isLikedByUser(auth()->id());
        }

        return Inertia::render('Users/ViewUser', [
            'user' => $this->restructSocials($user),
            'mustVerifyEmail' => $user->id == auth()->user()->id 
                ? auth()->user() instanceof MustVerifyEmail 
                : null,
            'posts' => [
                'count' => $posts->total(),
                'data' => $posts,
            ],
            'followers' => [
                'count' => $user->followers->count(),
                'data' => $followers,
            ],
            'following' => [
                'count' => $user->following->count(),
                'data' => $following,
            ],
        ]);
    }





    private function restructSocials($user) {
        $user->socials = [
            'website' => $user->website,
            'twitter' => $user->twitter,
            'instagram' => $user->instagram,
            'facebook' => $user->facebook,
            'linkedin' => $user->linkedin,
            'medium' => $user->medium,
        ];
        unset($user->website, 
            $user->twitter, 
            $user->instagram, 
            $user->facebook, 
            $user->linkedin, 
            $user->medium
        );
        return $user;
    }
}
