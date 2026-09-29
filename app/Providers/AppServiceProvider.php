<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


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
        // Shared by the navbar, mobile menu and footer. Route names are resolved at render time.
        View::share('navLinks', [
            ['label' => 'Home',     'route' => 'home',          'match' => 'home'],
            ['label' => 'About',    'route' => 'about',         'match' => 'about'],
            ['label' => 'Products', 'route' => 'products.index', 'match' => 'products.*'],
            ['label' => 'Events',   'route' => 'events.index',  'match' => 'events.*'],
            ['label' => 'Stores',   'route' => 'stores.index',  'match' => 'stores.*'],
            ['label' => 'Reviews',  'route' => 'reviews.index', 'match' => 'reviews.*'],
            ['label' => 'Contact',  'route' => 'contact',       'match' => 'contact'],
        ]);
        View::composer('layouts.app', function ($view) {
            $view->with('season', SeasonalTheme::current());
        });
    }
}
