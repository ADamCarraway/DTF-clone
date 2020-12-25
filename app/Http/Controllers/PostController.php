<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');

        $posts = Post::query()->with(['category', 'user']);

        if ($type == 'new'){
            $posts->latest();
        }

        return response()->json($posts->paginate(10));
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function store(Request $request, $slug)
    {
        $category = null;

        if ($slug === 'my' && $slug != auth()->user()->slug) {
            $category = Category::query()->where('slug', $slug)->firstOrFail();
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
}
