@extends('layouts.admin')

@section('page_title', 'Products')

@section('content')
    <x-admin.page-header title="Products" :action="route('admin.products.create')" action-label="Add Product" />

    <form method="GET" action="{{ route('admin.products.index') }}" role="search"
          class="mb-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_auto] lg:items-center">
        <div>
            <label for="search" class="sr-only">Search products</label>
            <input id="search" type="search" name="search" value="{{ request('search') }}" placeholder="Search name or brand..."
                   class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-4 focus:border-mahogany focus:outline-none focus:ring-2 focus:ring-mahogany/30">
        </div>
        <div>
            <label for="category" class="sr-only">Category</label>
            <select id="category" name="category" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
                <option value="">All Categories</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" @selected((int) request('category') === $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="sr-only">Status</label>
            <select id="status" name="status" class="min-h-12 w-full rounded-xl border border-espresso/20 bg-white px-3">
                <option value="">Any Status</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>
        </div>
        <div class="flex items-center gap-3">
            <x-button type="submit" class="flex-1">Filter</x-button>
            <a href="{{ route('admin.products.index') }}" class="px-2 text-sm font-semibold text-mahogany hover:underline">Clear</a>
        </div>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-espresso/10 bg-white/70">
        <table class="w-full min-w-[44rem] text-left text-sm">
            <thead class="border-b border-espresso/10 bg-beige/60 text-xs uppercase tracking-wider text-espresso">
                <tr>
                    <th scope="col" class="px-4 py-3">Image</th>
                    <th scope="col" class="px-4 py-3">Product</th>
                    <th scope="col" class="px-4 py-3">Brand</th>
                    <th scope="col" class="px-4 py-3">Category</th>
                    <th scope="col" class="px-4 py-3">Status</th>
                    <th scope="col" class="px-4 py-3">Featured</th>
                    <th scope="col" class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-espresso/10">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="" class="size-12 rounded-lg object-cover">
                            @else
                                <span class="flex size-12 items-center justify-center rounded-lg bg-beige text-xs text-ink/40">None</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-espresso">{{ $product->name }}</td>
                        <td class="px-4 py-3">{{ $product->brand ?: '—' }}</td>
                        <td class="px-4 py-3">{{ $product->category?->name ?: '—' }}</td>
                        <td class="px-4 py-3"><x-admin.badge :active="$product->is_active" /></td>
                        <td class="px-4 py-3"><x-admin.badge :active="$product->is_featured" on="Yes" off="No" /></td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            @if ($product->is_active)
                                <a href="{{ route('products.show', $product) }}" target="_blank" rel="noopener" class="inline-flex min-h-9 items-center px-2 font-semibold text-mahogany hover:underline">View</a>
                            @endif
                            <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex min-h-9 items-center px-2 font-semibold text-mahogany hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline"
                                  data-confirm="Delete “{{ $product->name }}”?" data-confirm-title="Delete product" data-confirm-label="Delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="min-h-9 px-2 font-semibold text-red-700 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-12 text-center text-ink/60">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
@endsection