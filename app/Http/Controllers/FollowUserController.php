<?php

namespace App\Http\Controllers;

use App\Models\UserFollower;
use Illuminate\Http\Request;

class FollowUserController extends Controller
{
    public function follow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $follower = UserFollower::create([
            'user_id' => auth()->user()->id,
            'follower_id' => $request->user_id,
        ]);
        if ($follower) {
            return back()->with('success', 'User followed successfully');
        } else {
            throw new \Exception('Failed to follow user');
        }
    }

    public function unfollow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $follower = UserFollower::where('user_id', auth()->user()->id)
            ->where('follower_id', $request->user_id)
            ->first();
        if ($follower) {
            $follower->delete();

            return back()->with('success', 'User unfollowed successfully');
        } else {
            throw new \Exception('Failed to unfollow user');
        }
    }
}
