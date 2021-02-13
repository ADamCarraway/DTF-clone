<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        /** @var User $user */
        $request = $user = auth()->user();
        $request['users'] = $user->followers()->whereFollowerType(User::class)->get()->toArray();
        $request['subscriptions'] = $user->followings()->with('followable')->get()->pluck('followable')->keyBy('slug')->sortByDesc('type')->sortByDesc('date')->sortByDesc('is_favorite')->toArray();
        $request['subscribers'] = $user->followers()->with('follower')->limit(12)->get()->pluck('follower');
        $request['subscribers_count'] = $user->followers()->count();
        $request['subscriptions_count'] = $user->followings()->count();
        $request['subscriptions_limit'] = array_slice($request['subscriptions'], 0, 5);
        $request['posts_count'] = $user->posts()->count();
        $request['comments_count'] = $user->comments()->count();
        $request['bookmarks_count'] = $user->bookmarks()->count();

        return response()->json($request);
    }

    public function show(Request $request, $slug)
    {
        /** @var User $user */
        $user = User::query()->withCount(['followers', 'posts', 'comments', 'bookmarks'])
             ->whereSlug($slug)
            ->firstOrFail();

        $user['subscriptions'] = $user->followings()->with('followable')->limit(12)->get()->pluck('followable')->keyBy('slug')->toArray();
        $user['subscribers'] = $user->followers()->with('follower')->limit(12)->get()->pluck('follower');
        $user['subscribers_count'] = $user->followers()->count();
        $user['subscriptions_count'] = $user->followings()->count();
        $user['subscriptions_limit'] = array_slice($user['subscriptions'], 0, 5);

        return response()->json($user);
    }

    public function details($slug)
    {
        /** @var User $user */
        $user = User::query()->whereSlug($slug)->firstOrFail();

        return response()->json([
            'subscribers' => $user->followers()->with('follower')->limit(6)->get()->pluck('follower'),
            'subscriptions' => $user->followings()->with('followable')->limit(6)->get()->pluck('followable')
        ]);
    }

    public function subscribers($slug)
    {
        /** @var User $user */
        $user = User::query()->whereSlug($slug)->firstOrFail();

        $paginator = tap($user->followers()->with('follower')->paginate(10),function($paginatedInstance){
            return $paginatedInstance->getCollection()->transform(function ($follower) {
                return $follower->follower;
            });
        });

        return response()->json($paginator);
    }

    public function subscriptions($slug)
    {
        /** @var User $user */
        $user = User::query()->whereSlug($slug)->firstOrFail();

        $paginator = tap($user->followings()->with('followable')->paginate(10),function($paginatedInstance){
            return $paginatedInstance->getCollection()->transform(function ($follower) {
                return $follower->followable;
            });
        });

        return response()->json($paginator);
    }

    public function posts(Request $request, $slug)
    {
        $user = User::query()->whereSlug($slug)->firstOrFail();

        return $user->posts()->with(['category', 'user'])->paginate(10);
    }
}
