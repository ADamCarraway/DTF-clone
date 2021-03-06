<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function userComments(Request $request, $slug)
    {
        $filter = $request->get('filter');
        $odds = Comment::ODDS;

        /** @var User $user */
        $user = User::query()->whereSlug($slug)->firstOrFail();
        $comments = $user->comments()->with('post');

        if ($filter == 'popular') {
            $comments = $comments
                ->leftJoin('comments as replies', function ($q) {
                    $q->on('comments.id', '=', 'replies.parent_id');
                })
                ->leftJoin('likes', function ($q) {
                    $q->on('comments.id', '=', 'likes.likeable_id')
                        ->where('likes.likeable_type', '=', Comment::class);
                })
                ->leftJoin('bookmarks', function ($q) {
                    $q->on('comments.id', '=', 'bookmarks.bookmarkable_id')
                        ->where('bookmarks.bookmarkable_type', '=', Comment::class);
                })
                ->addSelect(DB::raw("('$odds[c]'+'$odds[a]'*LOG(1+count(DISTINCT likes.id))+'$odds[b]'*LOG(1+count(DISTINCT bookmarks.id))+'$odds[d]'*LOG(1+count(DISTINCT replies.id))) as weight"))
                ->groupBy('comments.id')->orderBy('weight', 'desc');
        }

        if ($filter == 'new') {
            $comments->latest('created_at');
        }

        return $comments->paginate('10');
    }

    public function comments(Request $request, $slug)
    {
        $type = $request->get('type');

        $comments = Post::query()->whereSlug($slug)->firstOrFail()->comments()->withCount(['replies']);
        if ($type == 'new') {
            $comments->latest('created_at');
        }

        return $comments->paginate('10');
    }

    public function store(Request $request)
    {
        $comment = new Comment;

        $comment->comment = $request->comment;

        $comment->user()->associate(auth()->user());

        /** @var Post $post */
        $post = Post::find($request->id);

        return $post->comments()->save($comment)->load('replies');
    }

    public function replyStore(Request $request)
    {
        $reply = new Comment();

        $reply->comment = $request->get('comment');

        $reply->user()->associate(auth()->user());

        $reply->parent_id = $request->get('commentId');

        /** @var Post $post */
        $post = Post::find($request->get('id'));

        return $post->comments()->save($reply);

    }
}
