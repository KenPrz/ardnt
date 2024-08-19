<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class ViewUsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        $posts = $user->posts()
            ->withRelationsAndCounts()
            ->paginate(10);
        foreach ($posts as $post) {
            $post->is_liked_by_user = $post->isLikedByUser(auth()->id());
        }
        return Inertia::render('Users/ViewUser', [
            'user' => $user,
            'posts' => [
                'count' => $user->posts()->count(),
                'data' => $posts,
            ],
            'followers' => [
                'count' => $user->followers()->count(),
                'data' => $user->followers()->paginate(10),
            ],
            'following' => [
                'count' => $user->following()->count(),
                'data' => $user->following()->paginate(10),
            ],
        ]);
    }

    public function getPosts($id) {
        dd($id);
    }

    public function followers($id) {
        dd($id);
    }

    public function following($id) {
        dd($id);
    }
}
