<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;

class LiveLentaController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return response()->json();
        }

        $comments = Comment::query()
            ->with(['user', 'post'])
            ->whereNull('parent_id')
            ->whereHas('post', function ($q) {
                $q->whereIn('category_id', auth()->user()->followings()
                    ->where('followable_type', Category::class)
                    ->pluck('followable_id'));
            })
            ->latest()
            ->limit(15)
            ->get();

        return response()->json($comments);
    }
}
