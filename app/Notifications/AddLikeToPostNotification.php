<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AddLikeToPostNotification extends Notification
{
//    use Queueable;
    /**
     * @var User
     */
    private User $user;
    /**
     * @var Post
     */
    private Post $post;

    /**
     * AddFollowNotification constructor.
     * @param User $user
     * @param Post $post
     */
    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function via($notifiable)
    {
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
            'user' => $this->user,
            'post' => $this->post,
            'date' => now(),
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'user' => $this->user,
                'post' => $this->post,
                'date' => now(),
            ],
        ]);
    }
}
