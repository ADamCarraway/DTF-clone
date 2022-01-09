<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBlockKeywordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class IgnoreKeywordController extends Controller
{
    public function index()
    {
        return auth()->user()->ignoredKeywords()->pluck('keyword');
    }

    public function store(AddBlockKeywordRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        return response()->json(
            $user->ignoredKeywords()->create(['keyword' => $request->keyword])
        );
    }

    public function destroy(Request $request)
    {
        return response()->json(
            auth()->user()->ignoredKeywords()->where('keyword', $request->keyword)->delete()
        );
    }
}
