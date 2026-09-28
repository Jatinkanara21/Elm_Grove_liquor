<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::view('/about', 'pages.about')->name('about');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{store}', [StoreController::class, 'show'])->name('stores.show');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->middleware('throttle:3,10')->name('reviews.store');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:3,10')->name('contact.store');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/archive', [EventController::class, 'archive'])->name('events.archive');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Temporary placeholders until legal pages are written.
Route::view('/privacy-policy', 'pages.placeholder', ['title' => 'Privacy Policy'])->name('privacy');
Route::view('/terms', 'pages.placeholder', ['title' => 'Terms'])->name('terms');

require __DIR__ . '/admin.php';

Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    $robots = "User-agent: *\n";
    $robots .= "Allow: /\n";
    $robots .= "Disallow: /admin\n";
    $robots .= "Disallow: /admin/*\n";
    $robots .= "\n";
    $robots .= "Sitemap: " . route('sitemap') . "\n";

    return response($robots)->header('Content-Type', 'text/plain');
})->name('robots');

Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');