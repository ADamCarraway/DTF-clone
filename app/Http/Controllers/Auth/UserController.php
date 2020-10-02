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
        $request = auth()->user()->load(['categories', 'users'])->toArray();
        $request['categories'] = collect($request['categories'])->keyBy('slug');
        $request['users'] = collect($request['users'])->keyBy('id');
        $request['category_notify'] = auth()->user()->category_notify;
        $request['user_notify'] = auth()->user()->user_notify;
        $request['categories_ignore'] = auth()->user()->categories_ignore;
        $request['users_ignore'] = auth()->user()->users_ignore;

        return response()->json($request);
    }

    public function show(Request $request, $id)
    {
        $user = User::query()->withCount('allSubscriptions')->where('id', $id)->firstOrFail()->load(['subscribers', 'categories'])->toArray();

        return response()->json($user);
    }

    public function details($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();

        return response()->json([
            'subscribers' => $user->subscribers()->paginate(6),
            'subscriptions' => $user->categories()->paginate(6)
        ]);
    }

    public function subscribers($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();

        return response()->json($user->subscribers()->paginate(10));
    }

    public function subscriptions($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();

        $subs = $user->allSubscriptions()->paginate(10)
            ->getCollection()
            ->transform(function (Subscription $i) {
                if ($i->subscription_type === Category::class) {
                    $i = Category::query()->where('id', $i->subscription_id)->first();
                } else {
                    $i = User::query()->where('id', $i->subscription_id)->first();
                }

                return $i;
            });;

        return response()->json([
            'data' => $subs,
            'total' => Subscription::query()->where('user_id', $user->id)->count()
        ]);
    }
}
