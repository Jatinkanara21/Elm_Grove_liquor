<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /** Upcoming and today's events. */
    public function index(Request $request)
    {
        $filters = $this->filters($request);

        $events = Event::visible()
            ->upcoming()
            ->search($filters['search'] ?? null)
            ->when($filters['type'] ?? null, fn ($q, $t) => $q->where('event_type', $t))
            ->orderBy('event_date')
            ->orderBy('sort_order')
            ->paginate(12)
            ->withQueryString();

        return view('events.index', [
            'events' => $events,
            'types' => Event::TYPES,
        ]);
    }

    /** Past events, filterable by year and type. Works for any future year automatically. */
    public function archive(Request $request)
    {
        $filters = $this->filters($request);

        $events = Event::visible()
            ->past()
            ->search($filters['search'] ?? null)
            ->when($filters['type'] ?? null, fn ($q, $t) => $q->where('event_type', $t))
            ->when($filters['year'] ?? null, fn ($q, $y) => $q->inYear((int) $y))
            ->orderByDesc('event_date')
            ->paginate(12)
            ->withQueryString();

        $years = Event::visible()
            ->past()
            ->selectRaw('YEAR(event_date) as y')
            ->distinct()
            ->orderByDesc('y')
            ->pluck('y');

        return view('events.archive', [
            'events' => $events,
            'types' => Event::TYPES,
            'years' => $years,
        ]);
    }

    public function show(Event $event)
    {
        // Unpublished or out-of-schedule events 404 for the public; admins may preview them.
        $visible = Event::visible()->whereKey($event->id)->exists();
        abort_unless($visible || auth()->user()?->is_admin, 404);

        $related = Event::visible()
            ->whereKeyNot($event->id)
            ->orderByRaw('ABS(DATEDIFF(event_date, ?))', [$event->event_date->toDateString()])
            ->take(3)
            ->get();

        return view('events.show', [
            'event' => $event,
            'related' => $related,
            'store' => Store::active()->first(),
        ]);
    }

    private function filters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', Rule::in(array_keys(Event::TYPES))],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
    }
}