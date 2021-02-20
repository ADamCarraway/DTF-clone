<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function index($type, $filter)
    {
        $data = [
            'now' => now()->startOfMonth()->toDateString(),
            '3month' => now()->subMonths(2)->startOfMonth()->toDateString(),
            'all' => false
        ];

        return $this->$type($data[$filter]);
    }

    private function users($filter)
    {
        $odds = User::ODDS;

        return User::query()->select(['users.*'])
            ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin('likes as pl', function ($q) use ($filter) {
                $q->on('pl.likeable_id', 'posts.id')
                    ->where('pl.likeable_type', Post::class)
                    ->where(function ($b) use ($filter) {
                        if ($filter) $b->whereDate('pl.created_at', '>=', $filter);
                    });
            })
            ->addSelect(DB::raw("ROUND('$odds[c]'+'$odds[b]'*LOG(1+count(distinct pl.id, pl.likeable_type)), 1) as rating"))
            ->groupBy('users.id')->orderBy('rating', 'desc')->paginate(10);
    }

    private function categories($filter)
    {
        $odds = Category::ODDS;

        return Category::query()->select(['categories.*'])
            ->leftJoin('posts', 'categories.id', '=', 'posts.category_id')
            ->leftJoin('likes', function ($q) use ($filter) {
                $q->on('likes.likeable_id', 'posts.id')
                    ->where('likes.likeable_type', Post::class)    ->where(function ($b) use ($filter) {
                        if ($filter) $b->whereDate('likes.created_at', '>=', $filter);
                    });
            })
            ->addSelect(DB::raw("ROUND('$odds[c]'+'$odds[a]'*LOG(1+count(likes.id)), 1) as rating"))
            ->groupBy('categories.id')->orderBy('rating', 'desc')->paginate(10);
    }

    private function commentators($filter)
    {
        $odds = User::ODDS;

        return User::query()->select(['users.*'])
            ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin('likes as cl', function ($q) use ($filter) {
                $q->on('cl.likeable_id', 'comments.id')
                    ->where('cl.likeable_type', Comment::class)
                    ->where(function ($b) use ($filter) {
                        if ($filter) $b->whereDate('cl.created_at', '>=', $filter);
                    });
            })
            ->addSelect(DB::raw("ROUND('$odds[c]'+'$odds[a]'*LOG(1+count(distinct cl.id, cl.likeable_type)), 1) as rating"))
            ->groupBy('users.id')->orderBy('rating', 'desc')->paginate(10);
    }
}
