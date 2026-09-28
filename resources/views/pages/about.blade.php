@extends('layouts.app')

@section('title', 'About | Elm Grove Liquor')
@section('meta_description', 'Learn about Elm Grove Liquor, our selection and our mission.')

@section('content')
    <x-page-hero eyebrow="About" title="Premium Selection. Elegant Experience." />

    <div class="container-x section space-y-16 lg:space-y-24">
        @foreach ([
            ['Our Story', 'Elm Grove Liquor is a local destination built around quality, service and a welcoming experience.'],
            ['Our Selection', 'From whiskey, vodka, rum, gin and tequila to wine, beer and champagne, our selection is chosen with care.'],
            ['Our Mission', 'To help every customer find the right bottle for the occasion, with friendly and knowledgeable service.'],
        ] as $i => [$title, $text])
            <section class="grid items-center gap-8 lg:grid-cols-2 {{ $i % 2 ? 'lg:[&>*:first-child]:order-2' : '' }}" aria-labelledby="s{{ $i }}">
                <x-media alt="{{ $title }}" label="{{ $title }}" class="aspect-[4/3] rounded-3xl" />
                <div>
                    <p class="eyebrow">0{{ $i + 1 }}</p>
                    <h2 id="s{{ $i }}" class="mt-2">{{ $title }}</h2>
                    <p class="mt-4 max-w-lg leading-relaxed text-ink/75">{{ $text }}</p>
                </div>
            </section>
        @endforeach

        <section class="rounded-3xl bg-espresso p-8 text-center text-cream sm:p-14" aria-labelledby="visit-title">
            <h2 id="visit-title" class="!text-cream">Visit Us</h2>
            <p class="mx-auto mt-4 max-w-md text-cream/80">Find our store details, opening hours and directions.</p>
            <x-button :href="route('stores.index')" variant="light" class="mt-8">Find a Store</x-button>
        </section>
    </div>
@endsection