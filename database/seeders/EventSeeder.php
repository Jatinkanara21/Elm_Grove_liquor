<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * 2026 initial dataset. Future years are added from Admin > Events;
 * nothing in the models or controllers depends on 2026.
 */
class EventSeeder extends Seeder
{
    public function run(): void
    {
        // [title, date, type, headline, short description, accent, date_label, featured]
        $events = [
            ["New Year's Day", '2026-01-01', 'federal_holiday', 'Welcome the New Year',
                'Celebrate the beginning of a new year.', '#C9A227', null, true],
            ['Martin Luther King Jr. Day', '2026-01-19', 'federal_holiday', 'Honoring a Legacy of Service and Equality',
                'A day to remember Dr. King and reflect on service and equality.', '#B8933A', null, false],
            ["Presidents' Day", '2026-02-16', 'federal_holiday', "Presidents' Day",
                "Washington's Birthday, observed on the third Monday of February.", '#7A2E2E', null, false],
            ['Memorial Day', '2026-05-25', 'federal_holiday', 'Remember. Honor. Reflect.',
                'A day to remember and honor those who died in military service.', '#5B6472', null, false],
            ['Juneteenth National Independence Day', '2026-06-19', 'federal_holiday', 'Honoring Freedom, History, and Progress',
                'Commemorating the end of slavery in the United States.', '#8B2E2E', null, false],
            ['Independence Day', '2026-07-03', 'federal_holiday', 'Celebrate Independence Day',
                'Observed Friday, July 3, 2026. The holiday falls on Saturday, July 4.', '#2F4A7A', 'July 3, 2026 — Observed', true],
            ['Labor Day', '2026-09-07', 'federal_holiday', 'Labor Day',
                'Recognizing the contributions of American workers.', '#8B4513', null, false],
            ['Columbus Day', '2026-10-12', 'federal_holiday', 'Columbus Day',
                'Federal holiday observed on the second Monday of October.', '#A0522D', null, false],
            ['Veterans Day', '2026-11-11', 'federal_holiday', 'Honoring Those Who Have Served',
                'A day to honor all who have served in the U.S. Armed Forces.', '#4A5568', null, false],
            ['Thanksgiving Day', '2026-11-26', 'federal_holiday', 'Gather. Give Thanks. Celebrate.',
                'Gather with family and friends this Thanksgiving.', '#B7791F', null, true],
            ['Christmas Day', '2026-12-25', 'federal_holiday', 'Celebrate the Season',
                'Warm wishes for a festive holiday season.', '#2F5D46', null, true],
        ];

        foreach ($events as $i => [$title, $date, $type, $headline, $short, $accent, $label, $featured]) {
            Event::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'headline' => $headline,
                    'short_description' => $short,
                    'description' => $short,
                    'event_date' => $date,
                    'event_type' => $type,
                    'accent_color' => $accent,
                    'date_label' => $label,
                    'is_featured' => $featured,
                    'is_published' => true,
                    'show_on_homepage' => true,
                    'sort_order' => $i,
                    'meta_title' => "$title | Elm Grove Liquor",
                    'meta_description' => $short,
                ]
            );
        }
    }
}