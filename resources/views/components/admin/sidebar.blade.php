{{-- Desktop --}}
<aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col bg-espresso p-5 lg:flex">
    <a href="{{ route('admin.dashboard') }}" aria-label="Admin dashboard"><x-logo light class="w-full" /></a>
    <p class="mt-2 text-center text-[0.6rem] uppercase tracking-[0.3em] text-cream/50">Admin Portal</p>

    <nav class="mt-8 flex-1 overflow-y-auto" aria-label="Admin"><x-admin.nav /></nav>

    <div class="space-y-2 border-t border-cream/10 pt-4">
        <a href="{{ route('home') }}" target="_blank" rel="noopener"
           class="flex min-h-11 items-center rounded-xl px-4 text-sm font-semibold text-cream/80 hover:bg-cream/10">View Website ↗</a>
        <x-admin.logout class="min-h-11 w-full rounded-xl border border-cream/30 px-4 text-sm font-semibold text-cream hover:bg-cream hover:text-espresso">Logout</x-admin.logout>
    </div>
</aside>

{{-- Mobile drawer (reuses the public menu's open/close script and styles) --}}
<div id="mobile-menu" class="mobile-menu lg:hidden" aria-hidden="true">
    <div class="mobile-menu__overlay" data-menu-close></div>

    <div class="mobile-menu__panel" role="dialog" aria-modal="true" aria-label="Admin menu">
        <div class="flex items-center justify-between">
            <x-logo light />
            <button id="menu-close" type="button" aria-label="Close menu"
                    class="inline-flex size-11 items-center justify-center rounded-full text-cream hover:bg-cream/10">
                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" /></svg>
            </button>
        </div>

        <nav class="mt-8 flex-1" aria-label="Admin mobile"><x-admin.nav /></nav>

        <x-admin.logout class="mt-6 min-h-12 w-full rounded-full bg-cream px-4 text-sm font-semibold uppercase tracking-wider text-espresso">Logout</x-admin.logout>
    </div>
</div>