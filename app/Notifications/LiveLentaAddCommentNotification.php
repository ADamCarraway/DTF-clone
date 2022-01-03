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

class LiveLentaAddCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Comment
     */
    private Comment $comment;

    /**
     * AddFollowNotification constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
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
            'comment' => $this->comment,
        ]);
    }
}
