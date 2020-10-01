<?php

namespace App\Listeners;

use App\Category;

class AddSubsToUser
{
    const SUBS = ['games', 'gameindustry', 'gamedev', 'cinema', 'read', 'kek', 'avi', 'podcasts', 'esport', 'anime', 'science', 'music'];

    public function handle($event)
    {
        $id = Category::query()->whereIn('slug', self::SUBS)->pluck('id');

        $event->user->categories()->attach($id);
    }
}
