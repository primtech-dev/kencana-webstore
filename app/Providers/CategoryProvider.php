<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CategoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $categories = Cache::remember('global_categories', 3600, function () {
                return Category::where('is_active', true)
                    ->with('children')
                    ->orderBy('name', 'asc')
                    ->get();
            });
            $view->with('categoriesHeader', $categories);
        });
    }
}
