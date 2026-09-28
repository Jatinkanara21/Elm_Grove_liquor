@extends('layouts.admin')

@section('page_title', 'Settings')

@section('content')
    <x-admin.page-header title="Settings" />

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" data-once novalidate
          class="max-w-4xl space-y-8 rounded-2xl border border-espresso/10 bg-white/70 p-6 sm:p-8">
        @csrf

        <div>
            <h2 class="!text-2xl">Website</h2>
            <div class="mt-5 grid gap-5">
                <x-input name="website_name" label="Website Name" :value="$settings['website_name'] ?? 'Elm Grove Liquor'" required />
                <x-input name="tagline" label="Tagline" :value="$settings['tagline'] ?? ''" />
                <x-admin.image-field name="logo" label="Logo" :current="$settings['logo'] ?? null" hint="SVG, PNG, WEBP or JPG. Max 2 MB." />
            </div>
        </div>

        <div>
            <h2 class="!text-2xl">Contact Information</h2>
            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <x-input name="phone" label="Phone" type="tel" :value="$settings['phone'] ?? ''" />
                <x-input name="email" label="Email" type="email" :value="$settings['email'] ?? ''" />
            </div>
            <div class="mt-5">
                <x-input name="address" label="Address" :value="$settings['address'] ?? ''" />
            </div>
            <div class="mt-5">
                <x-textarea name="opening_hours" label="Opening Hours" rows="4" :value="$settings['opening_hours'] ?? ''" />
            </div>
        </div>

        <div>
            <h2 class="!text-2xl">Links</h2>
            <div class="mt-5 grid gap-5">
                <x-input name="google_maps_url" label="Google Maps URL" type="url" :value="$settings['google_maps_url'] ?? ''" />
                <x-input name="instagram_url" label="Instagram URL" type="url" :value="$settings['instagram_url'] ?? ''" />
                <x-input name="facebook_url" label="Facebook URL" type="url" :value="$settings['facebook_url'] ?? ''" />
            </div>
        </div>

        <div>
            <h2 class="!text-2xl">Store Policies</h2>
            <div class="mt-5 space-y-3">
                <x-admin.checkbox name="accepting_online_orders" label="Accepting Online Orders"
                                  hint="Display toggle on the website (informational only; no e-commerce is implemented)."
                                  :checked="$settings['accepting_online_orders'] === '1'" />
                <x-admin.checkbox name="maintenance_mode" label="Maintenance Mode"
                                  hint="Display a maintenance notice to visitors (not implemented yet)."
                                  :checked="$settings['maintenance_mode'] === '1'" />
            </div>
        </div>

        <div class="flex flex-wrap gap-3 border-t border-espresso/10 pt-6">
            <x-button type="submit" data-loading="Saving...">Save Settings</x-button>
        </div>
    </form>
@endsection