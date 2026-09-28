<div id="age-gate"
     class="fixed inset-0 z-[100] items-center justify-center overflow-y-auto bg-espresso/95 p-4 backdrop-blur-sm"
     role="dialog" aria-modal="true"
     aria-labelledby="age-gate-title" aria-describedby="age-gate-desc">

    <div class="w-full max-w-md rounded-3xl border border-gold/30 bg-espresso p-8 text-center shadow-2xl sm:p-10">
        <x-logo light class="mb-8" />

        <div id="age-gate-prompt">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold">Welcome to</p>
            <h2 id="age-gate-title" class="mt-2 text-3xl font-bold !text-cream sm:text-4xl">Elm Grove Liquor</h2>

            <p id="age-gate-desc" class="mx-auto mt-5 max-w-xs text-sm leading-relaxed text-cream/80">
                Please confirm that you are of legal drinking age to enter this website.
            </p>

            <div class="mt-8 flex flex-col gap-3">
                <x-button id="age-yes" variant="light" class="w-full">Yes, I am 21+</x-button>
                <x-button id="age-exit" variant="outline-light" class="w-full">Exit</x-button>
            </div>
        </div>

        <div id="age-gate-denied" hidden tabindex="-1" class="outline-none">
            <h2 class="text-2xl font-semibold !text-cream">Access Restricted</h2>
            <p class="mx-auto mt-4 max-w-xs text-sm leading-relaxed text-cream/80">
                Sorry, you must be of legal drinking age to enter this website.
            </p>
        </div>
    </div>
</div>