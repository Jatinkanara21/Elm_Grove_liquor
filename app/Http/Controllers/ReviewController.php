<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return view('reviews.index', [
            'reviews' => Review::approved()->latest()->paginate(9),
            'avgRating' => Review::approved()->avg('rating'),
            'reviewCount' => Review::approved()->count(),
        ]);
    }

    public function store(StoreReviewRequest $request)
    {
        $message = 'Thank you! Your review was submitted and will appear once it has been approved.';

        // Honeypot: bots fill the hidden field. Pretend success and store nothing.
        if ($request->filled('website')) {
            return redirect()->route('reviews.index')->with('success', $message);
        }

        Review::create($request->validated() + [
            'status' => Review::PENDING,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('reviews.index')->with('success', $message);
    }
}