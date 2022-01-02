<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Post;
use App\Notifications\AddPostNotificationNewCounter;
use Hypefactors\Laravel\Follow\Follower;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AddPostNotificationNewCounterJob //implements ShouldQueue
{
//    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        /** @var Category $category */
        $category = $this->post->category;
        $category->followers()
            ->each(function (Follower $follower) {
                $follower->follower->notify(new AddPostNotificationNewCounter());
            });
    }
}
