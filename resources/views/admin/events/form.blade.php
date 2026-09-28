@extends('layouts.admin')

@php $title = $event->exists ? 'Edit Event' : 'Add Event'; @endphp
@section('page_title', $title)

@section('content')
    <x-admin.page-header :title="$title" />

    <form method="POST" enctype="multipart/form-data" data-once novalidate
          action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}"
          class="max-w-4xl space-y-8 rounded-2xl border border-espresso/10 bg-white/70 p-6 sm:p-8">
        @csrf
        @if ($event->exists) @method('PUT') @endif

        <div>
            <h2 class="!text-2xl">Basic Information</h2>
            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <x-input name="title" label="Event Title" :value="$event->title" required />
                <x-input name="slug" label="Slug (optional)" :value="$event->slug" placeholder="auto-generated" />
                <x-admin.select name="event_type" label="Event Type" :value="$event->event_type" placeholder="Select a type"
                                :options="\App\Models\Event::TYPES" required />
                <div class="grid grid-cols-2 gap-3">
                    <x-input name="event_date" label="Start Date" type="date" :value="$event->event_date?->toDateString()" required />
                    <x-input name="end_date" label="End Date (optional)" type="date" :value="$event->end_date?->toDateString()" />
                </div>
            </div>
        </div>

        <div>
            <h2 class="!text-2xl">Content</h2>
            <div class="mt-5 space-y-5">
                <x-input name="headline" label="Headline (optional)" :value="$event->headline" placeholder="e.g., Gather. Give Thanks. Celebrate." />
                <x-input name="short_description" label="Short Description" :value="$event->short_description" maxlength="500" />
                <x-textarea name="description" label="Full Description" :value="$event->description" rows="6" />
            </div>
        </div>

        <div>
            <h2 class="!text-2xl">Images</h2>
            <p class="mt-1 text-sm text-ink/60">Hero (1920×900), Thumbnail (1200×800), Banner (1920×600)</p>
            <div class="mt-5 grid gap-5 sm:grid-cols-3">
                <x-admin.image-field name="hero_image" label="Hero Image" :current="$event->hero_image" />
                <x-admin.image-field name="thumbnail_image" label="Thumbnail" :current="$event->thumbnail_image" />
                <x-admin.image-field name="banner_image" label="Banner" :current="$event->banner_image" />
            </div>
        </div>

        <div>
            <h2 class="!text-2xl">Design & Metadata</h2>
            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <x-admin.color-picker name="accent_color" label="Accent Color" :value="$event->accent_color" />
                <x-input name="icon" label="Icon (optional)" :value="$event->icon" />
                <x-input name="date_label" label="Date Label Override (optional)" :value="$event->date_label" placeholder="e.g., July 3, 2026 — Observed" />
                <x-input name="sort_order" label="Sort Order" type="number" min="0" :value="$event->sort_order ?? 0" />
            </div>

            <div class="mt-5 space-y-3">
                <x-input name="meta_title" label="SEO Title (optional)" :value="$event->meta_title" maxlength="255" />
                <x-input name="meta_description" label="SEO Description (optional)" :value="$event->meta_description" maxlength="320" />
            </div>

            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <x-input name="button_text" label="CTA Button Text (optional)" :value="$event->button_text" />
                <x-input name="button_url" label="CTA Button URL (optional)" :value="$event->button_url" type="url" />
            </div>
        </div>

        <div>
            <h2 class="!text-2xl">Publishing</h2>
            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <x-admin.checkbox name="is_published" label="Published" hint="Unpublished events are hidden from the public." :checked="$event->is_published" />
                <x-admin.checkbox name="show_on_homepage" label="Show on Homepage" hint="Appears in the 'What's Coming Up' section." :checked="$event->show_on_homepage" />
                <x-admin.checkbox name="is_featured" label="Featured" hint="Can be highlighted on the events page." :checked="$event->is_featured" />
                <x-admin.checkbox name="show_countdown" label="Show Countdown Timer" :checked="$event->show_countdown" />
            </div>

            <div class="mt-5">
                <p class="mb-3 text-sm font-semibold text-espresso">Schedule (optional)</p>
                <div class="grid gap-3 sm:grid-cols-2">
                    <x-admin.datetime name="publish_from" label="Publish From" :value="$event->publish_from" />
                    <x-admin.datetime name="publish_until" label="Publish Until" :value="$event->publish_until" />
                </div>
                <p class="mt-2 text-xs text-ink/60">Leave blank to publish immediately when marked as Published.</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 border-t border-espresso/10 pt-6">
            <x-button type="submit" data-loading="Saving...">Save Event</x-button>
            @if ($event->exists && $event->is_published)
                <x-button :href="route('events.show', $event)" variant="outline" target="_blank">Preview Public Page ↗</x-button>
            @endif
            <x-button :href="route('admin.events.index')" variant="outline">Cancel</x-button>
        </div>
    </form>
@endsection