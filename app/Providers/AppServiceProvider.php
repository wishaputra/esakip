<?php

namespace App\Providers;

use App\Models\Frontend;
use App\Models\Logo;
use App\Models\Menu;
use App\Models\TextContent;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
        View::composer('front.index', function ($view) {
            $view->with('textContent', TextContent::all());
        });
        View::composer('front.basic', function ($view) {
            $view->with('textContent', TextContent::all());
        });
        View::composer('front.page', function ($view) {
            $view->with('textContent', TextContent::all());
        });
        View::composer(['front.partials._head_tag', 'front.partials._navigation'], function ($view) {
            $view->with('logo', Logo::first());
        });
        Paginator::useBootstrap();
    }
}
