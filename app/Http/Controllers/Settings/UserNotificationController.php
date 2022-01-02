<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Notifications\AddCommentNotification;
use App\Notifications\AddFollowNotification;
use App\Notifications\AddLikeToCommentNotification;
use App\Notifications\AddPostNotification;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->notificationSettings()->get());
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $key => $status) {
            auth()->user()->notificationSettings()->updateOrCreate(['notification' => $key], ['status' => $status]);
        }
    }
}
