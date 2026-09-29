<?php

namespace App\Support;

use App\Models\Event;
use Illuminate\Support\Facades\Cache;

class SeasonalTheme
{
    private const SEASONS = [
        'winter' => ['months' => [12, 1, 2], 'accent' => '#5B7A99', 'label' => 'Winter'],
        'spring' => ['months' => [3, 4, 5], 'accent' => '#6B8E5A', 'label' => 'Spring'],
        'summer' => ['months' => [6, 7, 8], 'accent' => '#C9862A', 'label' => 'Summer'],
        'fall'   => ['months' => [9, 10, 11], 'accent' => '#A0522D', 'label' => 'Fall'],
    ];

    /** Cached per day. Returns accent, text colour, and an optional event for the bar. */
    public static function current(): array
    {
        return Cache::remember('seasonal-theme:' . today()->toDateString(), 3600, function () {
            $season = collect(self::SEASONS)->first(fn ($s) => in_array(today()->month, $s['months'], true));

            $event = Event::visible()->upcoming()
                ->whereDate('event_date', '<=', today()->addDays(10))
                ->orderBy('event_date')->limit(5)->get()
                // Commemorative days only appear in the last 3 days before.
                ->first(fn ($e) => $e->event_date->lte(today()->addDays($e->is_commemorative ? 3 : 10)));

            $accent = $event?->accent_color ?: $season['accent'];

            return [
                'accent' => $accent,
                'text' => self::readableText($accent),
                'season' => $season['label'],
                'bar' => $event ? [
                    'title' => $event->title,
                    'date' => $event->display_date,
                    'icon' => $event->icon,
                    'today' => $event->status === 'today',
                    'url' => route('events.show', $event),
                ] : null,
            ];
        });
    }

    private static function readableText(string $hex): string
    {
        [$r, $g, $b] = sscanf(ltrim($hex, '#'), '%02x%02x%02x');
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminance > 0.6 ? '#1C1107' : '#FDF5E6';
    }
}