<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Events\PostCreated;
use App\Jobs\AddPostNotificationJob;
use App\Notifications\AddCommentNotification;

class AddPostNotify
{
    public function handle(PostCreated $event)
    {
        dispatch(new AddPostNotificationJob($event->post));
    }
}
