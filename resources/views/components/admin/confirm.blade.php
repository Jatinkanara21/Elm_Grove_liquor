<dialog id="confirm-dialog"
        class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl bg-cream p-0 text-ink shadow-2xl backdrop:bg-espresso/60"
        aria-labelledby="confirm-title" aria-describedby="confirm-message">
    <form method="dialog" class="p-6 sm:p-8">
        <h2 id="confirm-title" class="!text-2xl">Please confirm</h2>
        <p id="confirm-message" class="mt-3 text-sm leading-relaxed text-ink/80"></p>

        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button type="submit" value="cancel"
                    class="inline-flex min-h-11 items-center justify-center rounded-full border border-mahogany px-6 text-sm font-semibold uppercase tracking-wider text-mahogany hover:bg-mahogany hover:text-cream">
                Cancel
            </button>
            <button id="confirm-ok" type="submit" value="confirm"
                    class="inline-flex min-h-11 items-center justify-center rounded-full bg-mahogany px-6 text-sm font-semibold uppercase tracking-wider text-cream hover:bg-espresso">
                Confirm
            </button>
        </div>
    </form>
</dialog>