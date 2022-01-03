<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Jobs\AddCommentNotificationToLentaJob;

class AddCommentNotifyToLiveLenta
{
    public function handle(CommentCreated $event)
    {
        dispatch(new AddCommentNotificationToLentaJob($event->comment));
    }
}
