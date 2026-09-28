<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::when($request->filled('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
        ]);
    }

    public function approve(Review $review)
    {
        $review->update(['status' => Review::APPROVED]);

        return back()->with('success', 'Review approved.');
    }

    public function reject(Review $review)
    {
        $review->update(['status' => Review::REJECTED]);

        return back()->with('success', 'Review rejected.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}