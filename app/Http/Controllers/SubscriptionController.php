<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Category $category)
    {
       return auth()->user()->subscribe($category);
    }

    public function destroy(Category $category)
    {
       return auth()->user()->subscriptions()->where('category_id', $category->id)->delete();
    }
}
