<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Support\UsHolidays;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateUsEvents extends Command
{
    protected $signature = 'events:generate {year : e.g. 2027} {--publish : Publish immediately instead of saving as drafts}';
    protected $description = 'Create US federal holidays and national observances for a given year';

    public function handle(): int
    {
        $year = (int) $this->argument('year');
        if ($year < 2000 || $year > 2100) {
            $this->error('Year must be between 2000 and 2100.');
            return self::FAILURE;
        }

        $created = 0;
        foreach (UsHolidays::forYear($year) as $i => $h) {
            // withTrashed: a holiday you deleted on purpose is not regenerated.
            $exists = Event::withTrashed()
                ->where('title', $h['title'])
                ->whereYear('event_date', $year)
                ->exists();
            if ($exists) {
                continue;
            }

            Event::create([
                'title' => $h['title'],
                'slug' => Str::slug($h['title']) . '-' . $year,
                'headline' => $h['headline'],
                'short_description' => $h['short'],
                'description' => $h['short'],
                'event_date' => $h['date']->toDateString(),
                'date_label' => $h['label'],
                'event_type' => $h['type'],
                'accent_color' => $h['accent'],
                'icon' => $h['icon'],
                'is_published' => (bool) $this->option('publish'),
                'show_on_homepage' => true,
                'sort_order' => $i,
                'meta_title' => "{$h['title']} {$year} | Elm Grove Liquor",
                'meta_description' => $h['short'],
            ]);
            $created++;
        }

        $this->info("Created {$created} events for {$year}" . ($this->option('publish') ? ' (published).' : ' as drafts. Review and publish them in Admin > Events.'));

        return self::SUCCESS;
    }
}