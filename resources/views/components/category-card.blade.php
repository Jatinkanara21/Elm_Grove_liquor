@props(['category'])

<a href="{{ route('products.index', ['category' => $category->slug]) }}"
   class="group flex flex-col overflow-hidden rounded-2xl border border-espresso/10 bg-white/70 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
    <x-media :src="$category->image" :alt="$category->name" class="aspect-[4/3]" />
    <div class="flex flex-1 items-start justify-between gap-3 p-4 sm:p-5">
        <div>
            <h3 class="text-lg sm:text-xl">{{ $category->name }}</h3>
            @if ($category->description)
                <p class="mt-1 line-clamp-2 text-sm text-ink/70">{{ $category->description }}</p>
            @endif
        </div>
        <span class="mt-1 text-xl text-mahogany transition-transform group-hover:translate-x-1" aria-hidden="true">→</span>
    </div>
</a>