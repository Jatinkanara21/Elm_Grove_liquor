<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'address', 'city', 'state', 'zip', 'phone', 'email', 'opening_hours',
        'latitude', 'longitude', 'google_maps_url', 'image', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    protected static function booted(): void
    {
        static::saving(fn (self $m) => $m->slug = $m->slug ?: Str::slug($m->name));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function getFullAddressAttribute(): string
    {
        return collect([$this->address, $this->city, trim("{$this->state} {$this->zip}")])
            ->filter()->implode(', ');
    }

    public function getDirectionsUrlAttribute(): string
    {
        return $this->google_maps_url
            ?: 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($this->full_address);
    }
}