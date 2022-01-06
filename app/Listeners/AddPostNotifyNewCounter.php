<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\AddPostNotificationNewCounter;

class AddPostNotifyNewCounter
{
    public function handle(PostCreated $event)
    {
        $post = $event->post;
        if ($post->category_id) {
            $post->category->notify(new AddPostNotificationNewCounter($event->post));
        }
    }
}
