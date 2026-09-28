<header class="sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-espresso/10 bg-cream/90 px-4 backdrop-blur sm:px-6 lg:px-8">
    <button id="menu-open" type="button" aria-label="Open menu" aria-controls="mobile-menu" aria-expanded="false"
            class="-ml-2 inline-flex size-11 items-center justify-center rounded-full text-espresso hover:bg-beige lg:hidden">
        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" /></svg>
    </button>

    <span class="font-serif text-lg font-semibold text-espresso lg:hidden">Admin Portal</span>

    <div class="ml-auto flex items-center gap-3">
        <span class="hidden max-w-[12rem] truncate text-sm text-ink/70 sm:inline">{{ auth()->user()->name }}</span>
        <x-admin.logout class="min-h-11 rounded-full border border-mahogany px-4 text-sm font-semibold text-mahogany hover:bg-mahogany hover:text-cream">Logout</x-admin.logout>
    </div>
</header>