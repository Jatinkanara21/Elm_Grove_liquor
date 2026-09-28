@props(['light' => false])

<span {{ $attributes->class(['inline-flex flex-col items-center leading-none']) }}>
    <span class="font-serif text-xl font-bold tracking-[0.12em] sm:text-2xl {{ $light ? 'text-cream' : 'text-espresso' }}">ELM GROVE</span>
    <span class="mt-1 text-[0.6rem] font-semibold tracking-[0.5em] sm:text-[0.65rem] {{ $light ? 'text-gold' : 'text-mahogany' }}">LIQUOR</span>
</span>