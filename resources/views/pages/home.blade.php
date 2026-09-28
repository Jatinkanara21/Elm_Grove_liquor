@extends('layouts.app')

@section('title', 'Elm Grove Liquor | Premium Spirits, Wine & Beverages')

@section('content')
    {{-- HERO --}}
    <section class="relative isolate overflow-hidden bg-espresso text-cream">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,rgba(139,69,19,0.55),transparent_60%)]"></div>
        <div class="container-x py-20 sm:py-28 lg:py-36">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold">Premium Selection</p>
            <h1 class="mt-4 max-w-3xl !text-cream">Raise Your Standards.</h1>
            <p class="mt-6 max-w-xl text-base leading-relaxed text-cream/80 sm:text-lg">
                Discover quality spirits, wines, and beverages at Elm Grove Liquor.
            </p>
            <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                <x-button :href="route('products.index')" variant="light" class="w-full sm:w-auto">Explore Products</x-button>
                <x-button :href="route('stores.index')" variant="outline-light" class="w-full sm:w-auto">Find a Store</x-button>
            </div>
        </div>
    </section>

    {{-- CATEGORIES --}}
    @if ($categories->isNotEmpty())
        <section class="section" aria-labelledby="cat-title">
            <div class="container-x">
                <p class="eyebrow">Browse</p>
                <h2 id="cat-title" class="mt-2">Featured Categories</h2>
                <div class="mt-10 grid grid-cols-2 gap-4 sm:gap-6 md:grid-cols-3 lg:grid-cols-4">
                    @foreach ($categories as $category)
                        <x-category-card :category="$category" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- FEATURED PRODUCTS --}}
    @if ($featured->isNotEmpty())
        <section class="section bg-beige/50" aria-labelledby="feat-title">
            <div class="container-x">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="eyebrow">Selection</p>
                        <h2 id="feat-title" class="mt-2">Featured Products</h2>
                    </div>
                    <x-button :href="route('products.index')" variant="outline">View All</x-button>
                </div>
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featured as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ABOUT --}}
    <section class="section bg-espresso text-cream" aria-labelledby="about-title">
        <div class="container-x grid items-center gap-10 lg:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold">About</p>
                <h2 id="about-title" class="mt-3 !text-cream">Elm Grove Liquor</h2>
                <p class="mt-5 max-w-lg leading-relaxed text-cream/80">
                    A welcoming neighborhood destination for quality spirits, wines, and beverages. Browse the selection
                    online, then visit us in store.
                </p>
                <x-button :href="route('about')" variant="light" class="mt-8">Learn More</x-button>
            </div>

            <ul class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                @foreach ([
                    ['Curated Selection', 'Spirits, wines, beer and more, chosen with care.'],
                    ['Local & Welcoming', 'A friendly, professional experience in store.'],
                    ['Easy to Find', 'Store details, hours and directions in one place.'],
                ] as [$title, $text])
                    <li class="rounded-2xl border border-gold/20 bg-cream/5 p-5">
                        <h3 class="font-sans text-base font-semibold !text-gold">{{ $title }}</h3>
                        <p class="mt-1 text-sm text-cream/75">{{ $text }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

      {{-- WHAT'S COMING UP --}}
        @if ($events->isNotEmpty())
            <section class="section" aria-labelledby="events-title">
                <div class="container-x">
                    <div class="flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <p class="eyebrow">Events &amp; Celebrations</p>
                            <h2 id="events-title" class="mt-2">What's Coming Up</h2>
                        </div>
                        <x-button :href="route('events.index')" variant="outline">All Events</x-button>
                    </div>

                    <div class="mt-10">
                        <x-event-spotlight :event="$events->first()" />
                    </div>

                    @if ($events->count() > 1)
                        <div class="mt-6 grid gap-6 md:grid-cols-2">
                            @foreach ($events->skip(1) as $event)
                                <x-event-card :event="$event" />
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endif
        
    {{-- STORE LOCATOR --}}
    <section class="section bg-beige/50" aria-labelledby="stores-title">
        <div class="container-x">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Visit Us</p>
                    <h2 id="stores-title" class="mt-2">Find a Store</h2>
                </div>
                <x-button :href="route('stores.index')" variant="outline">All Stores</x-button>
            </div>

            @if ($stores->isNotEmpty())
                <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($stores as $store)
                        <x-store-card :store="$store" />
                    @endforeach
                </div>
            @else
                <p class="mt-8 max-w-md text-ink/70">Store locations will be listed here soon.</p>
            @endif
        </div>
    </section>

    {{-- REVIEWS --}}
    <section class="section" aria-labelledby="rev-title">
        <div class="container-x">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Reviews</p>
                    <h2 id="rev-title" class="mt-2">What Customers Say</h2>
                    @if ($reviewCount)
                        <p class="mt-3 flex items-center gap-2 text-sm text-ink/70">
                            <x-stars :rating="$avgRating" />
                            <span>{{ number_format($avgRating, 1) }} from {{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</span>
                        </p>
                    @endif
                </div>
                <x-button :href="route('reviews.index')" variant="outline">All Reviews</x-button>
            </div>

            @if ($reviews->isNotEmpty())
                <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($reviews as $review)
                        <x-review-card :review="$review" />
                    @endforeach
                </div>
            @else
                <p class="mt-8 text-ink/70">No reviews yet. Be the first to share your experience.</p>
            @endif
        </div>
    </section>

    {{-- CONTACT CTA --}}
    <section class="bg-mahogany py-16 text-center text-cream">
        <div class="container-x">
            <h2 class="!text-cream">Questions? We'd love to hear from you.</h2>
            <x-button :href="route('contact')" variant="light" class="mt-8">Contact Us</x-button>
        </div>
    </section>
@endsection