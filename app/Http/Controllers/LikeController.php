<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Comment;
use App\Notifications\AddLikeNotification;

class LikeController extends Controller
{
    public function like(LikeRequest $request)
    {
        $request->user()->addLike($request->likeable());

        if ($request->likeable() instanceof Comment){
            $request->likeable()->user->notify(new AddLikeNotification($request->user(), $request->likeable()->load('post')));
        }

        return response()->json([
            'likes' => $request->likeable()->likes()->count()
        ]);
    }

    public function dislike(LikeRequest $request)
    {
        $request->user()->removeLike($request->likeable());

        return response()->json([
            'likes' => $request->likeable()->likes()->count()
        ]);
    }
}
