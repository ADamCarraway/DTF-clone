<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Visitors
{
    public function handle(Request $request, Closure $next)
    {
        if (!$post = Post::query()->whereSlug($request->route('slug'))->first()) {
            return $next($request);
        }

        /** @var Post $post */
        if ($view = $post->views()->where(['viewable_id' => $post->id, 'ip' => $request->ip()])->first()) {
            $post->views()->where([
                'viewable_id' => $post->id,
                'ip' => $request->ip(),
                'user_id' => auth()->check() ? auth()->user()->id : null,
            ])->increment('count');
        } else {
            $post->views()->create([
                'viewable_id' => $post->id,
                'ip' => $request->ip(),
                'user_id' => auth()->check() ? auth()->user()->id : null,
                'count' => 1
            ]);
        }

        return $next($request);
    }
}
