<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AddPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        $this->onQueue('notification');

        return $notifiable->isNotificationEnabled(self::class) ? ['broadcast', 'database'] : [];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return new BroadcastMessage([
            'post' => $this->post,
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'post' => $this->post,
            ],
        ]);
    }
}
