@extends('layouts.app')

@section('title', 'Contact | Elm Grove Liquor')
@section('meta_description', 'Get in touch with Elm Grove Liquor.')

@php
    use App\Models\Setting;
    $phone = Setting::get('phone');
    $email = Setting::get('email');
    $address = Setting::get('address');
    $hours = Setting::get('opening_hours');
@endphp

@section('content')
    <x-page-hero eyebrow="Contact" title="Get in Touch" subtitle="Questions about our selection or stores? Send us a message." />

    <div class="container-x section grid gap-12 lg:grid-cols-[1.3fr_1fr]">
        <div>
            <x-flash />

            <form method="POST" action="{{ route('contact.store') }}" data-once novalidate class="space-y-5">
                @csrf
                <div class="hidden" aria-hidden="true">
                    <label>Leave this field empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <x-input name="name" label="Name" required autocomplete="name" />
                    <x-input name="email" label="Email" type="email" required autocomplete="email" />
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-input name="phone" label="Phone" type="tel" autocomplete="tel" />
                    <x-input name="subject" label="Subject" required />
                </div>
                <x-textarea name="message" label="Message" required rows="6" />

                <x-button type="submit" data-loading="Sending..." class="w-full sm:w-auto">Send Message</x-button>
            </form>
        </div>

        <aside class="rounded-3xl bg-espresso p-8 text-cream/80" aria-label="Store contact details">
            <h2 class="!text-2xl !text-cream">Contact Details</h2>
            <ul class="mt-6 space-y-4 text-sm">
                @if ($phone)<li><a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="hover:text-gold">{{ $phone }}</a></li>@endif
                @if ($email)<li><a href="mailto:{{ $email }}" class="break-all hover:text-gold">{{ $email }}</a></li>@endif
                @if ($address)<li class="whitespace-pre-line">{{ $address }}</li>@endif
                @if ($hours)<li class="whitespace-pre-line text-cream/70">{{ $hours }}</li>@endif
                @unless ($phone || $email || $address || $hours)
                    <li>Contact details coming soon.</li>
                @endunless
            </ul>
            <x-button :href="route('stores.index')" variant="light" class="mt-8 w-full">Find a Store</x-button>
        </aside>
    </div>
@endsection