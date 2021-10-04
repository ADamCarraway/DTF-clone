<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');

    Route::post('settings/profile', 'Settings\ProfileController@update');
    Route::post('settings/profile/avatar/update', 'Settings\ProfileController@avatarUpdate');
    Route::post('settings/password', 'Settings\PasswordController@update');

    Route::post('oauth/{driver}/attach', 'Auth\OAuthController@redirectToProvider')->name('oauth.attach');
    Route::post('oauth/{driver}/detach', 'Auth\OAuthController@detach')->name('oauth.detach');

    Route::post('follow', 'FollowController@store')->name('follow.store');
    Route::delete('unfollow', 'FollowController@destroy')->name('follow.destroy');

    Route::get('/notification', 'NotificationController@index')->name('notification.index');
    Route::post('/notification', 'NotificationController@store')->name('notification.store');
    Route::delete('/notification', 'NotificationController@destroy')->name('notification.destroy');
    Route::post('/notification/readAll', 'NotificationController@readAll')->name('notification.readAll');

    Route::post('/ignore', 'IgnoreController@store')->name('ignore.store');
    Route::delete('/ignore', 'IgnoreController@destroy')->name('ignore.destroy');

    Route::post('/{slug}/{type}/favorite/store', 'FavoriteController@store')->name('favorite.store');
    Route::delete('/{slug}/{type}/favorite/destroy', 'FavoriteController@destroy')->name('favorite.destroy');

    Route::post('file/upload', 'CloudderController@upload');
    Route::post('file/destroy', 'CloudderController@destroy');

    Route::post('like', 'LikeController@like');
    Route::delete('like', 'LikeController@dislike');

    Route::post('bookmark', 'BookmarkController@create');
    Route::delete('bookmark', 'BookmarkController@destroy');

    Route::post('/comment/store', 'CommentController@store')->name('comment.add');
    Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');

    Route::post('/repost/{post}', 'PostController@repost')->name('post.repost.store');
    Route::delete('/repost/{post}', 'PostController@deleteRepost')->name('post.repost.destroy');
    Route::post('/{slug}/posts/store', 'PostController@store')->name('post.store');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');
});

Route::get('posts/{feed?}/{filter?}', 'PostController@index')->name('posts.index');
Route::get('news', 'PostController@news')->name('posts.news');
Route::get('/post/{slug}', 'PostController@show')->name('post.show')->middleware(['visitor']);
Route::get('/rating/{type}/{filter}', 'RatingController@index')->name('rating.index');

Route::get('u/{slug}', 'Auth\UserController@show')->name('user.show');

Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');

Route::get('/subs', 'CategoryController@index')->name('subs.index');
Route::get('/subs/{sug}', 'CategoryController@show')->name('subs.show');
Route::get('/subs/{sug}/regulation', 'CategoryController@regulation')->name('subs.regulation');

Route::get('/{slug}/posts', 'CategoryController@posts')->name('category.posts');

Route::get('/post/{slug}/comments', 'CommentController@comments')->name('comment.index');



Route::get('/{slug}/details', 'CategoryController@details')->name('category.details');
Route::get('/{slug}/details/subscribers', 'CategoryController@subscribers')->name('category.subscribers');

Route::get('u/{slug}/details', 'Auth\UserController@details')->name('user.details');
Route::get('u/{slug}/details/subscribers', 'Auth\UserController@subscribers')->name('user.subscribers');
Route::get('u/{slug}/details/subscriptions', 'Auth\UserController@subscriptions')->name('user.subscriptions');
Route::get('u/{slug}/posts', 'Auth\UserController@posts')->name('user.posts');
Route::get('u/{slug}/comments', 'CommentController@userComments')->name('comment.userComments');
Route::get('u/{slug}/favorites', 'BookmarkController@index')->name('bookmark.index');
