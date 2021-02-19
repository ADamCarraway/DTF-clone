<?php

use App\Subscription;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/tester', function () {
//
//    dd();
//
//});

//Route::get('/', function () {
//    $odds = \App\Post::ODDS;
//    $res = \App\Post::query()
//        ->leftJoin('comments', function ($q) {
//            $q->on('posts.id', '=', 'comments.commentable_id')
//                ->where('comments.commentable_type', '=', \App\Post::class);
//        })
//        ->leftJoin('views', function ($q) {
//            $q->on('posts.id', '=', 'views.viewable_id')
//                ->where('views.viewable_type', '=', \App\Post::class);
//        })
//        ->leftJoin('likes', function ($q) {
//            $q->on('posts.id', '=', 'likes.likeable_id')
//                ->where('likes.likeable_type', '=', \App\Post::class);
//        })
//        ->addSelect(DB::raw("('$odds[c]'+'$odds[a]'*LOG(1+count(DISTINCT likes.id))+'$odds[b]'*LOG(1+count(DISTINCT views.ip))+'$odds[d]'*LOG(1+count(DISTINCT comments.id))) as weight"))
//        ->groupBy('posts.id')->orderBy('weight', 'desc')->paginate(10);
//
//    //    return round(self::ODDS['c']+self::ODDS['a']*Log(1+$this->likes->count())+self::ODDS['b']*Log(1+$this->views->count())+self::ODDS['d']*Log(1+$this->comments->count()), 2);
//
//    dd($res);
//});
//$res = \App\Post::query()->select('posts.*')
//    ->leftJoin('comments', function ($q) {
//        $q->on('posts.id', '=', 'comments.commentable_id')
//            ->where('comments.commentable_type', '=', \App\Post::class);
//    })
//    ->leftJoin('views', function ($q) {
//        $q->on('posts.id', '=', 'views.viewable_id')
//            ->where('views.viewable_type', '=', \App\Post::class);
//    })
//    ->leftJoin('likes', function ($q) {
//        $q->on('posts.id', '=', 'likes.likeable_id')
//            ->where('likes.likeable_type', '=', \App\Post::class);
//    })
//    ->addSelect(DB::raw('count(comments.id) as commentsCount'))
//    ->addSelect(DB::raw('count(views.count) as viewsCount'))
//    ->addSelect(DB::raw('count(likes.id) as viewsCount'))
//    ->groupBy('posts.id')->first()->toArray();
