@extends('layouts.app')

@section('title', $store->name . ' | Elm Grove Liquor')
@section('meta_description', 'Visit ' . $store->name . ' at ' . $store->full_address . '.')

@php
    $key = config('services.google.maps_key');
    $mapSrc = null;

    if ($key && $store->latitude && $store->longitude) {
        $mapSrc = 'https://www.google.com/maps/embed/v1/place?key=' . $key . '&q=' . $store->latitude . ',' . $store->longitude;
    } elseif ($store->address) {
        // Keyless fallback so the map still shows when no API key is configured.
        $mapSrc = 'https://maps.google.com/maps?q=' . urlencode($store->full_address) . '&output=embed';
    }
@endphp

@section('content')
    <x-page-hero eyebrow="Store" :title="$store->name" :subtitle="$store->full_address" />

    <div class="container-x section grid gap-10 lg:grid-cols-[1fr_1.4fr]">
        <div class="space-y-8">
            <x-media :src="$store->image" :alt="$store->name" class="aspect-[16/10] rounded-3xl shadow-lg" />

            <dl class="space-y-5 text-sm">
                <div>
                    <dt class="eyebrow">Address</dt>
                    <dd class="mt-1"><address class="not-italic text-ink/80">{{ $store->full_address }}</address></dd>
                </div>
                @if ($store->phone)
                    <div>
                        <dt class="eyebrow">Phone</dt>
                        <dd class="mt-1"><a href="tel:{{ preg_replace('/[^\d+]/', '', $store->phone) }}" class="inline-flex min-h-9 items-center font-semibold text-mahogany hover:underline">{{ $store->phone }}</a></dd>
                    </div>
                @endif
                @if ($store->email)
                    <div>
                        <dt class="eyebrow">Email</dt>
                        <dd class="mt-1"><a href="mailto:{{ $store->email }}" class="inline-flex min-h-9 items-center break-all font-semibold text-mahogany hover:underline">{{ $store->email }}</a></dd>
                    </div>
                @endif
                @if ($store->opening_hours)
                    <div>
                        <dt class="eyebrow">Opening Hours</dt>
                        <dd class="mt-1 whitespace-pre-line text-ink/80">{{ $store->opening_hours }}</dd>
                    </div>
                @endif
            </dl>

            <div class="flex flex-col gap-3 sm:flex-row">
                <x-button :href="$store->directions_url" target="_blank" rel="noopener noreferrer">Get Directions</x-button>
                <x-button :href="route('contact')" variant="outline">Contact</x-button>
            </div>
        </div>

        @if ($mapSrc)
            <div class="overflow-hidden rounded-3xl border border-espresso/10 shadow-lg">
                <iframe src="{{ $mapSrc }}" title="Map showing {{ $store->name }}" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" allowfullscreen
                        class="h-80 w-full sm:h-96 lg:h-full lg:min-h-[28rem]"></iframe>
            </div>
        @endif
    </div>
@endsection