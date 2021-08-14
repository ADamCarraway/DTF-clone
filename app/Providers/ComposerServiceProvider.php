<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\User;
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
            if (auth()->check()) return;

            /** @var Category $categories */
            $categories = Category::query()->withCount(['followers'])->get()->keyBy('slug')->map(function (Category $category) {
                $category['subscribers'] = User::query()->whereIn('id', $category->followers()->limit(12)->pluck('id')->toArray())->get();

                return $category;
            });

            $view->with('categories', $categories);
        });

        return $this;
    }
}
