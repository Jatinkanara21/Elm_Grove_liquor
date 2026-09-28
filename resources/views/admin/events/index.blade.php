@extends('layouts.admin')

@section('page_title', 'Events')

@section('content')
    <x-admin.page-header title="Events" :action="route('admin.events.create')" action-label="Add Event" />

    <form method="GET" action="{{ route('admin.events.index') }}" role="search"
          class="mb-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_auto] lg:items-center">
        <div>
            <label for="search" class="sr-only">Search events</label>
            <input id="search" type="search" name="search" value="{{ request('search') }}" placeholder="Search events..."
                   class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-4 focus:border-mahogany focus:outline-none focus:ring-2 focus:ring-mahogany/30">
        </div>
        <div>
            <label for="type" class="sr-only">Type</label>
            <select id="type" name="type" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
                <option value="">All Types</option>
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="sr-only">Status</label>
            <select id="status" name="status" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
                <option value="">Any Status</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
                <option value="unpublished" @selected(request('status') === 'unpublished')>Unpublished</option>
                <option value="scheduled" @selected(request('status') === 'scheduled')>Scheduled</option>
            </select>
        </div>
        <div class="flex items-center gap-3">
            <x-button type="submit" class="flex-1">Filter</x-button>
            <a href="{{ route('admin.events.index') }}" class="px-2 text-sm font-semibold text-mahogany hover:underline">Clear</a>
        </div>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-espresso/10 bg-white/70">
        <table class="w-full min-w-[50rem] text-left text-sm">
            <thead class="border-b border-espresso/10 bg-beige/60 text-xs uppercase tracking-wider text-espresso">
                <tr>
                    <th scope="col" class="px-4 py-3">Image</th>
                    <th scope="col" class="px-4 py-3">Event</th>
                    <th scope="col" class="px-4 py-3">Date</th>
                    <th scope="col" class="px-4 py-3">Type</th>
                    <th scope="col" class="px-4 py-3">Status</th>
                    <th scope="col" class="px-4 py-3">Featured</th>
                    <th scope="col" class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-espresso/10">
                @forelse ($events as $event)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($event->thumbnail_image)
                                <img src="{{ asset('storage/' . $event->thumbnail_image) }}" alt="" class="size-12 rounded-lg object-cover">
                            @else
                                <span class="flex size-12 items-center justify-center rounded-lg bg-beige text-xs text-ink/40">None</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-espresso">{{ $event->title }}</td>
                        <td class="px-4 py-3 text-sm">{{ $event->event_date->format('M j, Y') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $event->type_label }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <x-admin.status-badge :status="$event->is_published ? 'published' : 'unpublished'" />
                                @if ($event->is_scheduled)
                                    <span class="text-xs text-ink/50" title="Scheduled from {{ $event->publish_from->format('M j H:i') }}">📅</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3"><x-admin.badge :active="$event->is_featured" on="Yes" off="No" /></td>
                        <td class="whitespace-nowrap px-4 py-3 text-right text-xs">
                            <a href="{{ route('events.show', $event) }}" target="_blank" rel="noopener"
                               class="inline-flex min-h-9 items-center px-2 font-semibold text-mahogany hover:underline">View</a>
                            <a href="{{ route('admin.events.edit', $event) }}"
                               class="inline-flex min-h-9 items-center px-2 font-semibold text-mahogany hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.events.toggle-publish', $event) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="min-h-9 px-2 font-semibold text-mahogany hover:underline">
                                    {{ $event->is_published ? 'Unpublish' : 'Publish' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.events.duplicate', $event) }}" class="inline">
                                @csrf
                                <button type="submit" class="min-h-9 px-2 font-semibold text-mahogany hover:underline">Duplicate</button>
                            </form>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline"
                                  data-confirm="Delete "{{ $event->title }}"?" data-confirm-title="Delete event" data-confirm-label="Delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="min-h-9 px-2 font-semibold text-red-700 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-12 text-center text-ink/60">No events found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $events->links() }}</div>
@endsection