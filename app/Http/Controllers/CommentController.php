<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeleteCommentRequest;
use App\Models\Comment;
class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {

        $request->validate([
            'post_id' => 'required|numeric|exists:posts,id',
            'content' => 'required|string|max:1024',
        ]);
        
        if (!Comment::canUserComment(auth()->id())) {
            return redirect()->back()->withErrors([
                'content' => 'You have reached the maximum number of comments allowed in 5 minutes!!!',
            ]);
        }
        
        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
            'is_edited' => false,
        ]);

    }

    public function update(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|numeric|exists:comments,id',
            'content' => 'required|string|max:1024',
        ]);
        
        $comment = Comment::findOrFail($request->comment_id);
        $comment->content = $request->content;
        $comment->is_edited = true;
        $comment->save();
    }

    public function destroy(DeleteCommentRequest $request)
    {
        $comment = Comment::findOrFail($request->comment_id);

        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }
        $comment->delete();
    }

}
