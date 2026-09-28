<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'brand', 'short_description', 'description', 'image',
        'type', 'country', 'region', 'alcohol_percentage', 'bottle_size', 'is_featured', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'alcohol_percentage' => 'decimal:1',
        ];
    }

    protected static function booted(): void
    {
        static::saving(fn (self $m) => $m->slug = $m->slug ?: Str::slug($m->brand . ' ' . $m->name));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeFeatured($q)
    {
        return $q->where('is_featured', true);
    }

    /** Search + filter for the public listing and its AJAX endpoint. */
    public function scopeFilter($q, array $f)
    {
        return $q
            ->when($f['search'] ?? null, fn ($q, $s) => $q->where(fn ($q) => $q
                ->where('name', 'like', "%{$s}%")
                ->orWhere('brand', 'like', "%{$s}%")
                ->orWhere('short_description', 'like', "%{$s}%")))
            ->when($f['category'] ?? null, fn ($q, $c) => $q->whereHas('category', fn ($q) => $q->where('slug', $c)))
            ->when($f['brand'] ?? null, fn ($q, $b) => $q->where('brand', $b))
            ->when($f['type'] ?? null, fn ($q, $t) => $q->where('type', $t));
    }
}