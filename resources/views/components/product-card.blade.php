@props(['product'])

<article class="group flex flex-col overflow-hidden rounded-2xl border border-espresso/10 bg-white/70 shadow-sm backdrop-blur transition duration-300 hover:-translate-y-1 hover:shadow-xl">
    <a href="{{ route('products.show', $product) }}" class="block" tabindex="-1" aria-hidden="true">
        <x-media :src="$product->image" :alt="$product->name" :label="$product->brand" class="aspect-[4/5]" />
    </a>

    <div class="flex flex-1 flex-col p-5">
        @if ($product->brand)<p class="eyebrow">{{ $product->brand }}</p>@endif
        <h3 class="mt-1 text-xl">
            <a href="{{ route('products.show', $product) }}" class="hover:text-mahogany">{{ $product->name }}</a>
        </h3>
        @if ($product->category)
            <p class="mt-1 text-xs uppercase tracking-wider text-ink/60">{{ $product->category->name }}</p>
        @endif
        @if ($product->short_description)
            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-ink/70">{{ $product->short_description }}</p>
        @endif

        <div class="mt-auto pt-5">
            <x-button :href="route('products.show', $product)" variant="outline" class="w-full">View Details</x-button>
        </div>
    </div>
</article>