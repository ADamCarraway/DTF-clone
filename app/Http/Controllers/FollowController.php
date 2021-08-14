<?php

namespace App\Http\Controllers;

use App\Http\Requests\FollowRequest;
use App\Models\User;
use App\Notifications\AddFollowNotification;

class FollowController extends Controller
{
    public function store(FollowRequest $request)
    {
        if ($request->followable() instanceof User){
            $request->followable()->notify(new AddFollowNotification($request->user()));
        }

        return $request->user()->follow($request->followable());
    }

    public function destroy(FollowRequest $request)
    {
        return $request->user()->unfollow($request->followable());
    }
}
