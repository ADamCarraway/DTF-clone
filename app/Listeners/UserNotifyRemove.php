<?php

namespace App\Listeners;

use App\Models\Category;
use App\Models\User;

class UserNotifyRemove
{
    public function handle($event)
    {
        if ($event->type === 'category') {
            $category = Category::query()->where('slug', $event->slug)->firstOrFail();

            auth()->user()->categoryNotify()->detach($category->id);
        } else {
            $user = User::query()->whereSlug($event->slug)->firstOrFail();

            auth()->user()->userNotify()->detach($user->id);
        }
    }
}
