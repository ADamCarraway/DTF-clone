<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function index($filter, $feed = null)
    {
        $odds = \App\Post::ODDS;

        $posts = Post::query()->with(['category', 'user'])
            ->where(function ($q) use ($feed) {
                if ($feed !== 'all' && auth()->check()) {
                    $users = auth()->user()->followings()->whereFollowableType(User::class)->pluck('followable_id')->toArray();
                    $categories = auth()->user()->followings()->whereFollowableType(Category::class)->pluck('followable_id')->toArray();

                    $q->whereIn('posts.category_id', $categories)
                        ->orWhereIn('posts.user_id', $users);
                }
            });

        if ($filter == 'popular') {
            $posts = $posts->leftJoin('comments', function ($q) {
                $q->on('posts.id', '=', 'comments.commentable_id')
                    ->where('comments.commentable_type', '=', \App\Post::class);
            })
                ->leftJoin('viewable', function ($q) {
                    $q->on('posts.id', '=', 'viewable.viewable_id')
                        ->where('viewable.viewable_type', '=', \App\Post::class);
                })
                ->leftJoin('likes', function ($q) {
                    $q->on('posts.id', '=', 'likes.likeable_id')
                        ->where('likes.likeable_type', '=', \App\Post::class);
                })
                ->addSelect(DB::raw("('$odds[c]'+'$odds[a]'*LOG(1+count(DISTINCT likes.id))+'$odds[b]'*LOG(1+count(DISTINCT viewable.ip))+'$odds[d]'*LOG(1+count(DISTINCT comments.id))) as weight"))
                ->groupBy('posts.id')->orderBy('weight', 'desc');

            return response()->json($posts->paginate(10));
        }

        if ($filter == 'new') {
            $posts = $posts->latest('created_at');
        }

        return response()->json($posts->paginate(10));
    }

    public function show($slug)
    {
        return response()->json(Post::query()->with(['category', 'user'])->whereSlug($slug)->first());
    }

    public function store(Request $request, $slug)
    {
        $category = null;

        if ($slug !== 'my' && $slug != auth()->user()->slug) {
            $category = Category::query()->whereSlug($slug)->firstOrFail();
        }

        $post = auth()->user()->posts()->updateOrCreate([
            'id' => $request->get('id')
        ], [
            'title' => $request->get('title') ?? '',
            'slug' => Str::slug($request->get('title')),
            'intro' => $request->get('intro') ?? '',
            'category_id' => $category->id ?? null,
            'blocks' => json_encode($request->get('blocks')),
            'is_publish' => $request->get('is_publish') ?? 1,
        ]);

        return response()->json([
            'category' => $category->slug ?? auth()->user()->slug,
            'type' => is_null($category) ? 'user.post' : 'post',
            'post' => $post
        ]);
    }

    public function news()
    {
        $posts = Post::query()->with('category')
            ->addSelect(DB::raw('DATE_FORMAT(posts.created_at, "%m.%d") as dateDay'))
            ->addSelect(DB::raw('DATE_FORMAT(posts.created_at, "%H:%i") as dateHour'))
            ->addSelect(DB::raw('DATE_FORMAT(posts.created_at, "%Y.%m.%d %H:%i") as newsDateFormat'))
            ->whereIsOfficial(true)
            ->latest('newsDateFormat')->paginate(4)->toArray();
        $posts['currentDate'] = now()->locale('ru')->isoFormat('D MMMM , dddd');

        return response()->json($posts);
    }
}
