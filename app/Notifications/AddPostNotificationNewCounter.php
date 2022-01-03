<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AddPostNotificationNewCounter extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        $this->onQueue('notification');

        return ['broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [],
        ]);
    }
}
