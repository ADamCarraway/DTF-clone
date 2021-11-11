<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        return response()->json(auth()->user()->toVueFormat());
    }

    public function show(Request $request, $slug)
    {
        /** @var User $user */
        $user = User::query()
             ->whereSlug($slug)
            ->firstOrFail();

        return response()->json($user->toVueFormat());
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
        /** @var User $user */
        $user = User::query()->whereSlug($slug)->firstOrFail();

        return response()->json(
            $user->posts()
                ->public()
                ->with(['category', 'user', 'parent', 'parent.user'])
                ->paginate(10)
        );
    }

    public function drafts(Request $request)
    {
        return response()->json(
            auth()->user()
                ->posts()
                ->draft()
                ->with(['category', 'user', 'parent', 'parent.user'])
                ->paginate(10)
        );
    }
}
