<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::query()->when($request->filled('year'), fn ($q) => $q->whereYear('event_date', (int) $request->integer('year')))
            ->latest('event_date')->paginate(20)->withQueryString();
        return view('admin.events.index', compact('events'));
    }

    public function create(): View { return view('admin.events.form', ['event' => new Event]); }

    public function store(Request $request): RedirectResponse
    {
        $event = Event::create($this->validated($request));
        return redirect()->route('admin.events.index')->with('success', "Event {$event->title} created.");
    }

    public function edit(Event $event): View { return view('admin.events.form', compact('event')); }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $event->update($this->validated($request));
        return redirect()->route('admin.events.index')->with('success', "Event {$event->title} updated.");
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();
        return back()->with('success', 'Event deleted.');
    }

    public function togglePublish(Event $event): RedirectResponse
    {
        $event->update(['is_published' => ! $event->is_published]);
        return back()->with('success', $event->is_published ? 'Event published.' : 'Event unpublished.');
    }

    public function preview(Event $event): View
    {
        return view('events.show', ['event' => $event]);
    }

    public function duplicate(Event $event): RedirectResponse
    {
        $copy = $event->replicate();
        $copy->title = $event->title . ' Copy';
        $copy->slug = null;
        $copy->is_published = false;
        $copy->save();
        return redirect()->route('admin.events.edit', $copy)->with('success', 'Event duplicated as a draft.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required','string','max:150'],
            'slug' => ['nullable','string','max:180'],
            'headline' => ['nullable','string','max:200'],
            'date_label' => ['nullable','string','max:100'],
            'short_description' => ['required','string','max:500'],
            'description' => ['nullable','string','max:5000'],
            'event_date' => ['required','date'],
            'end_date' => ['nullable','date','after_or_equal:event_date'],
            'event_type' => ['required','in:'.implode(',', array_keys(Event::TYPES))],
            'hero_image' => ['nullable','string','max:500'],
            'thumbnail_image' => ['nullable','string','max:500'],
            'banner_image' => ['nullable','string','max:500'],
            'icon' => ['nullable','string','max:100'],
            'accent_color' => ['nullable','regex:/^#[0-9A-Fa-f]{6}$/'],
            'button_text' => ['nullable','string','max:80'],
            'button_url' => ['nullable','url','max:500'],
            'publish_from' => ['nullable','date'],
            'publish_until' => ['nullable','date','after_or_equal:publish_from'],
            'is_featured' => ['sometimes','boolean'],
            'is_published' => ['sometimes','boolean'],
            'show_on_homepage' => ['sometimes','boolean'],
            'show_countdown' => ['sometimes','boolean'],
            'sort_order' => ['nullable','integer','min:0','max:9999'],
            'meta_title' => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string','max:500'],
        ]);
    }
}