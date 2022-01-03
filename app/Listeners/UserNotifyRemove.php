<?php

namespace App\Listeners;

use App\Models\Category;
use App\Models\User;

class UserNotifyRemove
{
    public function handle($event)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($event->type === 'category') {
            $user->categoryNotify()->detach(
                Category::query()->where('slug', $event->slug)->firstOrFail()->id
            );
        } elseif ($event->type === 'user') {
            $user->userNotify()->detach(
                User::query()->whereSlug($event->slug)->firstOrFail()->id
            );
        }
    }
}
