<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Comment;
use App\Http\Requests\BookmarkRequest;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request, $slug)
    {
        $filter = $request->input('filter', '');

        $user = User::query()->whereSlug($slug)->firstOrFail();

        if ($filter && $filter === 'comments') {
            $favorites = Comment::query()->with('post')->whereIn('id',  Bookmark::query()
                ->whereUserId($user->id)->where('bookmarkable_type', Comment::class)->pluck('bookmarkable_id'));
        } else {
            $favorites = Post::query()->with('category')->whereIn('id',  Bookmark::query()
                ->whereUserId($user->id)->where('bookmarkable_type', Post::class)->pluck('bookmarkable_id'));
        }

        return response()->json([
            'favorites' => $favorites->paginate(10),
            'commentsTotal' => $request->input('page') == 1 ? Comment::query()->with('post')->whereIn('id',  Bookmark::query()
                ->whereUserId($user->id)->where('bookmarkable_type', Comment::class)->pluck('bookmarkable_id'))->count() : null,
            'postTotal' => $request->input('page') == 1 ? Post::query()->with('category')->whereIn('id',  Bookmark::query()
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
