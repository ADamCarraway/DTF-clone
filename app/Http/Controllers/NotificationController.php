<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;

class NotificationController extends Controller
{
    public function store(NotificationRequest $request)
    {
        return auth()->user()->addNotification($request->notifiable());
    }

    public function destroy(NotificationRequest $request)
    {
        return auth()->user()->removeNotification($request->notifiable());
    }
}
