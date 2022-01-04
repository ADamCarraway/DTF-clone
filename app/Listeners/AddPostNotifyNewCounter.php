<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\AddPostNotificationNewCounter;

class AddPostNotifyNewCounter
{
    public function handle(PostCreated $event)
    {
        $event->post->category->notify(new AddPostNotificationNewCounter($event->post));
    }
}
