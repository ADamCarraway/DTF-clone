<?php

use App\Subscription;
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

// Route::get('/', function () {
//     dd(\App\User::query()->where('id', 2)->first()->allSubscriptions->sortBy('type')->map(function (Subscription $i) {
//         return $i->toSubFormat();
//     })->sortByDesc('date')->sortByDesc('is_favorite')->keyBy('slug')->toArray());
// });
