<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->withCount('followers');

        if ($search = $request->input('search', '')){
            $categories = $categories->where('title','like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        return $categories->get()->keyBy('slug');
    }

    public function details($slug)
    {
        /** @var Category $category */
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        return response()->json([
            'users' => $category->followers()->with('follower')->limit(6)->get()->pluck('follower'),
            'rules' => $category->regulations
        ]);
    }

    public function show($slug)
    {
        $category = Category::query()->withCount('followers')->whereSlug($slug)->firstOrFail();
        $category['subscribers'] = $category->followers()->with('follower')->limit(12)->get()->pluck('follower');

        return response()->json($category);
    }

    public function regulation($slug)
    {
        return response()->json(Category::query()->withoutGlobalScopes()->whereSlug($slug)->firstOrFail()->regulations ?? '');
    }

    public function subscribers($slug)
    {
        /** @var Category $category */
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        $paginator = tap($category->followers()->with('follower')->paginate(10),function($paginatedInstance){
            return $paginatedInstance->getCollection()->transform(function ($follower) {
                return $follower->follower;
            });
        });

        return response()->json($paginator);
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
