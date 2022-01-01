<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\LiveLentaAddCommentNotification;

class AddCommentNotifyToLiveLenta
{
    public function handle(CommentCreated $event)
    {
        $comment = $event->comment;
        $category = $comment->post->category;

        if ($category) {
            $category->followers()->where('follower_id', '!=', $comment->user->id)->each(function ($follower) use ($comment) {
                $follower->follower->notify(new LiveLentaAddCommentNotification($comment, $comment->user));
            });
        }
    }
}
