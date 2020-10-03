<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;

class FavoriteController extends Controller
{
    public function store($slug, $type)
    {
        if ($type === 'category') {
            $category = Category::query()->where('slug', $slug)->firstOrFail();
            $sub = auth()->user()->categories()->where('subscription_id', $category->id)->first();

            return $sub->pivot->update(['favorite' => 1]);
        } else {
            $user = User::query()->whereSlug($slug)->firstOrFail();
            $sub = auth()->user()->users()->where('subscription_id', $user->id)->first();

            return $sub->pivot->update(['favorite' => 1]);
        }
    }

    public function destroy($slug, $type)
    {
        if ($type === 'category') {
            $category = Category::query()->where('slug', $slug)->firstOrFail();
            $sub = auth()->user()->categories()->where('subscription_id', $category->id)->first();

            return $sub->pivot->update(['favorite' => 0]);
        } else {
            $user = User::query()->whereSlug($slug)->firstOrFail();
            $sub = auth()->user()->users()->where('subscription_id', $user->id)->first();

            return $sub->pivot->update(['favorite' => 0]);
        }
    }
}
