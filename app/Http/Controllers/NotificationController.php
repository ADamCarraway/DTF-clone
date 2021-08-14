<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        return response()->json($user->notifications()->orderBy('created_at', 'desc')->paginate(20));
    }

    public function store(NotificationRequest $request)
    {
        return auth()->user()->addNotification($request->notifiable());
    }

    public function destroy(NotificationRequest $request)
    {
        return auth()->user()->removeNotification($request->notifiable());
    }
}
