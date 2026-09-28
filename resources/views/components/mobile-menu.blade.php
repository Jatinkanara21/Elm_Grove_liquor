<div id="mobile-menu" class="mobile-menu lg:hidden" aria-hidden="true">
    <div class="mobile-menu__overlay" data-menu-close></div>

    <div class="mobile-menu__panel" role="dialog" aria-modal="true" aria-label="Main menu">
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}" aria-label="{{ config('app.name') }} home"><x-logo light /></a>
            <button id="menu-close" type="button"
                    class="inline-flex size-11 items-center justify-center rounded-full text-cream hover:bg-cream/10"
                    aria-label="Close menu">
                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <path d="M6 6l12 12M18 6 6 18" />
                </svg>
            </button>
        </div>

        <nav class="mt-8 flex-1" aria-label="Mobile navigation">
            <ul class="divide-y divide-cream/10">
                @foreach ($navLinks as $link)
                    @php $active = request()->routeIs($link['match']); @endphp
                    <li>
                        <a href="{{ route($link['route']) }}"
                           @if ($active) aria-current="page" @endif
                           class="flex min-h-14 items-center font-serif text-2xl transition-colors hover:text-gold
                                  {{ $active ? 'text-gold' : 'text-cream' }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <x-button :href="route('stores.index')" variant="light" class="mt-8 w-full">Find a Store</x-button>
    </div>
</div>