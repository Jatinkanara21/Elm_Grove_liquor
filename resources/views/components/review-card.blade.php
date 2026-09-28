@props(['review'])

<article class="flex flex-col rounded-2xl border border-espresso/10 bg-white/70 p-6 shadow-sm">
    <x-stars :rating="$review->rating" />
    <p class="mt-4 flex-1 text-sm leading-relaxed text-ink/80">“{{ $review->body }}”</p>
    <footer class="mt-5 flex items-center justify-between gap-3 text-sm">
        <span class="font-semibold text-espresso">{{ $review->name }}</span>
        <time datetime="{{ $review->created_at->toDateString() }}" class="text-ink/50">{{ $review->created_at->format('M j, Y') }}</time>
    </footer>
</article>