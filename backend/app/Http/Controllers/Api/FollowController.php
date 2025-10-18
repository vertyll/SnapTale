<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Follow a user.
     */
    public function follow(Request $request): JsonResponse
    {
        $request->validate(['followed_user_id' => 'required|exists:users,id']);

        try {
            $followerId = auth()->user()->id;
            $followedUserId = $request->followed_user_id;

            $existingFollow = Follow::where('user_id', $followerId)
                ->where('followed_user_id', $followedUserId)
                ->first();

            if ($existingFollow) {
                return response()->json(['message' => 'Already following this user'], 400);
            }

            $follow = new Follow;
            $follow->user_id = $followerId;
            $follow->followed_user_id = $followedUserId;
            $follow->save();

            return response()->json([
                'follow' => [
                    'id' => $follow->id,
                    'follower_id' => $followerId,
                    'followed_user_id' => $followedUserId,
                ],
                'success' => 'OK',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Unfollow a user.
     */
    public function unfollow($followedUserId): JsonResponse
    {
        try {
            $followerId = auth()->user()->id;

            $follow = Follow::where('user_id', $followerId)
                ->where('followed_user_id', $followedUserId)
                ->first();

            if (! $follow) {
                return response()->json(['message' => 'Not following this user'], 400);
            }

            $follow->delete();

            return response()->json([
                'message' => 'Successfully unfollowed',
                'success' => 'OK',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Check if the authenticated user is following another user.
     */
    public function isFollowing($followedUserId): JsonResponse
    {
        try {
            $followerId = auth()->user()->id;

            $isFollowing = Follow::where('user_id', $followerId)
                ->where('followed_user_id', $followedUserId)
                ->exists();

            return response()->json(['is_following' => $isFollowing], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Get the number of followers of a user.
     */
    public function followCount($userId): JsonResponse
    {
        try {
            $followCount = Follow::where('followed_user_id', $userId)->count();

            return response()->json(['follow_count' => $followCount], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
