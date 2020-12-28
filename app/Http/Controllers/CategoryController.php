<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function details($slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        return response()->json([
            'users' => $category->subscribers()->paginate(10),
            'rules' => $category->regulations
        ]);
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
