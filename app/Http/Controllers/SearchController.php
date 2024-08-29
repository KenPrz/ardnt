<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Inertia\Inertia;
class SearchController extends Controller
{
    /**
     * Display the search results on search page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request) {
        $search = $request->search;
        $users = $this->searchUsers($search, 10);
        $posts = $this->searchPosts($search, 10);
        return Inertia::render('Search/Search', [
            'users' => $users,
            'posts' => $posts,
        ]);
    }
    /**
     * Search for users and posts based on the given search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = $this->searchUsers($search, null);
        $posts = $this->searchPosts($search, null);
        return response()->json([
            'users' => $users,
            'posts' => $posts
        ]);
    }


    /**
     * Search for users based on a given search term.
     *
     * @param string $search The search term to match against user's first name, last name, and handle.
     * @param int $limit The number of users to display per page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator | \Illuminate\Database\Eloquent\Collection The paginated or an array of list of users matching the search term.
     */
    protected function searchUsers($search, $limit=null)
    {
        $query = User::select('id', 'first_name', 'last_name', 'handle', 'avatar', 'created_at')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%")
                      ->orWhere('handle', 'like', "%$search%");
            });
    
        if ($limit !== null) {
            return $query->paginate($limit);
        } else {
            return $query->limit(5)->get();
        }
    }
    

    /**
     * Search posts based on a given search term and limit the number of results.
     *
     * @param string $search The search term to filter posts by.
     * @param int $limit The maximum number of posts to return.
     * @return \Illuminate\Pagination\LengthAwarePaginator | array The paginated or an array of list of posts matching the search term.
     */
    protected function searchPosts($search, $limit=null)
    {
        $query = Post::select(
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
            });
    
        if ($limit !== null) {
            return $query->paginate($limit);
        } else {
            return $query->limit(5)->get();
        }
    }
    
}
