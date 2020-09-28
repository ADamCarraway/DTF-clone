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
        $request = auth()->user()->load('subscriptions')->toArray();
        $request['subscriptions'] = collect($request['subscriptions'])->keyBy('slug');

        return response()->json($request);
    }

    public function show(Request $request, $id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();

        return response()->json($user);
    }
}
