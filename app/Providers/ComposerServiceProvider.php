<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('spa', function ($view) {
            if (auth()->check()){
                $useSubs = Category::query()->whereIn('id', auth()->user()->subscriptions_ids)->get()->keyBy(function (Category $category){
                    return $category['slug'];
                });
            }

            $categories = Category::all()->keyBy(function(Category $category) {
                return $category['slug'];
            });


            $view->with('categories', $categories);
            $view->with('userSubs', $useSubs ?? []);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
