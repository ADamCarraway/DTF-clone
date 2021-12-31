<?php

namespace App\Http\Controllers;

use App\Jobs\AddPostNotificationJob;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function index($feed, $filter = null)
    {
        $odds = Post::ODDS;

        $posts = Post::query()->with(['category', 'user'])
            ->where(function ($q) use ($feed) {
                if ($feed !== 'all' && auth()->check()) {
                    $users = auth()->user()->followings()->whereFollowableType(User::class)->pluck('followable_id')->toArray();
                    $categories = auth()->user()->followings()->whereFollowableType(Category::class)->pluck('followable_id')->toArray();

                    $q->whereIn('posts.category_id', $categories)
                        ->orWhereIn('posts.user_id', $users);
                }
            });

        if (!$filter ? $feed == 'popular' : $filter == 'popular') {
            $posts = $posts->leftJoin('comments', function ($q) {
                $q->on('posts.id', '=', 'comments.commentable_id')
                    ->where('comments.commentable_type', '=', Post::class);
            })
                ->leftJoin('viewable', function ($q) {
                    $q->on('posts.id', '=', 'viewable.viewable_id')
                        ->where('viewable.viewable_type', '=', Post::class);
                })
                ->leftJoin('likes', function ($q) {
                    $q->on('posts.id', '=', 'likes.likeable_id')
                        ->where('likes.likeable_type', '=', Post::class);
                })
                ->addSelect(DB::raw("('$odds[c]'+'$odds[a]'*LOG(1+count(DISTINCT likes.id))+'$odds[b]'*LOG(1+count(DISTINCT viewable.ip))+'$odds[d]'*LOG(1+count(DISTINCT comments.id))) as weight"))
                ->groupBy('posts.id')->orderBy('weight', 'desc');

            return response()->json($posts->paginate(10));
        }

        if (!$filter ? $feed == 'new' : $filter == 'new') {
            $posts = $posts->latest('created_at');
        }

        return response()->json($posts->paginate(10));
    }

    public function show($slug)
    {
        return response()->json(Post::query()->with(['category', 'user'])->whereSlug($slug)->firstOrFail());
    }

    public function store(Request $request, $slug)
    {
        $category = null;

        if ($slug !== 'my' && $slug != auth()->user()->slug) {
            $category = Category::query()->whereSlug($slug)->firstOrFail();
        }

        $post = auth()->user()->posts()->updateOrCreate([
            'id' => $request->input('id')
        ], [
            'title'       => $request->input('title') ?? '',
            'slug'        => Str::slug($request->input('title')),
            'intro'       => $request->input('intro') ?? '',
            'category_id' => $category->id ?? null,
            'blocks'      => json_encode($request->input('blocks')),
            'is_publish'  => $request->input('is_publish') ?? 1,
        ]);

        if (!$request->input('id') && $request->input('is_publish')) {
            dispatch_now(new AddPostNotificationJob($post));
        }

        return response()->json([
            'category' => $category->slug ?? auth()->user()->slug,
            'type'     => is_null($category) ? 'user.post' : 'post',
            'post'     => $post
        ]);
    }

    public function destroy(Post $post)
    {
        return response()->json($post->delete());
    }

    public function news()
    {
        $posts = Post::query()->with('category')
            ->addSelect(DB::raw('DATE_FORMAT(posts.created_at, "%m.%d") as dateDay'))
            ->addSelect(DB::raw('DATE_FORMAT(posts.created_at, "%H:%i") as dateHour'))
            ->addSelect(DB::raw('DATE_FORMAT(posts.created_at, "%Y.%m.%d %H:%i") as newsDateFormat'))
            ->whereIsOfficial(true)
            ->latest('newsDateFormat')->paginate(4)->toArray();
        $posts['currentDate'] = now()->locale('ru')->isoFormat('D MMMM, dddd');

        return response()->json($posts);
    }

    public function repost(Post $post)
    {
        return auth()->user()->posts()->create([
            'slug'       => $post->slug,
            'parent_id'  => $post->id,
            'blocks'     => '[]',
            'is_publish' => true,
        ])->repost_count;
    }

    public function deleteRepost(Post $post)
    {
        return auth()->user()->posts()->where('parent_id', $post->id)->delete();
    }
}
