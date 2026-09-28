<!DOCTYPE html>
<html lang="en" class="age-ok">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Server Error | Elm Grove Liquor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="flex min-h-screen flex-col items-center justify-center bg-espresso px-4 text-cream">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold">500</p>
        <h1 class="mt-4 text-center font-serif text-5xl font-bold sm:text-6xl">Server Error</h1>
        <p class="mt-5 max-w-md text-center text-lg text-cream/80">Something went wrong on our end. Please try again later.</p>
        <a href="{{ route('home') }}" class="mt-10 inline-flex min-h-11 items-center justify-center rounded-full bg-cream px-8 text-sm font-semibold uppercase tracking-wider text-espresso hover:bg-gold">Back to Home</a>
    </div>
</body>
</html>