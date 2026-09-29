@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Edit Event</h1>
            <p class="text-muted mb-0">
                Update "{{ $event->title }}"
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Back to Events
            </a>

            <a href="{{ route('admin.events.preview', $event) }}"
               class="btn btn-outline-primary"
               target="_blank">
                <i class="bi bi-eye"></i>
                Preview
            </a>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- Main Content --}}
            <div class="col-lg-8">

                {{-- Basic Information --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-event me-2"></i>
                            Event Information
                        </h5>
                    </div>

                    <div class="card-body">

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Event Title <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $event->title) }}"
                                required
                            >

                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Headline --}}
                        <div class="mb-3">
                            <label for="headline" class="form-label">
                                Headline
                            </label>

                            <input
                                type="text"
                                name="headline"
                                id="headline"
                                class="form-control @error('headline') is-invalid @enderror"
                                value="{{ old('headline', $event->headline) }}"
                            >

                            @error('headline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Short Description --}}
                        <div class="mb-3">
                            <label for="short_description" class="form-label">
                                Short Description
                            </label>

                            <textarea
                                name="short_description"
                                id="short_description"
                                rows="3"
                                class="form-control @error('short_description') is-invalid @enderror"
                            >{{ old('short_description', $event->short_description) }}</textarea>

                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="7"
                                class="form-control @error('description') is-invalid @enderror"
                            >{{ old('description', $event->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Date & Type --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar3 me-2"></i>
                            Date & Event Type
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            {{-- Event Date --}}
                            <div class="col-md-6">
                                <label for="event_date" class="form-label">
                                    Event Date <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="event_date"
                                    id="event_date"
                                    class="form-control @error('event_date') is-invalid @enderror"
                                    value="{{ old('event_date', optional($event->event_date)->format('Y-m-d')) }}"
                                    required
                                >

                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- End Date --}}
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">
                                    End Date
                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    id="end_date"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date', optional($event->end_date)->format('Y-m-d')) }}"
                                >

                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Event Type --}}
                            <div class="col-md-6">
                                <label for="event_type" class="form-label">
                                    Event Type <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="event_type"
                                    id="event_type"
                                    class="form-select @error('event_type') is-invalid @enderror"
                                    required
                                >
                                    @foreach ($types as $key => $label)
                                        <option
                                            value="{{ $key }}"
                                            @selected(old('event_type', $event->event_type) == $key)
                                        >
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('event_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date Label --}}
                            <div class="col-md-6">
                                <label for="date_label" class="form-label">
                                    Date Label
                                </label>

                                <input
                                    type="text"
                                    name="date_label"
                                    id="date_label"
                                    class="form-control @error('date_label') is-invalid @enderror"
                                    value="{{ old('date_label', $event->date_label) }}"
                                    placeholder="Example: December 25, 2026"
                                >

                                @error('date_label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Images --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-images me-2"></i>
                            Event Images
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            {{-- Hero Image --}}
                            <div class="col-md-4">
                                <label class="form-label">Hero Image</label>

                                @if ($event->hero_image)
                                    <div class="mb-2">
                                        <img
                                            src="{{ asset('storage/' . $event->hero_image) }}"
                                            alt="{{ $event->title }}"
                                            class="img-fluid rounded border"
                                            style="height: 140px; width: 100%; object-fit: cover;"
                                        >
                                    </div>
                                @endif

                                <input
                                    type="file"
                                    name="hero_image"
                                    class="form-control @error('hero_image') is-invalid @enderror"
                                    accept="image/*"
                                >

                                @error('hero_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Thumbnail --}}
                            <div class="col-md-4">
                                <label class="form-label">Thumbnail Image</label>

                                @if ($event->thumbnail_image)
                                    <div class="mb-2">
                                        <img
                                            src="{{ asset('storage/' . $event->thumbnail_image) }}"
                                            alt="{{ $event->title }}"
                                            class="img-fluid rounded border"
                                            style="height: 140px; width: 100%; object-fit: cover;"
                                        >
                                    </div>
                                @endif

                                <input
                                    type="file"
                                    name="thumbnail_image"
                                    class="form-control @error('thumbnail_image') is-invalid @enderror"
                                    accept="image/*"
                                >

                                @error('thumbnail_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Banner --}}
                            <div class="col-md-4">
                                <label class="form-label">Banner Image</label>

                                @if ($event->banner_image)
                                    <div class="mb-2">
                                        <img
                                            src="{{ asset('storage/' . $event->banner_image) }}"
                                            alt="{{ $event->title }}"
                                            class="img-fluid rounded border"
                                            style="height: 140px; width: 100%; object-fit: cover;"
                                        >
                                    </div>
                                @endif

                                <input
                                    type="file"
                                    name="banner_image"
                                    class="form-control @error('banner_image') is-invalid @enderror"
                                    accept="image/*"
                                >

                                @error('banner_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Appearance --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-palette me-2"></i>
                            Appearance
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            {{-- Accent Color --}}
                            <div class="col-md-6">
                                <label for="accent_color" class="form-label">
                                    Accent Color
                                </label>

                                <div class="input-group">
                                    <input
                                        type="color"
                                        name="accent_color"
                                        id="accent_color"
                                        class="form-control form-control-color"
                                        value="{{ old('accent_color', $event->accent_color ?: '#8B4513') }}"
                                    >

                                    <input
                                        type="text"
                                        id="accent_color_text"
                                        class="form-control"
                                        value="{{ old('accent_color', $event->accent_color ?: '#8B4513') }}"
                                        maxlength="7"
                                    >
                                </div>

                                @error('accent_color')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Icon --}}
                            <div class="col-md-6">
                                <label for="icon" class="form-label">
                                    Icon
                                </label>

                                <input
                                    type="text"
                                    name="icon"
                                    id="icon"
                                    class="form-control"
                                    value="{{ old('icon', $event->icon) }}"
                                    placeholder="bi bi-calendar-event"
                                >

                                <small class="text-muted">
                                    Bootstrap Icons class name.
                                </small>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- SEO --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-search me-2"></i>
                            SEO
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label for="meta_title" class="form-label">
                                Meta Title
                            </label>

                            <input
                                type="text"
                                name="meta_title"
                                id="meta_title"
                                class="form-control @error('meta_title') is-invalid @enderror"
                                value="{{ old('meta_title', $event->meta_title) }}"
                                maxlength="255"
                            >

                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">
                                Meta Description
                            </label>

                            <textarea
                                name="meta_description"
                                id="meta_description"
                                rows="3"
                                maxlength="500"
                                class="form-control @error('meta_description') is-invalid @enderror"
                            >{{ old('meta_description', $event->meta_description) }}</textarea>

                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Publishing --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-send me-2"></i>
                            Publishing
                        </h5>
                    </div>

                    <div class="card-body">

                        {{-- Published --}}
                        <div class="form-check form-switch mb-3">
                            <input
                                type="hidden"
                                name="is_published"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_published"
                                value="1"
                                id="is_published"
                                @checked(old('is_published', $event->is_published))
                            >

                            <label class="form-check-label" for="is_published">
                                <strong>Published</strong>
                            </label>
                        </div>

                        {{-- Featured --}}
                        <div class="form-check form-switch mb-3">
                            <input
                                type="hidden"
                                name="is_featured"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_featured"
                                value="1"
                                id="is_featured"
                                @checked(old('is_featured', $event->is_featured))
                            >

                            <label class="form-check-label" for="is_featured">
                                Featured Event
                            </label>
                        </div>

                        {{-- Homepage --}}
                        <div class="form-check form-switch mb-3">
                            <input
                                type="hidden"
                                name="show_on_homepage"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="show_on_homepage"
                                value="1"
                                id="show_on_homepage"
                                @checked(old('show_on_homepage', $event->show_on_homepage))
                            >

                            <label class="form-check-label" for="show_on_homepage">
                                Show on Homepage
                            </label>
                        </div>

                        {{-- Countdown --}}
                        <div class="form-check form-switch mb-3">
                            <input
                                type="hidden"
                                name="show_countdown"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="show_countdown"
                                value="1"
                                id="show_countdown"
                                @checked(old('show_countdown', $event->show_countdown))
                            >

                            <label class="form-check-label" for="show_countdown">
                                Show Countdown
                            </label>
                        </div>

                        {{-- Commemorative --}}
                        <div class="form-check form-switch mb-3">
                            <input
                                type="hidden"
                                name="is_commemorative"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_commemorative"
                                value="1"
                                id="is_commemorative"
                                @checked(old('is_commemorative', $event->is_commemorative ?? false))
                            >

                            <label class="form-check-label" for="is_commemorative">
                                Commemorative Event
                            </label>
                        </div>

                        {{-- Sort Order --}}
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">
                                Sort Order
                            </label>

                            <input
                                type="number"
                                name="sort_order"
                                id="sort_order"
                                class="form-control"
                                value="{{ old('sort_order', $event->sort_order ?? 0) }}"
                                min="0"
                            >
                        </div>

                    </div>
                </div>

                {{-- Publish Schedule --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-clock me-2"></i>
                            Publish Schedule
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label for="publish_from" class="form-label">
                                Publish From
                            </label>

                            <input
                                type="datetime-local"
                                name="publish_from"
                                id="publish_from"
                                class="form-control"
                                value="{{ old('publish_from', optional($event->publish_from)->format('Y-m-d\TH:i')) }}"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="publish_until" class="form-label">
                                Publish Until
                            </label>

                            <input
                                type="datetime-local"
                                name="publish_until"
                                id="publish_until"
                                class="form-control"
                                value="{{ old('publish_until', optional($event->publish_until)->format('Y-m-d\TH:i')) }}"
                            >
                        </div>

                    </div>
                </div>

                {{-- CTA --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-link-45deg me-2"></i>
                            Button / CTA
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label for="button_text" class="form-label">
                                Button Text
                            </label>

                            <input
                                type="text"
                                name="button_text"
                                id="button_text"
                                class="form-control"
                                value="{{ old('button_text', $event->button_text) }}"
                                placeholder="Learn More"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="button_url" class="form-label">
                                Button URL
                            </label>

                            <input
                                type="url"
                                name="button_url"
                                id="button_url"
                                class="form-control"
                                value="{{ old('button_url', $event->button_url) }}"
                                placeholder="https://example.com"
                            >
                        </div>

                    </div>
                </div>

                {{-- Store --}}
                @if(isset($stores) && $stores->count())
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="bi bi-shop me-2"></i>
                                Store
                            </h5>
                        </div>

                        <div class="card-body">
                            <label for="store_id" class="form-label">
                                Store
                            </label>

                            <select
                                name="store_id"
                                id="store_id"
                                class="form-select"
                            >
                                <option value="">All Stores</option>

                                @foreach($stores as $store)
                                    <option
                                        value="{{ $store->id }}"
                                        @selected(old('store_id', $event->store_id ?? null) == $store->id)
                                    >
                                        {{ $store->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                {{-- Save --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-check-lg me-1"></i>
                            Update Event
                        </button>

                        <a
                            href="{{ route('admin.events.index') }}"
                            class="btn btn-outline-secondary w-100"
                        >
                            Cancel
                        </a>

                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const color = document.getElementById('accent_color');
    const colorText = document.getElementById('accent_color_text');

    if (color && colorText) {
        color.addEventListener('input', function () {
            colorText.value = this.value;
        });

        colorText.addEventListener('input', function () {
            const value = this.value.trim();

            if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                color.value = value;
            }
        });
    }
});
</script>
@endsection