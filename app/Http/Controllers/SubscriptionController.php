<?php

namespace App\Http\Controllers;

use App\Category;

class SubscriptionController extends Controller
{
    public function store(Category $category)
    {
       return auth()->user()->subscribe($category);
    }

    public function destroy(Category $category)
    {
       return auth()->user()->subscriptions()->detach($category->id);
    }
}
