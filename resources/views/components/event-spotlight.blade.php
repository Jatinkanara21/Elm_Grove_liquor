@props(['event'])

@php
    $accent = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $event->accent_color) ? $event->accent_color : '#8B4513';
@endphp

<article class="group grid overflow-hidden rounded-3xl bg-espresso text-cream shadow-xl lg:grid-cols-2"
         style="border-top: 4px solid {{ $accent }}">
    <a href="{{ route('events.show', $event) }}" tabindex="-1" aria-hidden="true" class="block">
        <x-media :src="$event->hero_image ?: $event->thumbnail_image" :alt="$event->title" :label="$event->title"
                 class="aspect-[16/10] lg:aspect-auto lg:h-full lg:min-h-[22rem]" />
    </a>

    <div class="flex flex-col justify-center p-8 sm:p-12">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold">Next Up · {{ $event->status_label }}</p>
        <h3 class="mt-3 text-3xl !text-cream sm:text-4xl">{{ $event->title }}</h3>
        <p class="mt-2 text-sm font-medium text-cream/70">{{ $event->display_date }}</p>
        @if ($event->headline)
            <p class="mt-5 font-serif text-xl italic text-cream/90">{{ $event->headline }}</p>
        @endif
        <x-button :href="route('events.show', $event)" variant="light" class="mt-8 self-start">View Event</x-button>
    </div>
</article>