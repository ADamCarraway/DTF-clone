<?php

namespace App\Console\Commands;

use App\Jobs\UpdatePostRating;
use App\Models\Post;
use Illuminate\Console\Command;

class CalculatePostRating extends Command
{
    protected $signature = 'post:calculate-rating';
    protected $description = 'Calculate rating';

    public function handle()
    {
        Post::query()->latest()->each(function (Post $post) {
            dispatch_now(new UpdatePostRating($post));
        });
    }
}
