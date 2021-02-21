<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SaveCategoriesRating extends Command
{
    protected $signature = 'categories:rating-save';

    protected $description = 'Сохраняет рейтинг категории в таблицу rating_histories';

    public function handle()
    {
        $odds = Category::ODDS;

        Category::query()->select(['categories.id'])
            ->leftJoin('posts', 'categories.id', '=', 'posts.category_id')
            ->leftJoin('likes', function ($q) {
                $q->on('likes.likeable_id', 'posts.id')
                    ->where('likes.likeable_type', Post::class)
                    ->whereDate('likes.created_at', '>=', now()->subMonth()->toDateString());
            })
            ->addSelect(DB::raw("ROUND('$odds[c]'+'$odds[a]'*LOG(1+count(likes.id)), 1) as rating"))
            ->groupBy('categories.id')
            ->orderBy('rating', 'desc')
            ->get()
            ->each(function (Category $category, $key) {
                $category->ratingHistories()->create([
                    'value' => $category->rating,
                    'position' => $key + 1
                ]);
            });
    }
}
