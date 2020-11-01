<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookmarkRequest;

class BookmarkController extends Controller
{
    public function create(BookmarkRequest $request)
    {
        $request->user()->addBookmark($request->bookmarked());

        return response()->json([
            'bookmarks' => $request->bookmarked()->bookmarks()->count()
        ]);
    }

    public function destroy(BookmarkRequest $request)
    {
        $request->user()->removeBookmark($request->bookmarked());

        return response()->json([
            'bookmarks' => $request->bookmarked()->bookmarks()->count()
        ]);
    }
}
