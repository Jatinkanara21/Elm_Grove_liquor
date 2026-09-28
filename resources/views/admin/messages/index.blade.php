@extends('layouts.admin')

@section('page_title', 'Messages')

@section('content')
    <x-admin.page-header title="Contact Messages" />

    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.messages.index') }}"
           class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ ! request('status') ? 'bg-mahogany text-cream' : 'bg-white/70 text-ink' }}">
            All
        </a>
        <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}"
           class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ request('status') === 'unread' ? 'bg-blue-600 text-white' : 'bg-white/70 text-ink' }}">
            Unread ({{ $unread }})
        </a>
        <a href="{{ route('admin.messages.index', ['status' => 'read']) }}"
           class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ request('status') === 'read' ? 'bg-green-600 text-white' : 'bg-white/70 text-ink' }}">
            Read
        </a>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-espresso/10 bg-white/70">
        <table class="w-full min-w-[40rem] text-left text-sm">
            <thead class="border-b border-espresso/10 bg-beige/60 text-xs uppercase tracking-wider text-espresso">
                <tr>
                    <th scope="col" class="px-4 py-3">From</th>
                    <th scope="col" class="px-4 py-3">Subject</th>
                    <th scope="col" class="px-4 py-3">Status</th>
                    <th scope="col" class="px-4 py-3">Date</th>
                    <th scope="col" class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-espresso/10">
                @forelse ($messages as $msg)
                    <tr class="{{ $msg->status === 'unread' ? 'bg-blue-50' : '' }}">
                        <td class="px-4 py-3">
                            <p class="font-semibold text-espresso">{{ $msg->name }}</p>
                            <p class="text-xs text-ink/60">{{ $msg->email }}</p>
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $msg->subject }}</td>
                        <td class="px-4 py-3"><x-admin.status-badge :status="$msg->status" /></td>
                        <td class="px-4 py-3 text-xs">{{ $msg->created_at->format('M j, Y') }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-right text-xs">
                            <a href="{{ route('admin.messages.show', $msg) }}"
                               class="inline-flex min-h-9 items-center px-2 font-semibold text-mahogany hover:underline">View</a>
                            @if ($msg->status !== 'read')
                                <form method="POST" action="{{ route('admin.messages.mark-read', $msg) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="min-h-9 px-2 font-semibold text-mahogany hover:underline">Mark Read</button>
                                </form>
                            @endif
                            @if ($msg->status !== 'archived')
                                <form method="POST" action="{{ route('admin.messages.archive', $msg) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="min-h-9 px-2 font-semibold text-mahogany hover:underline">Archive</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-ink/60">No messages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $messages->links() }}</div>
@endsection