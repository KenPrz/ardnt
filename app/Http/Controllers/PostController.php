<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreationRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class PostController extends Controller
{
    /**
     * Store a newly created post in the database.
     *
     * @return void
     */
    public function store(PostCreationRequest $request)
    {
        Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'theme_id' => $request->theme,
            'cover_image' => $request->cover_image == null
                ? null
                : $request->file('cover_image')
                    ->store('images', 'public'),
            'is_public' => $request->is_public,
            'is_shared' => $request->is_shared,
            'shared_post_id' => null,
        ]);
    }

    /**
     * Show a specific post.
     *
     * @param  string  $id  The ID of the post.
     * @return \Inertia\Response The rendered view of the post.
     */
    public function show(string $id)
    {
        $post = Post::withRelationsAndCounts()
            ->findOrFail($id);

        return Inertia::render('Post/PreviewPost', [
            'post' => $post,
            'themes' => Theme::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request)
    {
        $post = Post::findOrFail($request->id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->theme_id = $request->theme;
        $post->is_public = $request->is_public;
        $post->is_shared = $request->is_shared;
        $post->shared_post_id = $request->shared_post_id ?? null;
        $post->save();
    }


    /**
     * Delete a post.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @return void Redirects to the user's profile page.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id',
        ]);
        $post = Post::findOrFail($request->id);
        if ($post->user_id == auth()->id()) {
            $post->delete();
            if ($request->currentRoute == 'posts.show') {
                return redirect()->route('users.show', auth()->user()->handle); // Redirect to user's profile since the post is deleted to avoid 404 error
            }
        } else {
            abort(403);
        }
    }

    /**
     * Share a post.
     *
     * @param  \App\Http\Requests\PostCreationRequest  $request
     * @return void
     */
    public function sharePost(PostCreationRequest $request)
    {
        Post::create([
            'user_id' => auth()->id(),
            'title' => null,
            'content' => $request->content,
            'theme_id' => $request->theme,
            'cover_image' => null,
            'is_public' => $request->is_public,
            'is_shared' => true,
            'shared_post_id' => $request->shared_post_id,
        ]);
    }
}
