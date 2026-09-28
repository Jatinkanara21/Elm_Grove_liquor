@extends('layouts.admin')

@section('page_title', 'Categories')

@section('content')
    <x-admin.page-header title="Categories" :action="route('admin.categories.create')" action-label="Add Category" />

    <div class="overflow-x-auto rounded-2xl border border-espresso/10 bg-white/70">
        <table class="w-full min-w-[40rem] text-left text-sm">
            <thead class="border-b border-espresso/10 bg-beige/60 text-xs uppercase tracking-wider text-espresso">
                <tr>
                    <th scope="col" class="px-4 py-3">Image</th>
                    <th scope="col" class="px-4 py-3">Category</th>
                    <th scope="col" class="px-4 py-3">Products</th>
                    <th scope="col" class="px-4 py-3">Status</th>
                    <th scope="col" class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-espresso/10">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="" class="size-12 rounded-lg object-cover">
                            @else
                                <span class="flex size-12 items-center justify-center rounded-lg bg-beige text-xs text-ink/40">None</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-espresso">{{ $category->name }}</td>
                        <td class="px-4 py-3">{{ $category->products_count }}</td>
                        <td class="px-4 py-3"><x-admin.badge :active="$category->is_active" on="Enabled" off="Disabled" /></td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.categories.toggle', $category) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="min-h-9 px-2 font-semibold text-mahogany hover:underline">
                                    {{ $category->is_active ? 'Disable' : 'Enable' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex min-h-9 items-center px-2 font-semibold text-mahogany hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline"
                                  data-confirm="Delete the “{{ $category->name }}” category?" data-confirm-title="Delete category" data-confirm-label="Delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="min-h-9 px-2 font-semibold text-red-700 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-ink/60">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
@endsection