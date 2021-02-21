<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SaveUsersRating extends Command
{
    protected $signature = 'user:rating-save';

    protected $description = 'Сохраняет рейтинг пользователя в таблицу rating_histories';

    public function handle()
    {
        $odds = User::ODDS;

        User::query()->select(['users.id'])
            ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin('likes as pl', function ($q) {
                $q->on('pl.likeable_id', 'posts.id')
                    ->where('pl.likeable_type', Post::class)
                    ->whereDate('pl.created_at', '>=', now()->subMonth()->toDateString());
            })
            ->addSelect(DB::raw("ROUND('$odds[c]'+'$odds[b]'*LOG(1+count(distinct pl.id, pl.likeable_type)), 1) as rating"))
            ->groupBy('users.id')
            ->orderBy('rating', 'desc')
            ->get()
            ->each(function (User $user, $key) {
                $user->ratingHistories()->create([
                    'value' => $user->rating,
                    'position' => $key + 1
                ]);
            });
    }
}
