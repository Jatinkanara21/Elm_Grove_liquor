@extends('layouts.admin')

@section('page_title', 'Profile')

@section('content')
    <x-admin.page-header title="Profile" />

    <div class="max-w-2xl space-y-8">
        <form method="POST" action="{{ route('admin.profile.update') }}" data-once novalidate
              class="rounded-2xl border border-espresso/10 bg-white/70 p-6 sm:p-8">
            @csrf

            <h2 class="!text-2xl">Your Information</h2>
            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <x-input name="name" label="Name" :value="$user->name" required />
                <x-input name="email" label="Email" type="email" :value="$user->email" required />
            </div>

            <div class="mt-6 flex flex-wrap gap-3 border-t border-espresso/10 pt-6">
                <x-button type="submit" data-loading="Saving...">Save Profile</x-button>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.profile.password') }}" data-once novalidate
              class="rounded-2xl border border-espresso/10 bg-white/70 p-6 sm:p-8">
            @csrf

            <h2 class="!text-2xl">Change Password</h2>
            <div class="mt-6 space-y-5">
                <x-input name="current_password" label="Current Password" type="password" autocomplete="current-password" required />
                <x-input name="password" label="New Password" type="password" autocomplete="new-password" required />
                <x-input name="password_confirmation" label="Confirm New Password" type="password" autocomplete="new-password" required />
            </div>

            <div class="mt-6 flex flex-wrap gap-3 border-t border-espresso/10 pt-6">
                <x-button type="submit" data-loading="Updating...">Change Password</x-button>
            </div>
        </form>
    </div>
@endsection