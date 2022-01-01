<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\AddCommentNotification;

class AddCommentNotifyToAuthor
{
    public function handle(CommentCreated $event)
    {
        $comment = $event->comment;

        if ($comment->user->id == $comment->post->user_id) return;

        $comment->post->user->notify(new AddCommentNotification($comment, $comment->user));
    }
}
