@props(['active' => true, 'on' => 'Active', 'off' => 'Inactive'])

<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $active ? 'bg-green-100 text-green-800' : 'bg-ink/10 text-ink/60' }}">
    {{ $active ? $on : $off }}
</span>