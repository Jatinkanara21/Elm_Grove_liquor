@extends('layouts.app')

@section('title', 'Events Archive | Elm Grove Liquor')
@section('meta_description', 'Past events and celebrations from Elm Grove Liquor.')

@section('content')
    <x-page-hero eyebrow="Events" title="Events Archive" subtitle="A look back at past holidays and celebrations." />

    <section class="container-x section">
        @include('events._filters', ['action' => route('events.archive'), 'types' => $types, 'years' => $years])

        <div class="mt-10 flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm font-semibold text-ink/70">
                {{ $events->total() }} {{ Str::plural('Event', $events->total()) }} Found
            </p>
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-mahogany hover:underline">← Upcoming events</a>
        </div>

        @if ($events->count())
            <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
            <div class="mt-10">{{ $events->links() }}</div>
        @else
            <div class="mt-6 rounded-2xl bg-white/70 px-6 py-16 text-center">
                <h3>No Events Found</h3>
                <p class="mt-2 text-ink/70">Try changing your search or filters.</p>
            </div>
        @endif
    </section>
@endsection