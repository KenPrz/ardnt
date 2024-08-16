<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreationRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreationRequest $request)
    {
        if ($request->is_shared) {
            $this->sharedPostHandler($request);
        }

        $fileName = null;

        $extension = $request->file('cover_image')->getClientOriginalExtension();
        $fileName = uniqid().'_'.time().'.'.$extension;

        Storage::disk($request->is_public ? 'public' : 'private')
            ->put('images/'.$fileName, file_get_contents($request->file('cover_image')));

        Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'theme_id' => $request->theme,
            'cover_image' => $fileName,
            'is_public' => $request->is_public,
            'is_shared' => $request->is_shared,
            'shared_post_id' => null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id)
                ->with('user', 
                'comments.user', 
                'likedByUsers',
                'originalPost', 
                'shares')->first();
            dd($post);
        return Inertia::render('Post/View', [

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function sharedPostHandler($request)
    {
        dd($request->all());
    }
}
