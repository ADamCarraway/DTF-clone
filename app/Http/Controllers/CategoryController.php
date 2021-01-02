<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->withCount('subscribers');

        if ($search = $request->input('search', '')){
            $categories = $categories->where('title','like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        return $categories->get()->keyBy('slug');
    }

    public function details($slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        return response()->json([
            'users' => $category->subscribers()->paginate(10),
            'rules' => $category->regulations
        ]);
    }

    public function show($slug)
    {
        $category = Category::query()->withCount('subscribers')->whereSlug($slug)->firstOrFail();
        $category['subscribers'] = $category->subscribers()->limit(12)->get();

        return response()->json($category);
    }

    public function regulation($slug)
    {
        return response()->json(Category::query()->withoutGlobalScopes()->whereSlug($slug)->firstOrFail()->regulations ?? '');
    }

    public function subscribers($slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        return response()->json($category->subscribers()->paginate(10));
    }

    public function posts(Request $request, $slug)
    {
        $category = Category::query()->whereSlug($slug)->firstOrFail();

        $type = $request->get('type');

        $posts = Post::query()->with(['category', 'user'])
            ->whereCategoryId($category->id);

        if ($type == 'new') {
            $posts->latest('created_at');
        }

        return response()->json($posts->paginate(10));
    }
}
