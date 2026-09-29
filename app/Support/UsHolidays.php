<?php

namespace App\Support;

use Carbon\CarbonImmutable;

class UsHolidays
{
    /** Easter Sunday (anonymous Gregorian algorithm; no calendar extension needed). */
    public static function easter(int $y): CarbonImmutable
    {
        $a = $y % 19; $b = intdiv($y, 100); $c = $y % 100;
        $d = intdiv($b, 4); $e = $b % 4; $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4); $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return CarbonImmutable::create($y, $month, $day);
    }

    public static function forYear(int $y): array
    {
        $nth = fn (string $rule, string $month) => CarbonImmutable::parse("$rule of $month $y");
        $fixed = fn (int $m, int $d) => CarbonImmutable::create($y, $m, $d);

        // [title, date, type, headline, short description, accent, icon, shift if weekend]
        $rows = [
            ["New Year's Day", $fixed(1, 1), 'federal_holiday', 'Welcome the New Year', 'Celebrate the beginning of a new year. Please celebrate responsibly.', '#C9A227', '🎆', false],
            ['Martin Luther King Jr. Day', $nth('third monday', 'January'), 'federal_holiday', 'Honoring a Legacy of Service and Equality', 'A day to remember Dr. King and reflect on service and equality.', '#B8933A', '🕊️', false],
            ['Valentine\'s Day', $fixed(2, 14), 'national_holiday', 'Share the Love', 'Celebrate the people you love. Please celebrate responsibly.', '#9B2C4A', '❤️', false],
            ["Presidents' Day", $nth('third monday', 'February'), 'federal_holiday', "Presidents' Day", "Washington's Birthday, observed on the third Monday of February.", '#7A2E2E', '🇺🇸', false],
            ["St. Patrick's Day", $fixed(3, 17), 'national_holiday', 'Lucky Day', 'Celebrate Irish heritage. Please celebrate responsibly.', '#2F6B45', '☘️', false],
            ['Easter Sunday', self::easter($y), 'national_holiday', 'Gather This Easter', 'Wishing you a warm spring celebration with family and friends.', '#8E7CC3', '🌷', false],
            ['Cinco de Mayo', $fixed(5, 5), 'national_holiday', 'Celebrate Cinco de Mayo', 'Celebrating Mexican heritage and culture. Please celebrate responsibly.', '#2F7D5B', '🎉', false],
            ["Mother's Day", $nth('second sunday', 'May'), 'national_holiday', 'Celebrate Mom', 'A day to thank the mothers and mother figures in our lives.', '#C2607F', '💐', false],
            ['Memorial Day', $nth('last monday', 'May'), 'federal_holiday', 'Remember. Honor. Reflect.', 'A day to remember and honor those who died in military service.', '#5B6472', '🇺🇸', false],
            ['Juneteenth National Independence Day', $fixed(6, 19), 'federal_holiday', 'Honoring Freedom, History, and Progress', 'Commemorating the end of slavery in the United States.', '#8B2E2E', '✊', true],
            ["Father's Day", $nth('third sunday', 'June'), 'national_holiday', 'Celebrate Dad', 'A day to thank the fathers and father figures in our lives.', '#3B5B7A', '👔', false],
            ['Independence Day', $fixed(7, 4), 'federal_holiday', 'Celebrate Independence Day', 'Celebrate with family and friends. Please celebrate responsibly.', '#2F4A7A', '🎇', true],
            ['Labor Day', $nth('first monday', 'September'), 'federal_holiday', 'Labor Day', 'Recognizing the contributions of American workers.', '#8B4513', '🛠️', false],
            ['Patriot Day', $fixed(9, 11), 'national_holiday', 'Never Forget', 'A day of remembrance for those lost on September 11, 2001.', '#4A5568', '🕯️', false],
            ['Columbus Day', $nth('second monday', 'October'), 'federal_holiday', 'Columbus Day', 'Federal holiday observed on the second Monday of October.', '#A0522D', '🍂', false],
            ['Halloween', $fixed(10, 31), 'national_holiday', 'Treat Yourself', 'Get ready for Halloween gatherings. Please celebrate responsibly.', '#D97A1F', '🎃', false],
            ['Veterans Day', $fixed(11, 11), 'federal_holiday', 'Honoring Those Who Have Served', 'A day to honor all who have served in the U.S. Armed Forces.', '#4A5568', '🎖️', true],
            ['Thanksgiving Day', $nth('fourth thursday', 'November'), 'federal_holiday', 'Gather. Give Thanks. Celebrate.', 'Gather with family and friends this Thanksgiving.', '#B7791F', '🦃', false],
            ['Christmas Day', $fixed(12, 25), 'federal_holiday', 'Celebrate the Season', 'Warm wishes for a festive holiday season.', '#2F5D46', '🎄', true],
            ["New Year's Eve", $fixed(12, 31), 'national_holiday', 'Ring in the New Year', 'Toast to the year ahead. Please celebrate responsibly and never drink and drive.', '#1F2A44', '🥂', false],
        ];

        $out = [];
        foreach ($rows as [$title, $date, $type, $headline, $short, $accent, $icon, $shift]) {
            $label = null;
            if ($shift && in_array($date->dayOfWeek, [0, 6], true)) {
                $date = $date->dayOfWeek === 6 ? $date->subDay() : $date->addDay();
                $label = $date->format('F j, Y') . ' — Observed';
            }
            $out[] = compact('title', 'date', 'type', 'headline', 'short', 'accent', 'icon', 'label');
        }

        usort($out, fn ($a, $b) => $a['date'] <=> $b['date']);

        return $out;
    }
}