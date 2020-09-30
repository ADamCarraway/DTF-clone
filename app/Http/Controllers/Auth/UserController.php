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
        $request = auth()->user()->load(['categories', 'users'])->toArray();
        $request['categories'] = collect($request['categories'])->keyBy('slug');
        $request['users'] = collect($request['users'])->keyBy('id');

        return response()->json($request);
    }

    public function show(Request $request, $id)
    {
        $user = User::query()->where('id', $id)->firstOrFail()->load(['subscribers', 'categories'])->toArray();

        return response()->json($user);
    }
}
