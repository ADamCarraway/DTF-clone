<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LastSeenUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $expireTime = Carbon::now()->addMinute();
            Cache::put('is-online-' . auth()->user()->id, true, $expireTime);

            auth()->user()->update(['last_seen' => Carbon::now()]);
        }

        return $next($request);
    }
}
