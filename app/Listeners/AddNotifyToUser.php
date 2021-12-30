<?php

namespace App\Listeners;

use App\Models\UserNotificationSetting;

class AddNotifyToUser
{
    public function handle($event)
    {
        collect(UserNotificationSetting::NOTIFICATIONS)->each(function ($name) use ($event) {
            $event->user->notificationSettings()
                ->firstOrCreate(['notification' => $name], ['status' => true]);
        });
    }
}
