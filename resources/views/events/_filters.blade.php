@props([])

<form method="GET" action="{{ $action }}" role="search"
      class="grid gap-3 sm:grid-cols-2 {{ isset($years) ? 'lg:grid-cols-[2fr_1fr_1fr_auto]' : 'lg:grid-cols-[2fr_1fr_auto]' }} lg:items-center">
    <div>
        <label for="search" class="sr-only">Search events</label>
        <input id="search" type="search" name="search" value="{{ request('search') }}" placeholder="Search events..."
               class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-4 py-3 focus:border-mahogany focus:outline-none focus:ring-2 focus:ring-mahogany/30">
    </div>

    <div>
        <label for="type" class="sr-only">Event type</label>
        <select id="type" name="type" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
            <option value="">All Event Types</option>
            @foreach ($types as $value => $label)
                <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    @isset($years)
        <div>
            <label for="year" class="sr-only">Year</label>
            <select id="year" name="year" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
                <option value="">All Years</option>
                @foreach ($years as $y)
                    <option value="{{ $y }}" @selected((string) request('year') === (string) $y)>{{ $y }}</option>
                @endforeach
            </select>
        </div>
    @endisset

    <div class="flex items-center gap-3">
        <x-button type="submit" class="flex-1">Filter</x-button>
        <a href="{{ $action }}" class="inline-flex min-h-12 items-center px-2 text-sm font-semibold text-mahogany underline-offset-4 hover:underline">
            Clear Filters
        </a>
    </div>
</form>