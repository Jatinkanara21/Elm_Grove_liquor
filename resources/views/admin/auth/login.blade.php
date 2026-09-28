<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="age-ok">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | Elm Grove Liquor</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-espresso p-4">
    <main class="w-full max-w-md rounded-3xl border border-gold/30 bg-cream p-8 shadow-2xl sm:p-10">
        <div class="text-center">
            <x-logo />
            <p class="mt-3 text-xs font-semibold uppercase tracking-[0.3em] text-mahogany">Admin Portal</p>
        </div>

        @if (session('success'))
            <p role="status" class="mt-6 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-900">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}" data-once novalidate class="mt-8 space-y-5">
            @csrf
            <x-input name="email" label="Email" type="email" required autocomplete="username" autofocus />
            <x-input name="password" label="Password" type="password" required autocomplete="current-password" />

            <label class="flex min-h-11 cursor-pointer items-center gap-3 text-sm">
                <input type="checkbox" name="remember" value="1" class="size-5 rounded border-espresso/30 text-mahogany focus:ring-mahogany">
                Remember me
            </label>

            <x-button type="submit" data-loading="Signing in..." class="w-full">Login</x-button>

            @if (Route::has('admin.password.request'))
                <p class="text-center text-sm">
                    <a href="{{ route('admin.password.request') }}" class="font-semibold text-mahogany hover:underline">Forgot password?</a>
                </p>
            @endif
        </form>

        <p class="mt-8 text-center text-sm"><a href="{{ route('home') }}" class="text-ink/60 hover:text-mahogany">← Back to website</a></p>
    </main>
</body>
</html>