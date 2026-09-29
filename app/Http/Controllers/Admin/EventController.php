<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('headline', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Event Type Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type')) {
            $query->where(
                'event_type',
                $request->input('type')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Publication Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            switch ($request->input('status')) {
                case 'published':
                    $query->where('is_published', true);
                    break;

                case 'draft':
                    $query->where('is_published', false);
                    break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */

        $events = $query
            ->orderByDesc('event_date')
            ->orderBy('sort_order')
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Event Types
        |--------------------------------------------------------------------------
        |
        | This variable is required by:
        | resources/views/admin/events/index.blade.php
        |
        */

        $types = Event::TYPES;

        return view('admin.events.index', [
            'events' => $events,
            'types' => $types,
        ]);
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $event = new Event();

        $types = Event::TYPES;

        $stores = Store::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.events.create', [
            'event' => $event,
            'types' => $types,
            'stores' => $stores,
        ]);
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $this->validateEvent($request);

        /*
        |--------------------------------------------------------------------------
        | Generate slug
        |--------------------------------------------------------------------------
        */

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?? $validated['title']
        );

        /*
        |--------------------------------------------------------------------------
        | Boolean fields
        |--------------------------------------------------------------------------
        */

        $validated['is_published'] = $request->boolean('is_published');
        $validated['show_on_homepage'] = $request->boolean('show_on_homepage');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['show_countdown'] = $request->boolean('show_countdown');
        $validated['is_commemorative'] = $request->boolean('is_commemorative');

        /*
        |--------------------------------------------------------------------------
        | Images
        |--------------------------------------------------------------------------
        */

        foreach ([
            'hero_image',
            'thumbnail_image',
            'banner_image',
        ] as $imageField) {
            if ($request->hasFile($imageField)) {
                $validated[$imageField] = $request
                    ->file($imageField)
                    ->store('events', 'public');
            }
        }

        $event = Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event)
    {
        $types = Event::TYPES;

        $stores = Store::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.events.edit', [
            'event' => $event,
            'types' => $types,
            'stores' => $stores,
        ]);
    }

    /**
     * Update an existing event.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $this->validateEvent(
            $request,
            $event
        );

        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?? $validated['title'],
            $event->id
        );

        /*
        |--------------------------------------------------------------------------
        | Boolean fields
        |--------------------------------------------------------------------------
        */

        $validated['is_published'] = $request->boolean('is_published');
        $validated['show_on_homepage'] = $request->boolean('show_on_homepage');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['show_countdown'] = $request->boolean('show_countdown');
        $validated['is_commemorative'] = $request->boolean('is_commemorative');

        /*
        |--------------------------------------------------------------------------
        | Images
        |--------------------------------------------------------------------------
        */

        foreach ([
            'hero_image',
            'thumbnail_image',
            'banner_image',
        ] as $imageField) {
            if ($request->hasFile($imageField)) {

                /*
                 * Delete previous image.
                 */
                if (
                    !empty($event->{$imageField}) &&
                    Storage::disk('public')->exists($event->{$imageField})
                ) {
                    Storage::disk('public')->delete(
                        $event->{$imageField}
                    );
                }

                /*
                 * Store new image.
                 */
                $validated[$imageField] = $request
                    ->file($imageField)
                    ->store('events', 'public');
            }
        }

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Delete an event.
     */
    public function destroy(Event $event)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete event images
        |--------------------------------------------------------------------------
        */

        foreach ([
            'hero_image',
            'thumbnail_image',
            'banner_image',
        ] as $imageField) {
            if (
                !empty($event->{$imageField}) &&
                Storage::disk('public')->exists($event->{$imageField})
            ) {
                Storage::disk('public')->delete(
                    $event->{$imageField}
                );
            }
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Toggle event publication status.
     */
    public function togglePublish(Event $event)
    {
        $event->update([
            'is_published' => !$event->is_published,
        ]);

        return back()->with(
            'success',
            $event->is_published
                ? 'Event published successfully.'
                : 'Event unpublished successfully.'
        );
    }

    /**
     * Preview an event.
     */
    public function preview(Event $event)
    {
        $store = Store::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->first();

        return view('events.show', [
            'event' => $event,
            'store' => $store,
            'preview' => true,
        ]);
    }

    /**
     * Duplicate an event.
     */
    public function duplicate(Event $event)
    {
        $copy = $event->replicate();

        $copy->title = $event->title . ' Copy';

        $copy->slug = $this->uniqueSlug(
            $event->slug . '-copy'
        );

        /*
        |--------------------------------------------------------------------------
        | Duplicates should start unpublished.
        |--------------------------------------------------------------------------
        */

        $copy->is_published = false;

        $copy->show_on_homepage = false;

        $copy->is_featured = false;

        $copy->save();

        return redirect()
            ->route('admin.events.edit', $copy)
            ->with(
                'success',
                'Event duplicated successfully. The duplicate is currently unpublished.'
            );
    }

    /**
     * Validate event data.
     */
    private function validateEvent(
        Request $request,
        ?Event $event = null
    ): array {
        $eventId = $event?->id;

        return $request->validate([
            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('events', 'slug')
                    ->ignore($eventId),
            ],

            'event_type' => [
                'required',
                'string',
                Rule::in(array_keys(Event::TYPES)),
            ],

            'headline' => [
                'nullable',
                'string',
                'max:255',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'required',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            'event_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:event_date',
            ],

            'date_label' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Images
            |--------------------------------------------------------------------------
            */

            'hero_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
            ],

            'thumbnail_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
            ],

            'banner_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
            ],

            /*
            |--------------------------------------------------------------------------
            | Design
            |--------------------------------------------------------------------------
            */

            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],

            'accent_color' => [
                'nullable',
                'string',
                'max:20',
            ],

            /*
            |--------------------------------------------------------------------------
            | Button
            |--------------------------------------------------------------------------
            */

            'button_text' => [
                'nullable',
                'string',
                'max:100',
            ],

            'button_url' => [
                'nullable',
                'string',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Publishing
            |--------------------------------------------------------------------------
            */

            'publish_from' => [
                'nullable',
                'date',
            ],

            'publish_until' => [
                'nullable',
                'date',
                'after_or_equal:publish_from',
            ],

            /*
            |--------------------------------------------------------------------------
            | Settings
            |--------------------------------------------------------------------------
            */

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:9999',
            ],

            'is_published' => [
                'nullable',
                'boolean',
            ],

            'show_on_homepage' => [
                'nullable',
                'boolean',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'show_countdown' => [
                'nullable',
                'boolean',
            ],

            'is_commemorative' => [
                'nullable',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);
    }

    /**
     * Generate a unique event slug.
     */
    private function uniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'event';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            Event::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}