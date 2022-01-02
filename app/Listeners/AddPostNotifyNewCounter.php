<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Jobs\AddPostNotificationNewCounterJob;

class AddPostNotifyNewCounter
{
    public function handle(PostCreated $event)
    {
        dispatch_now(new AddPostNotificationNewCounterJob($event->post));
    }
}
