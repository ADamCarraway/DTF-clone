<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(
            auth()->user()->notifications()
                ->orderBy('created_at', 'desc')
                ->orderBy('read_at')
                ->paginate(5)
        );
    }

    public function store(NotificationRequest $request)
    {
        return auth()->user()->addNotification($request->notifiable());
    }

    public function destroy(NotificationRequest $request)
    {
        return auth()->user()->removeNotification($request->notifiable());
    }

    public function readAll()
    {
        /** @var User $user */
        $user = auth()->user();

        return $user->notifications()->update(['read_at' => now()]);
    }
}
