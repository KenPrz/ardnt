<?php

namespace App\Http\Controllers;

use App\Models\UserFollower;
use Illuminate\Http\Request;

class FollowUserController extends Controller
{
    public function follow(Request $request)
    {
        $user = auth()->user();
        $follower = UserFollower::create([
            'user_id' => $request->user_id,
            'follower_id' => $user->id,
        ]);
        if ($follower) {
            return back()->with('success', 'User followed successfully');
        } else {
            throw new \Exception('Failed to follow user');
        }
    }

    public function unfollow(Request $request)
    {
        // $user = auth()->user();
        // $user->following()->detach($request->user_id);
        // return response()->json(['message' => 'User unfollowed successfully']);
    }
}
