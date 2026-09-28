<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Services\ImageService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index(Request $request)
    {
        $events = Event::when($request->string('search')->toString(), fn ($q, $s) => $q->search($s))
            ->when($request->filled('type'), fn ($q) => $q->where('event_type', $request->input('type')))
            ->when($request->filled('status'), fn ($q) => match ($request->input('status')) {
                'published' => $q->where('is_published', true),
                'unpublished' => $q->where('is_published', false),
                'scheduled' => $q->whereNotNull('publish_from'),
                default => $q,
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.events.index', [
            'events' => $events,
            'types' => Event::TYPES,
        ]);
    }

    public function create()
    {
        return view('admin.events.form', ['event' => new Event(['is_published' => false])]);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->safe()->except(['hero_image', 'thumbnail_image', 'banner_image']);

        foreach (['hero_image' => 1920, 'thumbnail_image' => 1200, 'banner_image' => 1920] as $field => $w) {
            if ($request->hasFile($field)) {
                $data[$field] = $this->images->store($request->file($field), 'events', $w);
            }
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    public function update(StoreEventRequest $request, Event $event)
    {
        $data = $request->safe()->except(['hero_image', 'thumbnail_image', 'banner_image']);

        foreach (['hero_image' => 1920, 'thumbnail_image' => 1200, 'banner_image' => 1920] as $field => $w) {
            if ($request->hasFile($field)) {
                $this->images->delete($event->$field);
                $data[$field] = $this->images->store($request->file($field), 'events', $w);
            }
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function togglePublish(Event $event)
    {
        $event->update(['is_published' => ! $event->is_published]);

        return back()->with('success', 'Event ' . ($event->is_published ? 'published' : 'unpublished') . '.');
    }

    public function preview(Event $event)
    {
        return redirect()->route('events.show', $event->slug);
    }

    public function duplicate(Request $request, Event $event)
    {
        $copy = $event->replicate()->fill([
            'slug' => null,
            'is_published' => false,
            'is_featured' => false,
        ]);
        $copy->save();

        return redirect()->route('admin.events.edit', $copy)->with('success', 'Event duplicated. Edit it below.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}