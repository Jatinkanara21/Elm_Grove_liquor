@props(['store'])

<article class="group flex flex-col overflow-hidden rounded-2xl border border-espresso/10 bg-white/70 shadow-sm">
    <x-media :src="$store->image" :alt="$store->name" class="aspect-[16/9]" />

    <div class="flex flex-1 flex-col p-6">
        <h3>{{ $store->name }}</h3>
        <address class="mt-3 text-sm not-italic leading-relaxed text-ink/80">{{ $store->full_address }}</address>

        <ul class="mt-4 space-y-2 text-sm">
            @if ($store->phone)
                <li><a href="tel:{{ preg_replace('/[^\d+]/', '', $store->phone) }}" class="inline-flex min-h-9 items-center font-semibold text-mahogany hover:underline">{{ $store->phone }}</a></li>
            @endif
            @if ($store->email)
                <li><a href="mailto:{{ $store->email }}" class="inline-flex min-h-9 items-center break-all font-semibold text-mahogany hover:underline">{{ $store->email }}</a></li>
            @endif
            @if ($store->opening_hours)
                <li class="whitespace-pre-line text-ink/70">{{ $store->opening_hours }}</li>
            @endif
        </ul>

        <div class="mt-auto flex flex-col gap-3 pt-6 sm:flex-row">
            <x-button :href="route('stores.show', $store)" class="flex-1">View Store</x-button>
            <x-button :href="$store->directions_url" variant="outline" class="flex-1" target="_blank" rel="noopener noreferrer">Get Directions</x-button>
        </div>
    </div>
</article>
