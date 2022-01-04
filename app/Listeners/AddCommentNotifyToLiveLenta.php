<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\LiveLentaAddCommentNotification;

class AddCommentNotifyToLiveLenta
{
    public function handle(CommentCreated $event)
    {
        $event->comment->post->category->notify(new LiveLentaAddCommentNotification($event->comment));
    }
}
