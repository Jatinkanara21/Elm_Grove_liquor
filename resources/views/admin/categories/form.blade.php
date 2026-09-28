@extends('layouts.admin')

@php $title = $category->exists ? 'Edit Category' : 'Add Category'; @endphp
@section('page_title', $title)

@section('content')
    <x-admin.page-header :title="$title" />

    <form method="POST" enctype="multipart/form-data" data-once novalidate
          action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          class="max-w-3xl space-y-6 rounded-2xl border border-espresso/10 bg-white/70 p-6 sm:p-8">
        @csrf
        @if ($category->exists) @method('PUT') @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="name" label="Name" :value="$category->name" required />
            <x-input name="slug" label="Slug (optional)" :value="$category->slug" placeholder="auto-generated" />
        </div>

        <x-textarea name="description" label="Description" :value="$category->description" rows="3" />
        <x-input name="sort_order" label="Sort Order" type="number" min="0" :value="$category->sort_order ?? 0" />
        <x-admin.image-field :current="$category->image" />
        <x-admin.checkbox name="is_active" label="Enabled" hint="Disabled categories are hidden from the public site." :checked="$category->is_active" />

        <div class="flex flex-wrap gap-3">
            <x-button type="submit" data-loading="Saving...">Save Category</x-button>
            <x-button :href="route('admin.categories.index')" variant="outline">Cancel</x-button>
        </div>
    </form>
@endsection