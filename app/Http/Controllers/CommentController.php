<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comments(Request $request, $slug)
    {
        $type = $request->get('type');

        $comments = Post::query()->whereSlug($slug)->firstOrFail()->comments()->withCount(['replies']);
        if ($type == 'new'){
            $comments->latest('created_at');
        }

        return $comments->get();
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
