@extends('layouts.app')

@section('title', $title . ' | Elm Grove Liquor')

@section('content')
    <section class="container-x section text-center">
        <p class="eyebrow">Coming Soon</p>
        <h1 class="mt-3">{{ $title }}</h1>
        <p class="mx-auto mt-5 max-w-md text-ink/70">This page is being built.</p>
        <x-button :href="route('home')" class="mt-8">Back Home</x-button>
    </section>
@endsection