<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikePostController extends Controller
{
    /**
     * Like a post.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function like(Request $request)
    {
        $post = Post::find($request->post_id);
        $post->likedByUsers()->attach(auth()->user()->id);

        return redirect()->back();
    }

    /**
     * Unlike a post.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlike(Request $request)
    {
        $post = Post::find($request->post_id);
        $post->likedByUsers()->detach(auth()->user()->id);

        return redirect()->back();
    }
}
