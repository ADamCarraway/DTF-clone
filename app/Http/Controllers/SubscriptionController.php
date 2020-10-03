<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;

class SubscriptionController extends Controller
{
    public function store($slug, $type)
    {
        if ($type === 'category') {
            $category = Category::query()->where('slug', $slug)->firstOrFail();

            return auth()->user()->categories()->attach($category->id);
        } else {
            $user = User::query()->whereSlug($slug)->firstOrFail();

            return auth()->user()->users()->attach($user->id);
        }
    }

    public function destroy($slug, $type)
    {
        if ($type === 'category') {
            $category = Category::query()->where('slug', $slug)->firstOrFail();

            return auth()->user()->categories()->detach($category->id);
        } else {
            $user = User::query()->whereSlug($slug)->firstOrFail();

            return auth()->user()->users()->detach($user->id);
        }
    }
}
