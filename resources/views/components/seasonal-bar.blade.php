@props(['season'])

@if ($season['bar'])
    <div class="text-center text-sm" style="background: var(--season); color: var(--season-text);">
        <a href="{{ $season['bar']['url'] }}"
           class="container-x flex min-h-10 flex-wrap items-center justify-center gap-x-2 py-2 font-semibold hover:underline">
            @if ($season['bar']['icon'])<span aria-hidden="true">{{ $season['bar']['icon'] }}</span>@endif
            <span>{{ $season['bar']['today'] ? 'Today:' : 'Coming up:' }} {{ $season['bar']['title'] }}</span>
            <span class="font-normal opacity-90">· {{ $season['bar']['date'] }}</span>
        </a>
    </div>
@endif