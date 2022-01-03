<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\UserNotificationSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AddReplyCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Post $post;
    /**
     * @var Comment
     */
    private Comment $comment;
    private User $user;

    /**
     * AddFollowNotification constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
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
            'user'    => $this->user,
            'comment' => $this->comment,
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'read_at' => null,
            'data'    => [
                'user'    => $this->user,
                'comment' => $this->comment,
            ],
        ]);
    }
}
