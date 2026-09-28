@extends('layouts.admin')

@section('page_title', 'Reviews')

@section('content')
    <x-admin.page-header title="Reviews" />

    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.reviews.index') }}"
           class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ ! request('status') ? 'bg-mahogany text-cream' : 'bg-white/70 text-ink' }}">
            All ({{ $pending + $approved }})
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
           class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-white/70 text-ink' }}">
            Pending ({{ $pending }})
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}"
           class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ request('status') === 'approved' ? 'bg-green-600 text-white' : 'bg-white/70 text-ink' }}">
            Approved ({{ $approved }})
        </a>
    </div>

    <div class="space-y-4">
        @forelse ($reviews as $review)
            <div class="rounded-2xl border border-espresso/10 bg-white/70 p-5">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="font-semibold text-espresso">{{ $review->name }}</p>
                        <p class="text-sm text-ink/60">{{ $review->email }}</p>
                        <p class="mt-2 flex items-center gap-2">
                            <x-stars :rating="$review->rating" />
                        </p>
                    </div>
                    <x-admin.status-badge :status="$review->status" />
                </div>

                <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-ink/80">"{{ $review->body }}"</p>

                <div class="mt-4 flex flex-wrap gap-2 text-xs">
                    <time class="text-ink/60">{{ $review->created_at->format('M j, Y H:i') }}</time>
                </div>

                @if ($review->status === 'pending')
                    <div class="mt-4 flex gap-2">
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                            @csrf @method('PATCH')
                            <x-button type="submit" variant="outline" class="!px-4">Approve</x-button>
                        </form>
                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                            @csrf @method('PATCH')
                            <x-button type="submit" variant="outline" class="!px-4">Reject</x-button>
                        </form>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline"
                      data-confirm="Delete this review?" data-confirm-label="Delete">
                    @csrf @method('DELETE')
                    <button type="submit" class="mt-3 text-xs font-semibold text-red-700 hover:underline">Delete</button>
                </form>
            </div>
        @empty
            <p class="rounded-2xl bg-white/70 px-6 py-12 text-center text-ink/60">No reviews found.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $reviews->links() }}</div>
@endsection