<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\FollowRequest;
use App\User;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function store(FollowRequest $request)
    {
        return DB::table('followers')->where('id', $request->followable()->findFollower(auth()->user())->id)->update(['favorite' => 1]);
    }

    public function destroy(FollowRequest $request)
    {
        return DB::table('followers')->where('id', $request->followable()->findFollower(auth()->user())->id)->update(['favorite' => 0]);
    }
}
