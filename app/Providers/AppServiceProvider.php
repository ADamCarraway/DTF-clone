<?php

namespace App\Providers;

use App\Notifications\AddCommentNotification;
use App\Notifications\AddFollowNotification;
use App\Notifications\AddLikeNotification;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningUnitTests()) {
            Schema::defaultStringLength(191);
        }
//
//        Relation::morphMap([
//            'add-comment' => AddCommentNotification::class,
//            'add-follow'  => AddFollowNotification::class,
//            'add-like'    => AddLikeNotification::class
//        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing') && class_exists(DuskServiceProvider::class)) {
            $this->app->register(DuskServiceProvider::class);
        }

        $this->app->register(ComposerServiceProvider::class);
    }
}
