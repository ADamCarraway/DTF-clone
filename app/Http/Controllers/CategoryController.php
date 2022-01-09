<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryIndexRequest;
use App\Http\Requests\CategoryPostsRequest;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function index(CategoryIndexRequest $request)
    {
        $categories = Category::query()->withCount('followers');

        if ($search = $request->search){
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

    public function posts(CategoryPostsRequest $request, $slug)
    {
        $category = Category::query()->whereSlug($slug)->firstOrFail();

        $posts = Post::query()->with(['category', 'user'])
            ->whereCategoryId($category->id);

        if ($request->filter == 'new') {
            $posts->latest('created_at');
        }

        if ($request->filter == 'popular') {
            $posts->latest('rating');
        }

        return response()->json($posts->paginate(10));
    }
}
