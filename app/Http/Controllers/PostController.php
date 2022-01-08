<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    public function index($feed, $filter = null)
    {
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
            $posts->orderBy('rating', 'desc');

            return response()->json($posts->paginate(10));
        }

        if (!$filter ? $feed == 'new' : $filter == 'new') {
            $posts = $posts->latest('created_at');
        }

        return response()->json($posts->paginate(10));
    }

    public function show($slug)
    {
        $post = Post::query()->with(['category', 'user'])->whereSlug($slug)->firstOrFail();

        if (!$post->is_publish && (!auth()->check() || !auth()->user()->is($post->user))) {
           return response()->json('', Response::HTTP_NOT_FOUND);
        }

        return response()->json($post);
    }

    public function store(Request $request, $slug)
    {
        $category = null;
        /** @var User $user */
        $user = auth()->user();

        if ($slug !== 'my' && $slug != auth()->user()->slug) {
            $category = Category::query()->whereSlug($slug)->firstOrFail();
        }

        $slug = ($request->input('id') ? $request->input('id') . '-' : '') . Str::slug($request->input('title'));

        /** @var Post $post */
        $post = $user->posts()->updateOrCreate([
            'id' => $request->input('id')
        ], [
            'title'       => $request->input('title') ?? '',
            'slug'        => $slug,
            'intro'       => $request->input('intro') ?? '',
            'category_id' => $category->id ?? null,
            'blocks'      => json_encode($request->input('blocks')),
            'is_publish'  => $request->input('is_publish') ?? 1,
        ]);

        if (!$request->input('id') && $request->input('is_publish')) {
            event(new PostCreated($post));

            $user->addNotification($post);
        }

        return response()->json([
            'category' => $category->slug ?? auth()->user()->slug,
            'type'     => is_null($category) ? 'user.post' : 'post',
            'post'     => $post
        ]);
    }

    public function unpublish(Post $post)
    {
        return response()->json($post->update(['is_publish' => false]));
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
