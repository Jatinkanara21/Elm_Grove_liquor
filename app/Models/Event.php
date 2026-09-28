<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPES = [
        'federal_holiday' => 'Federal Holiday',
        'national_holiday' => 'National Holiday',
        'seasonal_event' => 'Seasonal Event',
        'store_event' => 'Store Event',
        'promotion' => 'Promotion',
        'special_event' => 'Special Event',
    ];

    /** Commemorative events get respectful, non-promotional treatment in views. */
    public const COMMEMORATIVE_SLUGS = [
        'martin-luther-king-jr-day',
        'memorial-day',
        'juneteenth-national-independence-day',
        'veterans-day',
    ];

    protected $fillable = [
        'title', 'slug', 'headline', 'date_label', 'short_description', 'description',
        'event_date', 'end_date', 'event_type', 'hero_image', 'thumbnail_image', 'banner_image',
        'icon', 'accent_color', 'is_featured', 'is_published', 'show_on_homepage', 'sort_order',
        'meta_title', 'meta_description', 'button_text', 'button_url',
        'publish_from', 'publish_until', 'show_countdown',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'end_date' => 'date',
            'publish_from' => 'datetime',
            'publish_until' => 'datetime',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'show_on_homepage' => 'boolean',
            'show_countdown' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(fn (self $m) => $m->slug = $m->slug ?: Str::slug($m->title));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /* ---- Visibility: published + optional schedule window ---- */
    public function scopeVisible($q)
    {
        $now = now();

        return $q->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('publish_from')->orWhere('publish_from', '<=', $now))
            ->where(fn ($q) => $q->whereNull('publish_until')->orWhere('publish_until', '>=', $now));
    }

    /* ---- Date logic: an event's last day is COALESCE(end_date, event_date) ---- */
    public function scopeUpcoming($q)
    {
        return $q->whereRaw('COALESCE(end_date, event_date) >= ?', [today()->toDateString()]);
    }

    public function scopePast($q)
    {
        return $q->whereRaw('COALESCE(end_date, event_date) < ?', [today()->toDateString()]);
    }

    public function scopeInYear($q, int $year)
    {
        return $q->whereYear('event_date', $year);
    }

    public function scopeSearch($q, ?string $term)
    {
        return $q->when($term, fn ($q, $s) => $q->where(fn ($q) => $q
            ->where('title', 'like', "%{$s}%")
            ->orWhere('short_description', 'like', "%{$s}%")
            ->orWhere('description', 'like', "%{$s}%")
            ->orWhere('event_type', 'like', '%' . Str::snake($s) . '%')));
    }

    /** Homepage "What's Coming Up": next N visible events, computed from today's date. */
    public function scopeNextUp($q, int $limit = 3)
    {
        return $q->visible()->upcoming()->orderBy('event_date')->orderBy('sort_order')->limit($limit);
    }

    /** upcoming | today | past */
    public function getStatusAttribute(): string
    {
        $today = today();
        $start = $this->event_date->copy()->startOfDay();
        $end = ($this->end_date ?? $this->event_date)->copy()->startOfDay();

        return match (true) {
            $today->lt($start) => 'upcoming',
            $today->lte($end) => 'today',
            default => 'past',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->event_type] ?? Str::headline($this->event_type);
    }

    public function getIsCommemorativeAttribute(): bool
    {
        return in_array($this->slug, self::COMMEMORATIVE_SLUGS, true);
    }

    public function getDisplayDateAttribute(): string
    {
        if ($this->date_label) {
            return $this->date_label;
        }

        return $this->end_date && ! $this->end_date->isSameDay($this->event_date)
            ? $this->event_date->format('M j') . ' – ' . $this->end_date->format('M j, Y')
            : $this->event_date->format('l, F j, Y');
    }

    public function getIsScheduledAttribute(): bool
    {
        return $this->is_published && $this->publish_from && $this->publish_from->isFuture();
    }
}