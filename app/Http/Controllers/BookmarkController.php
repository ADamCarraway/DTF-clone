<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookmarkIndexRequest;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Http\Requests\BookmarkRequest;
use App\Models\Post;
use App\Models\User;

class BookmarkController extends Controller
{
    public function index(BookmarkIndexRequest $request, $slug)
    {
        $filter = $request->filter;

        $user = User::query()->whereSlug($slug)->firstOrFail();

        if ($filter === 'comments') {
            $favorites = Comment::query()->with('post')->whereIn('id', Bookmark::query()
                ->whereUserId($user->id)->where('bookmarkable_type', Comment::class)->pluck('bookmarkable_id'));
        } else {
            $favorites = Post::query()->with('category')->whereIn('id', Bookmark::query()
                ->whereUserId($user->id)->where('bookmarkable_type', Post::class)->pluck('bookmarkable_id'));
        }

        return response()->json([
            'favorites'     => $favorites->paginate(10),
            'commentsTotal' => $request->page == 1 ? Comment::query()->with('post')->whereIn('id', Bookmark::query()
                ->whereUserId($user->id)->where('bookmarkable_type', Comment::class)->pluck('bookmarkable_id'))->count() : null,
            'postTotal'     => $request->page == 1 ? Post::query()->with('category')->whereIn('id', Bookmark::query()
                ->whereUserId($user->id)->where('bookmarkable_type', Post::class)->pluck('bookmarkable_id'))->count() : null
        ]);
    }

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
