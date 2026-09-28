@props(['eyebrow' => null, 'title', 'subtitle' => null])

<section class="relative isolate overflow-hidden bg-espresso text-cream">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,rgba(139,69,19,0.5),transparent_60%)]"></div>
    <div class="container-x py-16 sm:py-20 lg:py-24">
        @if ($eyebrow)<p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold">{{ $eyebrow }}</p>@endif
        <h1 class="mt-3 max-w-3xl !text-cream">{{ $title }}</h1>
        @if ($subtitle)<p class="mt-5 max-w-xl text-base leading-relaxed text-cream/80 sm:text-lg">{{ $subtitle }}</p>@endif
        {{ $slot }}
    </div>
</section>