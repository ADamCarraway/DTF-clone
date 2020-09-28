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
            $view->with('categories', Category::all()->keyBy('slug')->map(function (Category $category){
                $category['isSub'] = auth()->check() ? auth()->user()->categories->where('id', $category->id)->count() != 0 : false;

                return $category;
            }));
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
