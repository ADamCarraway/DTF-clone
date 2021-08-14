<?php

namespace App\Listeners;

use App\Models\Category;

class AddSubsToUser
{
    const SUBS = ['games', 'gameindustry', 'gamedev', 'cinema', 'read', 'kek', 'avi', 'podcasts', 'esport', 'anime', 'science', 'music'];

    public function handle($event)
    {
        $categories = Category::query()->whereIn('slug', self::SUBS)->get();

        $event->user->followMany($categories);
    }
}
