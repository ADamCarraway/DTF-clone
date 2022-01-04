<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AddPostNotificationNewCounter extends Notification implements ShouldQueue
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

    public function broadcastOn(): Channel
    {
        return new Channel('new-post-counter.' . $this->post->category_id);
    }
}
