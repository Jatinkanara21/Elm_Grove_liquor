@props(['src' => null, 'alt' => '', 'label' => null])

<div {{ $attributes->class(['relative overflow-hidden bg-beige']) }}>
    @if ($src)
        <img src="{{ asset('storage/' . $src) }}" alt="{{ $alt }}" loading="lazy"
             class="size-full object-cover transition duration-500 group-hover:scale-105">
    @else
        <div class="flex size-full items-center justify-center bg-[linear-gradient(135deg,#3b2414,#8B4513)] p-4 text-center"
             role="img" aria-label="{{ $alt }}">
            <span class="font-serif text-lg tracking-wide text-cream/80">{{ $label ?: $alt }}</span>
        </div>
    @endif
</div>