@props(['title', 'action' => null, 'actionLabel' => null])

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="!text-3xl sm:!text-4xl">{{ $title }}</h1>
    @if ($action)
        <x-button :href="$action">{{ $actionLabel }}</x-button>
    @endif
</div>