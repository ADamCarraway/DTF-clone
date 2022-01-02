<?php

namespace App\Jobs;

use App\Models\Post;

class UpdatePostRating //implements ShouldQueue
{
//    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        $this->post->update([
            'rating' => round(Post::ODDS['c'] + Post::ODDS['a'] * Log(1 + $this->post->likes->count()) + Post::ODDS['b'] * Log(1 + $this->post->views->count()) + Post::ODDS['d'] * Log(1 + $this->post->comments->count()), 2)
        ]);
    }
}
