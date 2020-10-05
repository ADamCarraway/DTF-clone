<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::query()->get();
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function store(Request $request, $slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        return auth()->user()->posts()->where('slug', $slug)->updateOrCreate([
            'id' => $request->get('id')
        ], [
            'title' => $request->get('title') ?? '',
            'slug' => $request->get('slug') ?? $slug,
            'intro' => $request->get('intro') ?? '',
            'category_id' => $category->id,
            'body' => $request->get('body') ?? '{}',
            'is_publish' => $request->get('is_publish') ?? 1,
        ]);
    }
}
