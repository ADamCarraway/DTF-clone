<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IgnoreKeywordController extends Controller
{
    public function index()
    {
        return auth()->user()->ignoredKeywords()->pluck('keyword');
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->ignoredKeywords()->where('keyword', $request->keyword)->exists()){
            return response()->json('',Response::HTTP_BAD_REQUEST);
        }

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
