<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;

class LikeController extends Controller
{
    public function like(LikeRequest $request)
    {
        $request->user()->addLike($request->likeable());

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
