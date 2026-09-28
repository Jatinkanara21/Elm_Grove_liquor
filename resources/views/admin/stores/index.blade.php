@extends('layouts.admin')

@section('page_title', 'Stores')

@section('content')
    <x-admin.page-header title="Stores" :action="route('admin.stores.create')" action-label="Add Store" />

    <div class="overflow-x-auto rounded-2xl border border-espresso/10 bg-white/70">
        <table class="w-full min-w-[40rem] text-left text-sm">
            <thead class="border-b border-espresso/10 bg-beige/60 text-xs uppercase tracking-wider text-espresso">
                <tr>
                    <th scope="col" class="px-4 py-3">Image</th>
                    <th scope="col" class="px-4 py-3">Store</th>
                    <th scope="col" class="px-4 py-3">Address</th>
                    <th scope="col" class="px-4 py-3">Phone</th>
                    <th scope="col" class="px-4 py-3">Status</th>
                    <th scope="col" class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-espresso/10">
                @forelse ($stores as $store)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($store->image)
                                <img src="{{ asset('storage/' . $store->image) }}" alt="" class="size-12 rounded-lg object-cover">
                            @else
                                <span class="flex size-12 items-center justify-center rounded-lg bg-beige text-xs text-ink/40">None</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-espresso">{{ $store->name }}</td>
                        <td class="px-4 py-3">{{ $store->full_address }}</td>
                        <td class="px-4 py-3">{{ $store->phone ?: '—' }}</td>
                        <td class="px-4 py-3"><x-admin.badge :active="$store->is_active" /></td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            @if ($store->is_active)
                                <a href="{{ route('stores.show', $store) }}" target="_blank" rel="noopener" class="inline-flex min-h-9 items-center px-2 font-semibold text-mahogany hover:underline">View</a>
                            @endif
                            <a href="{{ route('admin.stores.edit', $store) }}" class="inline-flex min-h-9 items-center px-2 font-semibold text-mahogany hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.stores.destroy', $store) }}" class="inline"
                                  data-confirm="Delete “{{ $store->name }}”?" data-confirm-title="Delete store" data-confirm-label="Delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="min-h-9 px-2 font-semibold text-red-700 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center text-ink/60">No stores yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $stores->links() }}</div>
@endsection