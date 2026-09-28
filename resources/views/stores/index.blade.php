@extends('layouts.app')

@section('title', 'Find a Store | Elm Grove Liquor')
@section('meta_description', 'Find an Elm Grove Liquor store, view opening hours and get directions.')

@section('content')
    <x-page-hero eyebrow="Visit Us" title="Find a Store" subtitle="Store details, opening hours and directions." />

    <section class="container-x section">
        @if ($stores->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($stores as $store)
                    <x-store-card :store="$store" />
                @endforeach
            </div>
        @else
            <div class="rounded-2xl bg-white/70 px-6 py-16 text-center">
                <h3>No stores listed yet.</h3>
                <p class="mt-2 text-ink/70">Please check back soon, or contact us.</p>
                <x-button :href="route('contact')" class="mt-6">Contact Us</x-button>
            </div>
        @endif
    </section>
@endsection