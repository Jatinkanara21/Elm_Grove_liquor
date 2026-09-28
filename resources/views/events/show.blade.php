@extends('layouts.app')

@php
    $accent = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $event->accent_color) ? $event->accent_color : '#8B4513';
    $status = $event->status;
    $badge = ['upcoming' => 'bg-cream/15 text-cream', 'today' => 'bg-gold text-espresso', 'past' => 'bg-cream/10 text-cream/60'][$status];
    $heroImage = $event->hero_image ?: $event->banner_image;
    $commemorative = $event->is_commemorative;

    // Structured data only for events that really happen at a store; holidays are not store events.
    $eventSchema = null;
    if (in_array($event->event_type, ['store_event', 'special_event'], true) && $store && $store->address) {
        $eventSchema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event->title,
            'description' => $event->short_description,
            'startDate' => $event->event_date->toDateString(),
            'endDate' => ($event->end_date ?? $event->event_date)->toDateString(),
            'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
            'location' => ['@type' => 'Place', 'name' => $store->name, 'address' => $store->full_address],
            'url' => route('events.show', $event),
        ]);
    }
@endphp

@section('title', $event->meta_title ?: $event->title . ' | Elm Grove Liquor')
@section('meta_description', $event->meta_description ?: $event->short_description)
@if ($heroImage)
    @section('og_image', asset('storage/' . $heroImage))
@endif

@if ($eventSchema)
    @push('head')
        <script type="application/ld+json">{!! json_encode($eventSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endpush
@endif

@section('content')
    @unless ($event->is_published)
        <div class="bg-gold px-4 py-2 text-center text-sm font-semibold text-espresso" role="status">
            Preview: this event is not currently visible to the public.
        </div>
    @endunless

    {{-- HERO --}}
    <section class="relative isolate overflow-hidden text-cream"
             style="background: linear-gradient(135deg, #1C1107 45%, {{ $accent }}99)">
        @if ($heroImage)
            <img src="{{ asset('storage/' . $heroImage) }}" alt="" class="absolute inset-0 -z-10 size-full object-cover opacity-40">
            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-espresso via-espresso/60 to-transparent"></div>
        @endif

        <div class="container-x py-20 sm:py-28 lg:py-36">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-xs font-semibold uppercase tracking-[0.3em] text-gold">{{ $event->type_label }}</span>
                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">{{ $event->status_label }}</span>
            </div>

            <h1 class="mt-4 max-w-3xl !text-cream">{{ $event->title }}</h1>
            <p class="mt-4 text-lg font-medium text-cream/80">{{ $event->display_date }}</p>

            @if ($event->headline && $event->headline !== $event->title)
                <p class="mt-6 max-w-2xl font-serif text-2xl italic text-cream/90 sm:text-3xl">{{ $event->headline }}</p>
            @endif
        </div>
    </section>

    <div class="container-x section grid gap-12 lg:grid-cols-[1.6fr_1fr]">
        <div>
            @if ($event->show_countdown && $status === 'upcoming')
                <div data-countdown="{{ $event->event_date->toDateString() }}" role="timer" aria-label="Time until {{ $event->title }}"
                     class="mb-10 grid grid-cols-4 gap-3 text-center">
                    @foreach (['days' => 'Days', 'hours' => 'Hours', 'minutes' => 'Minutes', 'seconds' => 'Seconds'] as $unit => $label)
                        <div class="rounded-2xl bg-espresso px-2 py-4 text-cream">
                            <span data-unit="{{ $unit }}" class="block font-serif text-3xl font-bold sm:text-4xl">0</span>
                            <span class="mt-1 block text-[0.65rem] uppercase tracking-widest text-cream/60">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <h2 class="!text-3xl">About this {{ $event->event_type === 'promotion' ? 'Promotion' : 'Event' }}</h2>
            <div class="mt-5 whitespace-pre-line leading-relaxed text-ink/80">{{ $event->description ?: $event->short_description }}</div>

            @if ($event->button_text && $event->button_url)
                <x-button :href="$event->button_url" class="mt-8">{{ $event->button_text }}</x-button>
            @endif
        </div>

        <aside class="space-y-6">
            <div class="rounded-2xl border border-espresso/10 bg-white/70 p-6" style="border-top: 4px solid {{ $accent }}">
                <h2 class="!text-xl">Event Information</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="eyebrow">Date</dt>
                        <dd class="mt-1 text-ink/80">{{ $event->display_date }}</dd>
                    </div>
                    <div>
                        <dt class="eyebrow">Type</dt>
                        <dd class="mt-1 text-ink/80">{{ $event->type_label }}</dd>
                    </div>
                    <div>
                        <dt class="eyebrow">Status</dt>
                        <dd class="mt-1 text-ink/80">{{ $event->status_label }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Commemorative days get a quiet, non-promotional note instead of a shopping prompt. --}}
            <div class="rounded-2xl bg-espresso p-6 text-cream">
                @if ($commemorative)
                    <h2 class="!text-xl !text-cream">Visit Us</h2>
                    <p class="mt-3 text-sm text-cream/75">Find your nearest store and its opening hours.</p>
                    <x-button :href="route('stores.index')" variant="light" class="mt-5 w-full">Find a Store</x-button>
                @else
                    <h2 class="!text-xl !text-cream">Planning a Celebration?</h2>
                    <p class="mt-3 text-sm text-cream/75">Browse our selection, then visit a store.</p>
                    <div class="mt-5 flex flex-col gap-3">
                        <x-button :href="route('products.index')" variant="light" class="w-full">Explore Products</x-button>
                        <x-button :href="route('stores.index')" variant="outline-light" class="w-full">Find a Store</x-button>
                    </div>
                @endif
            </div>
        </aside>
    </div>

    @if ($related->isNotEmpty())
        <section class="bg-beige/50 pb-16 pt-16 sm:pb-20 sm:pt-20" aria-labelledby="related-events">
            <div class="container-x">
                <h2 id="related-events">Related Events</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-event-card :event="$item" />
                    @endforeach
                </div>
                <div class="mt-8 flex flex-wrap gap-4 text-sm font-semibold">
                    <a href="{{ route('events.index') }}" class="text-mahogany hover:underline">All events →</a>
                    <a href="{{ route('events.archive') }}" class="text-mahogany hover:underline">Archive →</a>
                </div>
            </div>
        </section>
    @endif
@endsection