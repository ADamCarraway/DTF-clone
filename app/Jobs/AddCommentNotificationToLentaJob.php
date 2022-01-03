<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Notifications\LiveLentaAddCommentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddCommentNotificationToLentaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function handle()
    {
        $category = $this->comment->post->category;

        if ($category) {
            $category->followers()->each(function ($follower) {
                $follower->follower->notify(new LiveLentaAddCommentNotification($this->comment));
            });
        }
    }
}
