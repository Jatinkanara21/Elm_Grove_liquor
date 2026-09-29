<?php

namespace App\Providers;

use App\Support\SeasonalTheme;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Shared Navigation Links
        |--------------------------------------------------------------------------
        |
        | These links are available throughout the application.
        |
        */

        View::share('navLinks', [
            [
                'label' => 'Home',
                'route' => 'home',
                'match' => 'home',
            ],
            [
                'label' => 'About',
                'route' => 'about',
                'match' => 'about',
            ],
            [
                'label' => 'Products',
                'route' => 'products.index',
                'match' => 'products.*',
            ],
            [
                'label' => 'Events',
                'route' => 'events.index',
                'match' => 'events.*',
            ],
            [
                'label' => 'Stores',
                'route' => 'stores.index',
                'match' => 'stores.*',
            ],
            [
                'label' => 'Reviews',
                'route' => 'reviews.index',
                'match' => 'reviews.*',
            ],
            [
                'label' => 'Contact',
                'route' => 'contact',
                'match' => 'contact',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Seasonal Theme
        |--------------------------------------------------------------------------
        |
        | SeasonalTheme is located in App\Support.
        |
        */

        View::composer('layouts.app', function ($view) {
            $view->with(
                'season',
                SeasonalTheme::current()
            );
        });
    }
}