<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Jobs\AddPostNotificationNewCounterJob;

class AddPostNotifyNewCounter
{
    public function handle(PostCreated $event)
    {
        dispatch(new AddPostNotificationNewCounterJob($event->post));
    }
}
