<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use App\Notifications\AddCommentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddCommentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function handle()
    {
        Notification::query()
            ->where(function ($b) {
                $b->where('notifiable_id', $this->comment->post->id)
                    ->where('notifiable_type', Post::class);
            })
            ->where('user_id', '!=', $this->comment->user_id)
            ->each(function (Notification $notification) {
                $notification->user->notify(new AddCommentNotification($this->comment));
            });
    }
}
