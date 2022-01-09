<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Http\Requests\AddCommentReplyRequest;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\CategoryCommentsRequest;
use App\Http\Requests\UserCommentsRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\AddCommentNotification;
use App\Notifications\AddReplyCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function userComments(UserCommentsRequest $request, $slug)
    {
        /** @var User $user */
        $user = User::query()->whereSlug($slug)->firstOrFail();
        $comments = $user->comments()->with('post');

        if ($request->filter == 'popular') {
            $comments = $comments
                ->leftJoin('likes', function ($q) {
                    $q->on('comments.id', '=', 'likes.likeable_id')
                        ->where('likes.likeable_type', '=', Comment::class);
                })
                ->addSelect(DB::raw("count(likes.id) as likes"))
                ->groupBy('comments.id')->orderBy('likes', 'desc');
        }

        if ($request->filter == 'new') {
            $comments->latest('created_at');
        }

        return $comments->paginate('10');
    }

    public function comments(CategoryCommentsRequest $request, $slug)
    {
        $comments = Post::query()->whereSlug($slug)->firstOrFail()->comments()->withCount(['replies']);

        if ($request->type == 'old') {
            $comments->orderBy('created_at');
        }

        if ($request->type == 'popular') {
            $comments = $comments
                ->leftJoin('likes', function ($q) {
                    $q->on('comments.id', '=', 'likes.likeable_id')
                        ->where('likes.likeable_type', '=', Comment::class);
                })
                ->addSelect(DB::raw("count(likes.id) as likes"))
                ->groupBy('comments.id')->orderBy('likes', 'desc');
        }

        return $comments->paginate('10');
    }

    public function store(AddCommentRequest $request)
    {
        $comment = new Comment;

        $comment->comment = $request->comment;

        $comment->user()->associate(auth()->user());

        /** @var Post $post */
        $post = Post::find($request->id);

        /** @var Comment $saveComment */
        $saveComment = $post->comments()->save($comment)->load('post');

        event(new CommentCreated($saveComment));

        return $saveComment->load('replies');
    }

    public function replyStore(AddCommentReplyRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $reply = new Comment();

        $reply->comment = $request->comment;

        $reply->user()->associate($user);

        $reply->parent_id = $request->commentId;

        /** @var Post $post */
        $post = Post::find($request->id);

        /** @var Comment $comment */
        $comment = $post->comments()->save($reply)->load('post');

        if ($post->user->id != $user->id) {
            Comment::query()->where('id', $request->commentId)->first()->user->notify(new AddReplyCommentNotification($comment, $user));
        }

        return $reply;
    }
}
