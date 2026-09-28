@props(['status'])

@php
    $styles = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'approved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        'unread' => 'bg-blue-100 text-blue-800',
        'read' => 'bg-ink/10 text-ink/60',
        'replied' => 'bg-green-100 text-green-800',
        'archived' => 'bg-ink/10 text-ink/60',
        'published' => 'bg-green-100 text-green-800',
        'unpublished' => 'bg-ink/10 text-ink/60',
        'scheduled' => 'bg-blue-100 text-blue-800',
    ];
@endphp

<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $styles[$status] ?? 'bg-ink/10 text-ink/60' }}">
    {{ Str::headline($status) }}
</span>