<p class="mb-6 text-sm font-semibold text-ink/70">
    {{ $products->total() }} {{ Str::plural('Product', $products->total()) }} Found
</p>

@if ($products->count())
    <div class="grid grid-cols-1 gap-6 min-[480px]:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>

    <div class="mt-10">{{ $products->links() }}</div>
@else
    <div class="rounded-2xl bg-white/70 px-6 py-16 text-center">
        <h3>No products found.</h3>
        <p class="mt-2 text-ink/70">Try changing your search or filters.</p>
    </div>
@endif