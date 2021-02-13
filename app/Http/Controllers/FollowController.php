<?php

namespace App\Http\Controllers;

use App\Category;
use App\Events\CancelSubscriptionEvent;
use App\Http\Requests\FollowRequest;
use App\User;

class FollowController extends Controller
{
    public function store(FollowRequest $request)
    {
       return $request->user()->follow($request->followable());
    }

    public function destroy(FollowRequest $request)
    {
        return $request->user()->unfollow($request->followable());
    }
}
