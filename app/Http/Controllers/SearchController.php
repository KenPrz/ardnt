<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
class SearchController extends Controller
{
    /**
     * Search for users and posts based on the given search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = $this->searchUsers($search);
        $posts = $this->searchPosts($search);
        return response()->json([
            'users' => $users,
            'posts' => $posts
        ]);
    }

    /**
     * Search for users based on a given search string.
     *
     * @param string $search The search string to match against user's first name, last name, or handle.
     * @return \Illuminate\Database\Eloquent\Collection A collection of users matching the search criteria.
     */
    protected function searchUsers($search)
    {
        return User::select('id', 'first_name', 'last_name','handle', 'avatar', 'created_at')
            ->where('first_name', 'like', "%$search%")
            ->orWhere('last_name', 'like', "%$search%")
            ->orWhere('handle', 'like', "%$search%")
            ->limit(5)
            ->get();
    }

    // TO DO SEARCH BASED ON USER RELATIONSHIPS AND VISIBILITY
    /**
     * Search posts based on a given search term.
     *
     * @param string $search The search term to filter posts.
     * @return \Illuminate\Database\Eloquent\Collection A collection of posts matching the search term.
     */
    protected function searchPosts($search)
    {
        return Post::select(
            'posts.id',
            'posts.title',
            'posts.content',
            'posts.cover_image',
            'posts.created_at',
            'users.handle',
            'themes.name as theme_name'
        )
        ->join('themes', 'posts.theme_id', '=', 'themes.id')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->where(function ($query) use ($search) {
            $query->where('posts.title', 'like', "%$search%")
                  ->orWhere('posts.content', 'like', "%$search%")
                  ->orWhere('themes.name', 'like', "%$search%");
        })
        ->limit(5)
        ->get();
    }
}
