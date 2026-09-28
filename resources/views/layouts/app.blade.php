@php
    $siteName = \App\Models\Setting::get('website_name', 'Elm Grove Liquor');
    $pageTitle = trim($__env->yieldContent('title')) ?: 'Elm Grove Liquor | Premium Spirits, Wine & Beverages';
    $pageDesc = trim($__env->yieldContent('meta_description'))
        ?: 'Discover quality spirits, wines, and beverages at Elm Grove Liquor.';
    $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
    $ogImage = trim($__env->yieldContent('og_image')) ?: asset('images/og-default.jpg');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <meta name="theme-color" content="#1C1107">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    {{-- Skip the age gate flash for verified visitors --}}
    <script>
        try { if (localStorage.getItem('egl_age_verified') === '1') document.documentElement.classList.add('age-ok'); } catch (e) {}
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[200] focus:rounded-full focus:bg-mahogany focus:px-5 focus:py-3 focus:text-cream">
        Skip to content
    </a>

    <x-age-verification />

    <div id="site">
        <x-navbar />
        <x-mobile-menu />

        <main id="main" tabindex="-1" class="outline-none">
            @yield('content')
        </main>

        <x-footer />
    </div>

    <noscript>
        <p class="fixed inset-x-0 bottom-0 z-[300] bg-espresso p-3 text-center text-sm text-cream">
            JavaScript is required to verify your age and use this website.
        </p>
    </noscript>

    @stack('scripts')
</body>
</html>