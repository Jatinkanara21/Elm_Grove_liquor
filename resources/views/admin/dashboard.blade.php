@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
    <x-admin.page-header title="Dashboard" />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as [$label, $value, $route, $note])
            @php $linked = Route::has($route); @endphp
            <{{ $linked ? 'a href=' . route($route) : 'div' }}
                class="rounded-2xl border border-espresso/10 bg-white/70 p-5 shadow-sm {{ $linked ? 'transition hover:-translate-y-0.5 hover:shadow-md' : '' }}">
                <p class="eyebrow">{{ $label }}</p>
                <p class="mt-2 font-serif text-4xl font-bold text-espresso">{{ $value }}</p>
                @if ($note)<p class="mt-1 text-xs text-ink/60">{{ $note }}</p>@endif
            </{{ $linked ? 'a' : 'div' }}>
        @endforeach
    </div>

    <h2 class="mt-12 !text-2xl">Quick Actions</h2>
    <div class="mt-4 flex flex-wrap gap-3">
        @foreach ([
            ['Add Product', 'admin.products.create'],
            ['Add Store', 'admin.stores.create'],
            ['Add Event', 'admin.events.create'],
            ['Review Submissions', 'admin.reviews.index'],
            ['View Messages', 'admin.messages.index'],
        ] as [$label, $route])
            @if (Route::has($route))
                <x-button :href="route($route)" variant="outline">{{ $label }}</x-button>
            @endif
        @endforeach
    </div>
@endsection