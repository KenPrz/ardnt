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
            'posts' => $posts,
            'followers' => $user->followers()->paginate(10),
            'following' => $user->following()->paginate(10),
        ]);
    }
}
