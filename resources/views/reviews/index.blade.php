@extends('layouts.app')

@section('title', 'Customer Reviews | Elm Grove Liquor')
@section('meta_description', 'Read what customers say about Elm Grove Liquor, and share your own experience.')

@section('content')
    <x-page-hero eyebrow="Reviews" title="Customer Reviews">
        @if ($reviewCount)
            <div class="mt-6 flex items-center gap-3">
                <x-stars :rating="$avgRating" size="text-2xl" />
                <p class="text-sm text-cream/80">{{ number_format($avgRating, 1) }} · Based on {{ $reviewCount }} customer {{ Str::plural('review', $reviewCount) }}</p>
            </div>
        @endif
        <x-button href="#write-review" variant="light" class="mt-8">Write a Review</x-button>
    </x-page-hero>

    <div class="container-x section">
        <x-flash />

        @if ($reviews->count())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($reviews as $review)
                    <x-review-card :review="$review" />
                @endforeach
            </div>
            <div class="mt-10">{{ $reviews->links() }}</div>
        @else
            <div class="rounded-2xl bg-white/70 px-6 py-16 text-center">
                <h3>No reviews yet.</h3>
                <p class="mt-2 text-ink/70">Be the first to share your experience.</p>
            </div>
        @endif

        <section id="write-review" class="mx-auto mt-20 max-w-2xl scroll-mt-28" aria-labelledby="wr-title">
            <h2 id="wr-title">Write a Review</h2>
            <p class="mt-2 text-sm text-ink/70">Reviews appear on the site once they have been approved. Your email is never shown.</p>

            <form method="POST" action="{{ route('reviews.store') }}" data-once novalidate class="mt-8 space-y-5">
                @csrf
                <div class="hidden" aria-hidden="true">
                    <label>Leave this field empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <x-input name="name" label="Name" required autocomplete="name" />
                <x-input name="email" label="Email" type="email" required autocomplete="email" />

                <fieldset>
                    <legend class="mb-1.5 text-sm font-semibold text-espresso">Rating <span class="text-mahogany" aria-hidden="true">*</span></legend>
                    <div class="star-rating">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" @checked((int) old('rating') === $i) required>
                            <label for="star{{ $i }}" title="{{ $i }} {{ Str::plural('star', $i) }}"><span aria-hidden="true">★</span><span class="sr-only">{{ $i }} {{ Str::plural('star', $i) }}</span></label>
                        @endfor
                    </div>
                    @error('rating')<p class="mt-1.5 text-sm text-red-700">{{ $message }}</p>@enderror
                </fieldset>

                <x-textarea name="body" label="Your review" required rows="5" />

                <x-button type="submit" data-loading="Submitting..." class="w-full sm:w-auto">Submit Review</x-button>
            </form>
        </section>
    </div>
@endsection 