@props(['href' => null, 'variant' => 'primary', 'type' => 'button'])

@php
    $base = 'inline-flex min-h-11 items-center justify-center gap-2 rounded-full px-6 py-3 text-sm font-semibold uppercase tracking-wider transition duration-200 focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-60';
    $variants = [
        'primary' => 'bg-mahogany text-cream hover:bg-espresso',
        'outline' => 'border border-mahogany text-mahogany hover:bg-mahogany hover:text-cream',
        'light' => 'bg-cream text-espresso hover:bg-gold',
        'outline-light' => 'border border-cream/70 text-cream hover:bg-cream hover:text-espresso',
    ];
    $classes = $variants[$variant] ?? $variants['primary'];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class([$base, $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$base, $classes]) }}>{{ $slot }}</button>
@endif