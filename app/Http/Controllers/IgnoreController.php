<?php

namespace App\Http\Controllers;

use App\Http\Requests\IgnoreRequest;
use App\Models\User;

class IgnoreController extends Controller
{
    public function store(IgnoreRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->startIgnore($request->ignorable());

        return response()->json(
            $request->ignorable()
                ->ignorable()
                ->with('ignorable')
                ->whereHas('user', fn($q) => $q->whereId($user->id))
                ->firstOrFail()
        );
    }

    public function destroy(IgnoreRequest $request)
    {
        return auth()->user()->stopIgnore($request->ignorable());
    }
}
