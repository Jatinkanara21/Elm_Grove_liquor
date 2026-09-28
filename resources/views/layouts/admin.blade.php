<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="age-ok">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('page_title', 'Dashboard') | Elm Grove Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-admin class="min-h-screen">
    <x-admin.sidebar />

    <div id="site" class="lg:pl-64">
        <x-admin.header />

        <main id="main" class="p-4 sm:p-6 lg:p-8">
            @if ($errors->any())
                <div role="alert" class="mb-6 rounded-2xl border border-red-700/20 bg-red-50 px-5 py-4 text-sm text-red-900">
                    Please fix the highlighted fields and try again.
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <x-admin.confirm />

    {{-- Toasts --}}
    <div class="pointer-events-none fixed inset-x-4 top-4 z-[90] flex flex-col items-end gap-3 sm:left-auto sm:w-96" aria-live="polite">
        @foreach (['success' => 'bg-green-700', 'error' => 'bg-red-700'] as $type => $color)
            @if (session($type))
                <div data-toast role="{{ $type === 'error' ? 'alert' : 'status' }}"
                     class="pointer-events-auto flex w-full items-start justify-between gap-3 rounded-2xl {{ $color }} px-5 py-4 text-sm text-white shadow-xl">
                    <span>{{ session($type) }}</span>
                    <button type="button" aria-label="Dismiss" class="-mr-2 -mt-1 inline-flex size-8 items-center justify-center rounded-full hover:bg-white/20">✕</button>
                </div>
            @endif
        @endforeach
    </div>
</body>
</html>