@extends('layouts.admin')

@php $title = $product->exists ? 'Edit Product' : 'Add Product'; @endphp
@section('page_title', $title)

@section('content')
    <x-admin.page-header :title="$title" />

    <form method="POST" enctype="multipart/form-data" data-once novalidate
          action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
          class="max-w-4xl space-y-6 rounded-2xl border border-espresso/10 bg-white/70 p-6 sm:p-8">
        @csrf
        @if ($product->exists) @method('PUT') @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="name" label="Product Name" :value="$product->name" required />
            <x-input name="slug" label="Slug (optional)" :value="$product->slug" placeholder="auto-generated" />
            <x-input name="brand" label="Brand" :value="$product->brand" />
            <x-admin.select name="category_id" label="Category" :value="$product->category_id" placeholder="Select a category"
                            :options="$categories->pluck('name', 'id')->all()" required />
        </div>

        <x-input name="short_description" label="Short Description" :value="$product->short_description" maxlength="500" />
        <x-textarea name="description" label="Description" :value="$product->description" rows="6" />

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <x-input name="type" label="Type" :value="$product->type" placeholder="e.g. Bourbon" />
            <x-input name="country" label="Country" :value="$product->country" />
            <x-input name="region" label="Region" :value="$product->region" />
            <x-input name="alcohol_percentage" label="Alcohol %" type="number" step="0.1" min="0" max="99.9" :value="$product->alcohol_percentage" />
            <x-input name="bottle_size" label="Bottle Size" :value="$product->bottle_size" placeholder="e.g. 750 ml" />
        </div>

        <x-admin.image-field :current="$product->image" />

        <div class="grid gap-2 sm:grid-cols-2">
            <x-admin.checkbox name="is_featured" label="Featured" hint="Shown in Featured Products on the homepage." :checked="$product->is_featured" />
            <x-admin.checkbox name="is_active" label="Active" hint="Inactive products are hidden from the public site." :checked="$product->is_active" />
        </div>

        <div class="flex flex-wrap gap-3">
            <x-button type="submit" data-loading="Saving...">Save Product</x-button>
            <x-button :href="route('admin.products.index')" variant="outline">Cancel</x-button>
        </div>
    </form>
@endsection