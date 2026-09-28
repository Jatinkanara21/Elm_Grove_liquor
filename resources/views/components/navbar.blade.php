<header class="sticky top-0 z-40 border-b border-espresso/10 bg-cream/90 backdrop-blur-md transition-shadow">
    <div class="container-x">
        <div class="grid h-16 grid-cols-[2.75rem_1fr_2.75rem] items-center lg:flex lg:h-20 lg:justify-between">

            {{-- Mobile: hamburger --}}
            <button id="menu-open" type="button"
                    class="-ml-2 inline-flex size-11 items-center justify-center rounded-full text-espresso hover:bg-beige lg:hidden"
                    aria-label="Open menu" aria-controls="mobile-menu" aria-expanded="false">
                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="justify-self-center lg:justify-self-auto" aria-label="{{ config('app.name') }} home">
                <x-logo />
            </a>

            {{-- Desktop links --}}
            <nav class="hidden lg:block" aria-label="Main navigation">
                <ul class="flex items-center gap-8">
                    @foreach ($navLinks as $link)
                        @php $active = request()->routeIs($link['match']); @endphp
                        <li>
                            <a href="{{ route($link['route']) }}"
                               @if ($active) aria-current="page" @endif
                               class="relative py-2 text-sm font-semibold uppercase tracking-wider transition-colors hover:text-mahogany
                                      after:absolute after:inset-x-0 after:-bottom-0.5 after:h-0.5 after:origin-left after:bg-mahogany after:transition-transform
                                      {{ $active ? 'text-mahogany after:scale-x-100' : 'text-espresso after:scale-x-0 hover:after:scale-x-100' }}">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <x-button :href="route('stores.index')" class="hidden lg:inline-flex">Find a Store</x-button>

            {{-- Mobile: location --}}
            <a href="{{ route('stores.index') }}"
               class="-mr-2 inline-flex size-11 items-center justify-center justify-self-end rounded-full text-espresso hover:bg-beige lg:hidden"
               aria-label="Find a store">
                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 21s7-5.6 7-11a7 7 0 1 0-14 0c0 5.4 7 11 7 11Z" />
                    <circle cx="12" cy="10" r="2.5" />
                </svg>
            </a>
        </div>
    </div>
</header>