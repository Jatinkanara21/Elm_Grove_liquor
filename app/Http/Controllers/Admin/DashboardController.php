<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Product;
use App\Models\Review;
use App\Models\Store;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $unread = ContactMessage::unread()->count();

        // [label, value, route, note]
        $stats = [
            ['Total Products', Product::count(), 'admin.products.index', null],
            ['Total Categories', Category::count(), 'admin.categories.index', null],
            ['Total Stores', Store::count(), 'admin.stores.index', null],
            ['Pending Reviews', Review::pending()->count(), 'admin.reviews.index', null],
            ['Approved Reviews', Review::approved()->count(), 'admin.reviews.index', null],
            ['Contact Messages', ContactMessage::count(), 'admin.messages.index', $unread . ' unread'],
            ['Upcoming Events', Event::upcoming()->count(), 'admin.events.index', null],
        ];

        return view('admin.dashboard', compact('stats'));
    }
}