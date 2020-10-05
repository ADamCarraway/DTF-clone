<?php

namespace App\Http\Controllers;

use App\Category;
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

    public function posts($slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        return $category->posts()->paginate(10);
    }
}
