<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Jobs\AddCommentNotificationJob;

class AddCommentNotify
{
    public function handle(CommentCreated $event)
    {
        dispatch(new AddCommentNotificationJob($event->comment));
    }
}
