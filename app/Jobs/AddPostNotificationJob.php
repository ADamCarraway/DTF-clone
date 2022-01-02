<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use App\Notifications\AddPostNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AddPostNotificationJob //implements ShouldQueue
{
//    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        Notification::query()
            ->where(function ($q) {
                $q->where(function ($b) {
                    $b->where('notifiable_id', $this->post->category_id)
                        ->where('notifiable_type', Category::class);
                })
                    ->orWhere(function ($b) {
                        $b->where('notifiable_id', $this->post->user_id)
                            ->where('notifiable_type', User::class);
                    });
            })
            ->where('user_id', '!=', $this->post->user_id)
            ->each(function (Notification $notification) {
                $notification->user->notify(new AddPostNotification($this->post));
            });
    }
}
