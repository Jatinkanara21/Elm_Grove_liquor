@extends('layouts.admin')

@section('page_title', 'Message from ' . $message->name)

@section('content')
    <a href="{{ route('admin.messages.index') }}" class="text-sm font-semibold text-mahogany hover:underline">← Back to messages</a>

    <div class="mt-6 max-w-3xl rounded-2xl border border-espresso/10 bg-white/70 p-6 sm:p-8">
        <div class="mb-6 flex flex-wrap items-start justify-between gap-4 border-b border-espresso/10 pb-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-mahogany">From</p>
                <p class="mt-2 text-lg font-semibold text-espresso">{{ $message->name }}</p>
                <p class="mt-1 text-sm text-ink/70">{{ $message->email }}</p>
                @if ($message->phone)
                    <p class="mt-0.5 text-sm text-ink/70"><a href="tel:{{ preg_replace('/[^\d+]/', '', $message->phone) }}" class="hover:text-mahogany">{{ $message->phone }}</a></p>
                @endif
            </div>
            <div>
                <x-admin.status-badge :status="$message->status" />
                <p class="mt-3 text-xs text-ink/60">{{ $message->created_at->format('M j, Y H:i') }}</p>
            </div>
        </div>

        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-mahogany">Subject</p>
            <h1 class="mt-2 !text-2xl">{{ $message->subject }}</h1>
        </div>

        <div class="mt-8">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-mahogany">Message</p>
            <p class="mt-3 whitespace-pre-line leading-relaxed text-ink/80">{{ $message->message }}</p>
        </div>

        <div class="mt-8 flex flex-wrap gap-3 border-t border-espresso/10 pt-6">
            @if ($message->status !== 'read')
                <form method="POST" action="{{ route('admin.messages.mark-read', $message) }}" class="inline">
                    @csrf @method('PATCH')
                    <x-button type="submit" variant="outline">Mark as Read</x-button>
                </form>
            @endif
            @if ($message->status !== 'archived')
                <form method="POST" action="{{ route('admin.messages.archive', $message) }}" class="inline">
                    @csrf @method('PATCH')
                    <x-button type="submit" variant="outline">Archive</x-button>
                </form>
            @endif
            <a href="mailto:{{ $message->email }}" class="inline-flex min-h-11 items-center rounded-full px-6 text-sm font-semibold uppercase tracking-wider border border-mahogany text-mahogany hover:bg-mahogany hover:text-cream">Reply via Email</a>
        </div>
    </div>
@endsection