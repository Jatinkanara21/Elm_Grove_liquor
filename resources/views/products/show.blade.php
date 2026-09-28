@extends('layouts.app')

@section('title', $product->name . ' | Elm Grove Liquor')
@section('meta_description', \Illuminate\Support\Str::limit($product->short_description ?: strip_tags((string) $product->description), 155))
@if ($product->image)
    @section('og_image', asset('storage/' . $product->image))
@endif

@section('content')
    <div class="container-x section">
        <nav aria-label="Breadcrumb" class="mb-8 text-sm text-ink/60">
            <a href="{{ route('products.index') }}" class="hover:text-mahogany">Products</a>
            @if ($product->category)
                <span aria-hidden="true"> / </span>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-mahogany">{{ $product->category->name }}</a>
            @endif
        </nav>

        <div class="grid gap-10 lg:grid-cols-2 lg:gap-16">
            <x-media :src="$product->image" :alt="$product->name" :label="$product->brand" class="aspect-[4/5] rounded-3xl shadow-xl" />

            <div>
                @if ($product->brand)<p class="eyebrow">{{ $product->brand }}</p>@endif
                <h1 class="mt-2 !text-4xl sm:!text-5xl">{{ $product->name }}</h1>
                @if ($product->category)
                    <p class="mt-3 text-sm uppercase tracking-wider text-ink/60">{{ $product->category->name }}</p>
                @endif

                @if ($product->description)
                    <p class="mt-6 whitespace-pre-line leading-relaxed text-ink/80">{{ $product->description }}</p>
                @endif

                @php
                    $info = array_filter([
                        'Type' => $product->type,
                        'Country' => $product->country,
                        'Region' => $product->region,
                        'Alcohol' => $product->alcohol_percentage !== null ? rtrim(rtrim((string) $product->alcohol_percentage, '0'), '.') . '% ABV' : null,
                        'Bottle Size' => $product->bottle_size,
                    ]);
                @endphp

                @if ($info)
                    <h2 class="mt-10 !text-2xl">Product Information</h2>
                    <dl class="mt-4 divide-y divide-espresso/10 rounded-2xl border border-espresso/10 bg-white/70">
                        @foreach ($info as $label => $value)
                            <div class="flex justify-between gap-4 px-5 py-3 text-sm">
                                <dt class="font-semibold text-espresso">{{ $label }}</dt>
                                <dd class="text-right text-ink/80">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif

                <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                    <x-button :href="route('products.index')" variant="outline">Back to Products</x-button>
                    <x-button :href="route('stores.index')">Find a Store</x-button>
                </div>
            </div>
        </div>

        @if ($related->isNotEmpty())
            <section class="mt-20" aria-labelledby="related-title">
                <h2 id="related-title">You May Also Like</h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($related as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection