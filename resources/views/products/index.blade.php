@extends('layouts.app')

@section('title', 'Products | Elm Grove Liquor')
@section('meta_description', 'Browse whiskey, vodka, rum, gin, tequila, wine, beer and champagne at Elm Grove Liquor.')

@section('content')
    <x-page-hero eyebrow="Discover" title="Our Products"
                 subtitle="Browse our selection. Visit a store to find out what's available." />

    <section class="container-x section">
        <form id="product-filters" method="GET" action="{{ route('products.index') }}" role="search"
              class="grid gap-3 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1fr_auto] lg:items-center">
            <div>
                <label for="search" class="sr-only">Search products</label>
                <input id="search" type="search" name="search" value="{{ request('search') }}" placeholder="Search products..."
                       class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-4 py-3 focus:border-mahogany focus:outline-none focus:ring-2 focus:ring-mahogany/30">
            </div>

            <div>
                <label for="category" class="sr-only">Category</label>
                <select id="category" name="category" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
                    <option value="">All Categories</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->slug }}" @selected(request('category') === $c->slug)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="brand" class="sr-only">Brand</label>
                <select id="brand" name="brand" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
                    <option value="">All Brands</option>
                    @foreach ($brands as $b)
                        <option value="{{ $b }}" @selected(request('brand') === $b)>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="type" class="sr-only">Type</label>
                <select id="type" name="type" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
                    <option value="">All Types</option>
                    @foreach ($types as $t)
                        <option value="{{ $t }}" @selected(request('type') === $t)>{{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 sm:col-span-2 lg:col-span-1">
                <x-button type="submit" class="flex-1 lg:hidden">Search</x-button>
                <a id="clear-filters" href="{{ route('products.index') }}"
                   class="inline-flex min-h-12 items-center justify-center px-2 text-sm font-semibold text-mahogany underline-offset-4 hover:underline">
                    Clear Filters
                </a>
            </div>
        </form>

        <div id="product-results" class="mt-10 transition-opacity" aria-live="polite">
            @include('products._results')
        </div>
    </section>
@endsection