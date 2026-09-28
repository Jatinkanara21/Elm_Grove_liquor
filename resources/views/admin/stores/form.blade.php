@extends('layouts.admin')

@php $title = $store->exists ? 'Edit Store' : 'Add Store'; @endphp
@section('page_title', $title)

@section('content')
    <x-admin.page-header :title="$title" />

    <form method="POST" enctype="multipart/form-data" data-once novalidate
          action="{{ $store->exists ? route('admin.stores.update', $store) : route('admin.stores.store') }}"
          class="max-w-4xl space-y-6 rounded-2xl border border-espresso/10 bg-white/70 p-6 sm:p-8">
        @csrf
        @if ($store->exists) @method('PUT') @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="name" label="Store Name" :value="$store->name" required />
            <x-input name="slug" label="Slug (optional)" :value="$store->slug" placeholder="auto-generated" />
        </div>

        <x-input name="address" label="Street Address" :value="$store->address" required />

        <div class="grid gap-5 sm:grid-cols-3">
            <x-input name="city" label="City" :value="$store->city" />
            <x-input name="state" label="State" :value="$store->state" />
            <x-input name="zip" label="ZIP" :value="$store->zip" />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="phone" label="Phone" type="tel" :value="$store->phone" />
            <x-input name="email" label="Email" type="email" :value="$store->email" />
        </div>

        <x-textarea name="opening_hours" label="Opening Hours" :value="$store->opening_hours" rows="4" />

        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="latitude" label="Latitude" type="number" step="any" :value="$store->latitude" />
            <x-input name="longitude" label="Longitude" type="number" step="any" :value="$store->longitude" />
        </div>

        <x-input name="google_maps_url" label="Google Maps URL" type="url" :value="$store->google_maps_url" placeholder="https://maps.google.com/..." />
        <x-admin.image-field :current="$store->image" label="Store Image" />
        <x-admin.checkbox name="is_active" label="Active" hint="Inactive stores are hidden from the public site." :checked="$store->is_active" />

        <div class="flex flex-wrap gap-3">
            <x-button type="submit" data-loading="Saving...">Save Store</x-button>
            <x-button :href="route('admin.stores.index')" variant="outline">Cancel</x-button>
        </div>
    </form>
@endsection