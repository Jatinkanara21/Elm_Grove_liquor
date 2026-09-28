<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Product;
use App\Models\Review;
use App\Models\Store;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('pages.home', [
            'categories' => Category::active()->orderBy('sort_order')->get(),
            'featured' => Product::active()->featured()->with('category')->latest()->take(4)->get(),
            'events' => Event::nextUp(3)->get(),
            'stores' => Store::active()->take(3)->get(),
            'reviews' => Review::approved()->latest()->take(3)->get(),
            'avgRating' => Review::approved()->avg('rating'),
            'reviewCount' => Review::approved()->count(),
        ]);
    }
}