@props(['event'])

@php
    $status = $event->status;
    $badge = [
        'upcoming' => 'bg-mahogany/10 text-mahogany',
        'today' => 'bg-gold text-espresso',
        'past' => 'bg-ink/10 text-ink/60',
    ][$status];
@endphp

<article class="group flex flex-col overflow-hidden rounded-2xl border border-espresso/10 bg-white/70 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
         @if ($event->accent_color) style="border-top: 4px solid {{ $event->accent_color }}" @endif>
    <div class="relative">
        <a href="{{ route('events.show', $event) }}" tabindex="-1" aria-hidden="true" class="block">
            <x-media :src="$event->thumbnail_image" :alt="$event->title" :label="$event->title" class="aspect-[3/2]" />
        </a>
        <div class="absolute left-4 top-4 rounded-xl bg-cream px-3 py-2 text-center leading-none shadow-md" aria-hidden="true">
            <span class="block text-[0.65rem] font-bold uppercase tracking-widest text-mahogany">{{ $event->event_date->format('M') }}</span>
            <span class="mt-1 block font-serif text-2xl font-bold text-espresso">{{ $event->event_date->format('d') }}</span>
        </div>
    </div>

    <div class="flex flex-1 flex-col p-6">
        <div class="flex items-center justify-between gap-2">
            <p class="eyebrow">{{ $event->type_label }}</p>
            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">{{ $event->status_label }}</span>
        </div>
        <h3 class="mt-2 text-xl">
            <a href="{{ route('events.show', $event) }}" class="hover:text-mahogany">{{ $event->title }}</a>
        </h3>
        <p class="mt-1 text-sm font-medium text-ink/60">{{ $event->display_date }}</p>
        @if ($event->short_description)
            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-ink/70">{{ $event->short_description }}</p>
        @endif
        <a href="{{ route('events.show', $event) }}"
           class="mt-auto inline-flex min-h-11 items-center gap-2 pt-4 text-sm font-semibold uppercase tracking-wider text-mahogany">
            View Event <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span>
        </a>
    </div>
</article>