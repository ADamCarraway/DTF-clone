<?php

namespace App\Providers;

use App\Category;
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
        $this->setCategories();
    }

    private function setCategories()
    {
        view()->composer('spa', function ($view) {
            /** @var Category $categories */
            $categories = Category::query()->withCount('subscribers')->get()->keyBy('slug')->map(function (Category $category) {
                $category['subscribers'] = $category->subscribers()->limit(12)->get();

                return $category;
            });

            $view->with('categories', $categories);
        });

        return $this;
    }
}
