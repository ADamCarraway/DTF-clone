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
            $categories = Category::query()->withCount('subscribers')->get()->keyBy('slug')->map(function (Category $category) {
                $category['subscribers'] = $category->subscribers()->limit(12)->get();

                return $category;
            });

            $view->with('categories', $categories);
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
