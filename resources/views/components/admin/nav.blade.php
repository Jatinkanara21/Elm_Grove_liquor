@php
    // [label, route name, active pattern]. Links whose route doesn't exist yet are hidden.
    $items = [
        ['Dashboard', 'admin.dashboard', 'admin.dashboard'],
        ['Products', 'admin.products.index', 'admin.products.*'],
        ['Categories', 'admin.categories.index', 'admin.categories.*'],
        ['Stores', 'admin.stores.index', 'admin.stores.*'],
        ['Reviews', 'admin.reviews.index', 'admin.reviews.*'],
        ['Messages', 'admin.messages.index', 'admin.messages.*'],
        ['Events', 'admin.events.index', 'admin.events.*'],
        ['Settings', 'admin.settings.edit', 'admin.settings.*'],
        ['Profile', 'admin.profile.edit', 'admin.profile.*'],
    ];
@endphp

<ul class="space-y-1">
    @foreach ($items as [$label, $route, $match])
        @continue(! Route::has($route))
        @php $active = request()->routeIs($match); @endphp
        <li>
            <a href="{{ route($route) }}" @if ($active) aria-current="page" @endif
               class="flex min-h-11 items-center rounded-xl px-4 text-sm font-semibold transition
                      {{ $active ? 'bg-mahogany text-cream' : 'text-cream/80 hover:bg-cream/10' }}">
                {{ $label }}
            </a>
        </li>
    @endforeach
</ul>