<?php

namespace App\Http\Controllers\Auth;

use App\Category;
use App\Http\Controllers\Controller;
use App\Subscription;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function current()
    {
        $user = auth()->user();
        $request = $user->load(['users'])->toArray();
        $request['subscriptions'] = $user->subscriptions->sortBy('type')->map(function (Subscription $i) {
            return $i->toSubFormat();
        })->sortByDesc('date')->sortByDesc('is_favorite')->keyBy('slug')->toArray();
        $request['subscribers'] = $user->subscribers()->limit(12)->get();
        $request['subscribers_count'] = $user->subscribers()->count();
        $request['subscriptions_count'] = $user->subscriptions()->count();
        $request['subscriptions_limit'] = array_slice($request['subscriptions'], 0, 5);

        return response()->json($request);
    }

    public function show(Request $request, $slug)
    {
        /** @var User $user */
        $user = User::query()->withCount(['subscribers'])
             ->whereSlug($slug)
            ->firstOrFail();

        $user['subscriptions'] = $user->subscriptions->map(function (Subscription $i) {
            return $i->toSubFormat();
        })->keyBy('slug')->toArray();
        $user['subscribers'] = $user->subscribers()->limit(12)->get();
        $user['subscriptions_count'] = $user->subscriptions()->count();
        $user['subscriptions_limit'] = array_slice($user['subscriptions'], 0, 5);

        return response()->json($user);
    }

    public function details($slug)
    {
        $user = User::query()->whereSlug($slug)->firstOrFail();

        return response()->json([
            'subscribers' => $user->subscribers()->paginate(6),
            'subscriptions' => $user->categories()->paginate(6)
        ]);
    }

    public function subscribers($slug)
    {
        $user = User::query()->whereSlug($slug)->firstOrFail();

        return response()->json($user->subscribers()->paginate(10));
    }

    public function subscriptions($slug)
    {
        $user = User::query()->whereSlug($slug)->firstOrFail();

        $subs = $user->subscriptions()->paginate(10)
            ->getCollection()
            ->transform(function (Subscription $i) {
                return $i->toSubFormat();
            });

        return response()->json([
            'data' => $subs,
            'total' => Subscription::query()->where('user_id', $user->id)->count()
        ]);
    }

    public function posts(Request $request, $slug)
    {
        $user = User::query()->whereSlug($slug)->firstOrFail();

        return $user->posts()->with(['category', 'user'])->paginate(10);
    }
}
